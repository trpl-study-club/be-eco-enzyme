<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HowToOrderSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class HowToOrderSectionController extends Controller
{
    public function index(Request $request): View
    {
        $query = HowToOrderSection::query()->with('steps')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'draft') {
                $query->where('is_active', false);
            }
        }

        $howToOrderSections = $query->paginate(10)->withQueryString();
        $activeCount = HowToOrderSection::where('is_active', true)->count();

        return view('admin.how-to-order.index', compact('howToOrderSections', 'activeCount'));
    }

    public function create(): View
    {
        return view('admin.how-to-order.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'button_text' => ['nullable', 'string', 'max:255'],
            'button_link' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable'],
            'steps' => ['nullable', 'array'],
            'steps.*.title' => ['nullable', 'string', 'max:255'],
            'steps.*.description' => ['nullable', 'string'],
            'steps.*.icon_name' => ['nullable', 'string', 'max:100'],
            'steps.*.icon_image' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp,svg', 'max:512'],
        ]);

        $action = $request->input('action');
        if ($action === 'draft') {
            $isActive = false;
        } elseif ($action === 'publish') {
            $isActive = true;
        } else {
            $isActive = $request->boolean('is_active');
        }

        $validated['is_active'] = $isActive;

        if ($isActive) {
            HowToOrderSection::where('is_active', true)->update([
                'is_active' => false,
                'updated_at' => now(),
            ]);
        }

        $section = HowToOrderSection::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'button_text' => $validated['button_text'] ?? null,
            'button_link' => $validated['button_link'] ?? null,
            'is_active' => $isActive,
        ]);

        if ($request->has('steps') && is_array($request->input('steps'))) {
            $order = 1;
            foreach ($request->input('steps') as $index => $stepData) {
                $stepTitle = trim($stepData['title'] ?? '');
                $stepDesc = trim($stepData['description'] ?? '');
                $iconName = trim($stepData['icon_name'] ?? '');
                $hasIconImage = $request->hasFile("steps.{$index}.icon_image");

                if ($stepTitle !== '' || $stepDesc !== '' || $iconName !== '' || $hasIconImage) {
                    $iconImagePath = null;
                    if ($hasIconImage) {
                        $iconImagePath = $request->file("steps.{$index}.icon_image")->store('how-to-order-step-icons', 'public');
                    }

                    $section->steps()->create([
                        'title' => $stepTitle ?: 'Langkah '.$order,
                        'description' => $stepDesc,
                        'icon_name' => $iconName ?: null,
                        'icon_image' => $iconImagePath,
                        'step_order' => $order,
                    ]);
                    $order++;
                }
            }
        }

        $message = $isActive
            ? 'Panduan Cara Pesan berhasil disimpan dan ditampilkan di website.'
            : 'Panduan Cara Pesan berhasil disimpan sebagai draf.';

        return redirect()->route('admin.how-to-orders.index')->with('success', $message);
    }

    public function edit(HowToOrderSection $howToOrder): View
    {
        $howToOrder->load('steps');

        return view('admin.how-to-order.edit', compact('howToOrder'));
    }

    public function update(Request $request, HowToOrderSection $howToOrder): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'button_text' => ['nullable', 'string', 'max:255'],
            'button_link' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable'],
            'steps' => ['nullable', 'array'],
            'steps.*.id' => ['nullable', 'integer'],
            'steps.*.title' => ['nullable', 'string', 'max:255'],
            'steps.*.description' => ['nullable', 'string'],
            'steps.*.icon_name' => ['nullable', 'string', 'max:100'],
            'steps.*.icon_image' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp,svg', 'max:512'],
            'steps.*.remove_icon_image' => ['nullable'],
        ]);

        $action = $request->input('action');
        if ($action === 'draft') {
            $isActive = false;
        } elseif ($action === 'publish') {
            $isActive = true;
        } else {
            $isActive = $request->boolean('is_active');
        }

        if ($isActive) {
            HowToOrderSection::where('id', '!=', $howToOrder->id)
                ->where('is_active', true)
                ->update([
                    'is_active' => false,
                    'updated_at' => now(),
                ]);
        }

        $howToOrder->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'button_text' => $validated['button_text'] ?? null,
            'button_link' => $validated['button_link'] ?? null,
            'is_active' => $isActive,
        ]);

        $submittedSteps = $request->input('steps', []);
        $existingSteps = $howToOrder->steps()->get()->keyBy('id');
        $keptStepIds = [];

        if (is_array($submittedSteps)) {
            $order = 1;
            foreach ($submittedSteps as $index => $stepData) {
                $stepId = ! empty($stepData['id']) ? (int) $stepData['id'] : null;
                $stepTitle = trim($stepData['title'] ?? '');
                $stepDesc = trim($stepData['description'] ?? '');
                $iconName = trim($stepData['icon_name'] ?? '');
                $hasIconImage = $request->hasFile("steps.{$index}.icon_image");
                $removeIconImage = ! empty($stepData['remove_icon_image']);

                if ($stepId && $existingSteps->has($stepId)) {
                    $step = $existingSteps->get($stepId);
                    $iconImagePath = $step->icon_image;

                    if ($removeIconImage && $iconImagePath) {
                        if (Storage::disk('public')->exists($iconImagePath)) {
                            Storage::disk('public')->delete($iconImagePath);
                        }
                        $iconImagePath = null;
                    }

                    if ($hasIconImage) {
                        if ($iconImagePath && Storage::disk('public')->exists($iconImagePath)) {
                            Storage::disk('public')->delete($iconImagePath);
                        }
                        $iconImagePath = $request->file("steps.{$index}.icon_image")->store('how-to-order-step-icons', 'public');
                    }

                    $step->update([
                        'title' => $stepTitle ?: 'Langkah '.$order,
                        'description' => $stepDesc,
                        'icon_name' => $iconName ?: null,
                        'icon_image' => $iconImagePath,
                        'step_order' => $order,
                    ]);
                    $keptStepIds[] = $stepId;
                    $order++;
                } elseif ($stepTitle !== '' || $stepDesc !== '' || $iconName !== '' || $hasIconImage) {
                    $iconImagePath = null;
                    if ($hasIconImage) {
                        $iconImagePath = $request->file("steps.{$index}.icon_image")->store('how-to-order-step-icons', 'public');
                    }

                    $newStep = $howToOrder->steps()->create([
                        'title' => $stepTitle ?: 'Langkah '.$order,
                        'description' => $stepDesc,
                        'icon_name' => $iconName ?: null,
                        'icon_image' => $iconImagePath,
                        'step_order' => $order,
                    ]);
                    $keptStepIds[] = $newStep->id;
                    $order++;
                }
            }
        }

        foreach ($existingSteps as $existingId => $existingStep) {
            if (! in_array($existingId, $keptStepIds)) {
                if ($existingStep->icon_image && Storage::disk('public')->exists($existingStep->icon_image)) {
                    Storage::disk('public')->delete($existingStep->icon_image);
                }
                $existingStep->delete();
            }
        }

        $howToOrder->touch();

        $message = $isActive
            ? 'Panduan Cara Pesan berhasil diperbarui dan ditampilkan di website.'
            : 'Panduan Cara Pesan berhasil disimpan sebagai draf.';

        return redirect()->route('admin.how-to-orders.index')->with('success', $message);
    }

    public function destroy(HowToOrderSection $howToOrder): RedirectResponse
    {
        foreach ($howToOrder->steps as $step) {
            if ($step->icon_image && Storage::disk('public')->exists($step->icon_image)) {
                Storage::disk('public')->delete($step->icon_image);
            }
        }

        $howToOrder->delete();

        return redirect()->route('admin.how-to-orders.index')->with('success', 'Panduan Cara Pesan berhasil dihapus.');
    }

    public function toggleStatus(HowToOrderSection $howToOrder): RedirectResponse
    {
        $newStatus = ! $howToOrder->is_active;

        if ($newStatus) {
            HowToOrderSection::where('id', '!=', $howToOrder->id)
                ->where('is_active', true)
                ->update([
                    'is_active' => false,
                    'updated_at' => now(),
                ]);
        }

        $howToOrder->update([
            'is_active' => $newStatus,
        ]);
        $howToOrder->touch();

        $message = $newStatus
            ? 'Panduan Cara Pesan berhasil diaktifkan dan ditampilkan di website.'
            : 'Panduan Cara Pesan berhasil dinonaktifkan (disimpan sebagai draf).';

        return back()->with('success', $message);
    }
}
