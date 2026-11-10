<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class HomeSectionController extends Controller
{
    /**
     * Display a listing of the home sections.
     */
    public function index(Request $request): View
    {
        $query = HomeSection::query()->latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        }

        if ($request->filled('status')) {
            $status = $request->input('status');
            if ($status === 'active') {
                $query->where('is_active', true);
            } elseif ($status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $homeSections = $query->paginate(10)->withQueryString();
        $activeCount = HomeSection::where('is_active', true)->count();

        return view('admin.home-section.index', compact('homeSections', 'activeCount'));
    }

    /**
     * Show the form for creating a new home section.
     */
    public function create(): View
    {
        return view('admin.home-section.create');
    }

    /**
     * Store a newly created home section in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'button_one_text' => ['nullable', 'string', 'max:255'],
            'button_one_link' => ['nullable', 'string', 'max:255'],
            'button_two_text' => ['nullable', 'string', 'max:255'],
            'button_two_link' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable'],
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

        // Hanya 1 banner yang aktif: jika banner baru ini aktif, nonaktifkan (draft-kan) semua banner lainnya
        if ($isActive) {
            HomeSection::where('is_active', true)->update([
                'is_active' => false,
                'updated_at' => now(),
            ]);
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('home-sections', 'public');
        }

        HomeSection::create($validated);

        $message = $isActive
            ? 'Banner berhasil dipublikasikan.'
            : 'Banner berhasil disimpan sebagai draft.';

        return redirect()->route('admin.home-sections.index')
            ->with('success', $message);
    }

    /**
     * Show the form for editing the specified home section.
     */
    public function edit(HomeSection $homeSection): View
    {
        return view('admin.home-section.edit', compact('homeSection'));
    }

    /**
     * Update the specified home section in storage.
     */
    public function update(Request $request, HomeSection $homeSection): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'button_one_text' => ['nullable', 'string', 'max:255'],
            'button_one_link' => ['nullable', 'string', 'max:255'],
            'button_two_text' => ['nullable', 'string', 'max:255'],
            'button_two_link' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable'],
            'remove_image' => ['nullable', 'boolean'],
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

        // Hanya 1 banner yang aktif: jika banner ini aktif, nonaktifkan banner lainnya
        if ($isActive) {
            HomeSection::where('id', '!=', $homeSection->id)
                ->where('is_active', true)
                ->update([
                    'is_active' => false,
                    'updated_at' => now(),
                ]);
        }

        if ($request->hasFile('image')) {
            if ($homeSection->image && Storage::disk('public')->exists($homeSection->image)) {
                Storage::disk('public')->delete($homeSection->image);
            }
            $validated['image'] = $request->file('image')->store('home-sections', 'public');
        } elseif ($request->boolean('remove_image')) {
            if ($homeSection->image && Storage::disk('public')->exists($homeSection->image)) {
                Storage::disk('public')->delete($homeSection->image);
            }
            $validated['image'] = null;
        } else {
            unset($validated['image']);
        }

        unset($validated['remove_image']);
        $homeSection->update($validated);
        $homeSection->touch();

        $message = $isActive
            ? 'Banner berhasil diperbarui.'
            : 'Banner berhasil disimpan sebagai draft.';

        return redirect()->route('admin.home-sections.index')
            ->with('success', $message);
    }

    /**
     * Remove the specified home section from storage.
     */
    public function destroy(HomeSection $homeSection): RedirectResponse
    {
        if ($homeSection->image && Storage::disk('public')->exists($homeSection->image)) {
            Storage::disk('public')->delete($homeSection->image);
        }

        $homeSection->delete();

        return redirect()->route('admin.home-sections.index')
            ->with('success', 'Banner berhasil dihapus.');
    }

    /**
     * Toggle the active status of the specified home section.
     */
    public function toggleStatus(HomeSection $homeSection): RedirectResponse
    {
        $newStatus = ! $homeSection->is_active;

        // Hanya 1 banner yang aktif: jika diaktifkan, nonaktifkan banner lainnya
        if ($newStatus) {
            HomeSection::where('id', '!=', $homeSection->id)
                ->where('is_active', true)
                ->update([
                    'is_active' => false,
                    'updated_at' => now(),
                ]);
        }

        $homeSection->update([
            'is_active' => $newStatus,
        ]);
        $homeSection->touch();

        $message = $newStatus
            ? 'Banner berhasil diaktifkan.'
            : 'Banner berhasil dinonaktifkan.';

        return back()->with('success', $message);
    }
}
