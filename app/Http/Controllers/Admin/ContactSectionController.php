<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactItem;
use App\Models\ContactSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ContactSectionController extends Controller
{
    /**
     * Display a listing of the contact sections.
     */
    public function index(Request $request): View
    {
        $query = ContactSection::query()->with('items')->latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $status = $request->input('status');
            if ($status === 'active') {
                $query->where('is_active', true);
            } elseif ($status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $contactSections = $query->paginate(10)->withQueryString();
        $activeCount = ContactSection::where('is_active', true)->count();

        return view('admin.contact-section.index', compact('contactSections', 'activeCount'));
    }

    /**
     * Show the form for creating a new contact section.
     */
    public function create(): View
    {
        return view('admin.contact-section.create');
    }

    /**
     * Store a newly created contact section in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable'],
            'items' => ['nullable', 'array'],
            'items.*.type' => ['nullable', 'string', 'max:50'],
            'items.*.label' => ['required', 'string', 'max:255'],
            'items.*.value' => ['required', 'string'],
            'items.*.icon_name' => ['nullable', 'string', 'max:100'],
            'items.*.icon_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:1024'],
        ], [
            'title.required' => 'Judul utama kontak wajib diisi.',
            'items.*.label.required' => 'Label item kontak wajib diisi.',
            'items.*.value.required' => 'Nilai item kontak wajib diisi.',
        ]);

        $action = $request->input('action');
        if ($action === 'draft') {
            $isActive = false;
        } elseif ($action === 'publish') {
            $isActive = true;
        } else {
            $isActive = $request->boolean('is_active');
        }

        DB::transaction(function () use ($validated, $request, $isActive) {
            // Hanya 1 section yang aktif di landing page
            if ($isActive) {
                ContactSection::where('is_active', true)->update([
                    'is_active' => false,
                    'updated_at' => now(),
                ]);
            }

            $contactSection = ContactSection::create([
                'title' => trim($validated['title']),
                'description' => filled($validated['description'] ?? null) ? trim($validated['description']) : null,
                'is_active' => $isActive,
            ]);

            if ($request->has('items') && is_array($request->input('items'))) {
                $order = 1;
                foreach ($request->input('items') as $index => $itemData) {
                    $label = trim($itemData['label'] ?? '');
                    $value = trim($itemData['value'] ?? '');
                    $type = trim($itemData['type'] ?? '');
                    $iconName = trim($itemData['icon_name'] ?? '');

                    if ($label !== '' && $value !== '') {
                        $iconImagePath = null;
                        if ($request->hasFile("items.{$index}.icon_image")) {
                            $iconImagePath = $request->file("items.{$index}.icon_image")->store('contact-icons', 'public');
                        }

                        $contactSection->items()->create([
                            'type' => $type ?: strtolower($label),
                            'label' => $label,
                            'value' => $value,
                            'icon_name' => $iconName ?: null,
                            'icon_image' => $iconImagePath,
                            'order' => $order++,
                        ]);
                    }
                }
            }
        });

        $message = $isActive
            ? 'Informasi Kontak berhasil disimpan dan ditampilkan di website.'
            : 'Informasi Kontak berhasil disimpan sebagai draf.';

        return redirect()->route('admin.contact-sections.index')
            ->with('success', $message);
    }

    /**
     * Show the form for editing the specified contact section.
     */
    public function edit(ContactSection $contactSection): View
    {
        $contactSection->load('items');

        return view('admin.contact-section.edit', compact('contactSection'));
    }

    /**
     * Update the specified contact section in storage.
     */
    public function update(Request $request, ContactSection $contactSection): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable'],
            'items' => ['nullable', 'array'],
            'items.*.id' => ['nullable', 'integer'],
            'items.*.type' => ['nullable', 'string', 'max:50'],
            'items.*.label' => ['required', 'string', 'max:255'],
            'items.*.value' => ['required', 'string'],
            'items.*.icon_name' => ['nullable', 'string', 'max:100'],
            'items.*.icon_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:1024'],
            'items.*.remove_icon_image' => ['nullable', 'boolean'],
        ], [
            'title.required' => 'Judul utama kontak wajib diisi.',
            'items.*.label.required' => 'Label item kontak (cth: LOKASI, EMAIL, WHATSAPP) wajib diisi.',
            'items.*.value.required' => 'Nilai item kontak wajib diisi.',
        ]);

        $action = $request->input('action');
        if ($action === 'draft') {
            $isActive = false;
        } elseif ($action === 'publish') {
            $isActive = true;
        } else {
            $isActive = $request->boolean('is_active');
        }

        DB::transaction(function () use ($validated, $contactSection, $request, $isActive) {
            // Hanya 1 section yang aktif di landing page
            if ($isActive) {
                ContactSection::where('id', '!=', $contactSection->id)
                    ->where('is_active', true)
                    ->update([
                        'is_active' => false,
                        'updated_at' => now(),
                    ]);
            }

            $contactSection->update([
                'title' => trim($validated['title']),
                'description' => filled($validated['description'] ?? null) ? trim($validated['description']) : null,
                'is_active' => $isActive,
            ]);

            $submittedItems = $request->input('items', []);
            $existingItems = $contactSection->items()->get()->keyBy('id');
            $keptItemIds = [];

            if (is_array($submittedItems)) {
                $order = 1;
                foreach ($submittedItems as $index => $itemData) {
                    $itemId = ! empty($itemData['id']) ? (int) $itemData['id'] : null;
                    $label = trim($itemData['label'] ?? '');
                    $value = trim($itemData['value'] ?? '');
                    $type = trim($itemData['type'] ?? '');
                    $iconName = trim($itemData['icon_name'] ?? '');
                    $hasIconImage = $request->hasFile("items.{$index}.icon_image");
                    $removeIconImage = ! empty($itemData['remove_icon_image']);

                    if ($label !== '' && $value !== '') {
                        if ($itemId && $existingItems->has($itemId)) {
                            /** @var ContactItem $item */
                            $item = $existingItems->get($itemId);
                            $iconImagePath = $item->icon_image;

                            if ($removeIconImage && $iconImagePath) {
                                Storage::disk('public')->delete($iconImagePath);
                                $iconImagePath = null;
                            }

                            if ($hasIconImage) {
                                if ($iconImagePath) {
                                    Storage::disk('public')->delete($iconImagePath);
                                }
                                $iconImagePath = $request->file("items.{$index}.icon_image")->store('contact-icons', 'public');
                            }

                            $item->update([
                                'label' => $label,
                                'value' => $value,
                                'type' => $type ?: strtolower($label),
                                'icon_name' => $iconName ?: null,
                                'icon_image' => $iconImagePath,
                                'order' => $order,
                            ]);
                            $keptItemIds[] = $itemId;
                        } else {
                            $iconImagePath = null;
                            if ($hasIconImage) {
                                $iconImagePath = $request->file("items.{$index}.icon_image")->store('contact-icons', 'public');
                            }

                            $newItem = $contactSection->items()->create([
                                'label' => $label,
                                'value' => $value,
                                'type' => $type ?: strtolower($label),
                                'icon_name' => $iconName ?: null,
                                'icon_image' => $iconImagePath,
                                'order' => $order,
                            ]);
                            $keptItemIds[] = $newItem->id;
                        }
                        $order++;
                    }
                }
            }

            // Hapus item yang tidak disertakan lagi
            foreach ($existingItems as $existingId => $existingItem) {
                if (! in_array($existingId, $keptItemIds, true)) {
                    if ($existingItem->icon_image) {
                        Storage::disk('public')->delete($existingItem->icon_image);
                    }
                    $existingItem->delete();
                }
            }

            $contactSection->touch();
        });

        $message = $isActive
            ? 'Informasi Kontak berhasil diperbarui dan ditampilkan di website.'
            : 'Informasi Kontak berhasil disimpan sebagai draf.';

        return redirect()->route('admin.contact-sections.index')
            ->with('success', $message);
    }

    /**
     * Remove the specified contact section from storage.
     */
    public function destroy(ContactSection $contactSection): RedirectResponse
    {
        foreach ($contactSection->items as $item) {
            if ($item->icon_image && Storage::disk('public')->exists($item->icon_image)) {
                Storage::disk('public')->delete($item->icon_image);
            }
        }

        $contactSection->delete();

        return redirect()->route('admin.contact-sections.index')
            ->with('success', 'Informasi Kontak berhasil dihapus.');
    }

    /**
     * Toggle the active status of the specified contact section.
     */
    public function toggleStatus(ContactSection $contactSection): RedirectResponse
    {
        $newStatus = ! $contactSection->is_active;

        if ($newStatus) {
            ContactSection::where('id', '!=', $contactSection->id)
                ->where('is_active', true)
                ->update([
                    'is_active' => false,
                    'updated_at' => now(),
                ]);
        }

        $contactSection->update([
            'is_active' => $newStatus,
        ]);
        $contactSection->touch();

        $message = $newStatus
            ? 'Informasi Kontak berhasil diaktifkan dan ditampilkan di website.'
            : 'Informasi Kontak berhasil dinonaktifkan (disimpan sebagai draf).';

        return back()->with('success', $message);
    }
}
