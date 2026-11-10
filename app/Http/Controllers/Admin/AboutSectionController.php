<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutSection;
use App\Models\AboutSectionCard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AboutSectionController extends Controller
{
    /**
     * Display a listing of the about sections.
     */
    public function index(Request $request): View
    {
        $query = AboutSection::query()->with('cards')->latest();

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

        $aboutSections = $query->paginate(10)->withQueryString();
        $activeCount = AboutSection::where('is_active', true)->count();

        return view('admin.about-section.index', compact('aboutSections', 'activeCount'));
    }

    /**
     * Show the form for creating a new about section.
     */
    public function create(): View
    {
        return view('admin.about-section.create');
    }

    /**
     * Store a newly created about section in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'is_active' => ['nullable'],
            'cards' => ['nullable', 'array'],
            'cards.*.title' => ['nullable', 'string', 'max:255'],
            'cards.*.description' => ['nullable', 'string'],
            'cards.*.icon_name' => ['nullable', 'string', 'max:100'],
            'cards.*.icon_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:512'],
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

        // Hanya 1 about section yang aktif: jika section ini aktif, nonaktifkan section lainnya
        if ($isActive) {
            AboutSection::where('is_active', true)->update([
                'is_active' => false,
                'updated_at' => now(),
            ]);
        }

        /** @var AboutSection $aboutSection */
        $aboutSection = AboutSection::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'is_active' => $isActive,
        ]);

        // Simpan multiple cards
        if ($request->has('cards') && is_array($request->input('cards'))) {
            $step = 1;
            foreach ($request->input('cards') as $index => $cardData) {
                $cardTitle = trim($cardData['title'] ?? '');
                $cardDesc = trim($cardData['description'] ?? '');
                $hasIconImage = $request->hasFile("cards.{$index}.icon_image");
                $iconName = trim($cardData['icon_name'] ?? '');

                if ($cardTitle !== '' || $cardDesc !== '') {
                    $iconImagePath = null;
                    if ($hasIconImage) {
                        $iconImagePath = $request->file("cards.{$index}.icon_image")->store('about-card-icons', 'public');
                    }

                    $aboutSection->cards()->create([
                        'title' => $cardTitle ?: 'Card '.$step,
                        'description' => $cardDesc,
                        'icon_name' => $iconName ?: null,
                        'icon_image' => $iconImagePath,
                        'steps' => $step,
                    ]);
                    $step++;
                }
            }
        }

        $message = $isActive
            ? 'Konten Tentang Kami berhasil disimpan dan ditampilkan di website.'
            : 'Konten Tentang Kami berhasil disimpan sebagai draf.';

        return redirect()->route('admin.about-sections.index')
            ->with('success', $message);
    }

    /**
     * Show the form for editing the specified about section.
     */
    public function edit(AboutSection $aboutSection): View
    {
        $aboutSection->load('cards');

        return view('admin.about-section.edit', compact('aboutSection'));
    }

    /**
     * Update the specified about section in storage.
     */
    public function update(Request $request, AboutSection $aboutSection): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'is_active' => ['nullable'],
            'cards' => ['nullable', 'array'],
            'cards.*.id' => ['nullable', 'integer'],
            'cards.*.title' => ['nullable', 'string', 'max:255'],
            'cards.*.description' => ['nullable', 'string'],
            'cards.*.icon_name' => ['nullable', 'string', 'max:100'],
            'cards.*.icon_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:512'],
            'cards.*.remove_icon_image' => ['nullable', 'boolean'],
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

        // Hanya 1 about section yang aktif: jika section ini aktif, nonaktifkan section lainnya
        if ($isActive) {
            AboutSection::where('id', '!=', $aboutSection->id)
                ->where('is_active', true)
                ->update([
                    'is_active' => false,
                    'updated_at' => now(),
                ]);
        }

        $aboutSection->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'is_active' => $isActive,
        ]);

        // Tangani sync cards
        $submittedCards = $request->input('cards', []);
        $existingCards = $aboutSection->cards()->get()->keyBy('id');
        $keptCardIds = [];

        if (is_array($submittedCards)) {
            $step = 1;
            foreach ($submittedCards as $index => $cardData) {
                $cardId = ! empty($cardData['id']) ? (int) $cardData['id'] : null;
                $cardTitle = trim($cardData['title'] ?? '');
                $cardDesc = trim($cardData['description'] ?? '');
                $hasIconImage = $request->hasFile("cards.{$index}.icon_image");
                $removeIconImage = ! empty($cardData['remove_icon_image']);
                $iconName = trim($cardData['icon_name'] ?? '');

                if ($cardId && $existingCards->has($cardId)) {
                    /** @var AboutSectionCard $card */
                    $card = $existingCards->get($cardId);
                    $iconImagePath = $card->icon_image;

                    // Handle icon image
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
                        $iconImagePath = $request->file("cards.{$index}.icon_image")->store('about-card-icons', 'public');
                    }

                    $card->update([
                        'title' => $cardTitle ?: 'Card '.$step,
                        'description' => $cardDesc,
                        'icon_name' => $iconName ?: null,
                        'icon_image' => $iconImagePath,
                        'steps' => $step,
                    ]);

                    $keptCardIds[] = $cardId;
                    $step++;
                } elseif ($cardTitle !== '' || $cardDesc !== '') {
                    $iconImagePath = null;
                    if ($hasIconImage) {
                        $iconImagePath = $request->file("cards.{$index}.icon_image")->store('about-card-icons', 'public');
                    }

                    $newCard = $aboutSection->cards()->create([
                        'title' => $cardTitle ?: 'Card '.$step,
                        'description' => $cardDesc,
                        'icon_name' => $iconName ?: null,
                        'icon_image' => $iconImagePath,
                        'steps' => $step,
                    ]);

                    $keptCardIds[] = $newCard->id;
                    $step++;
                }
            }
        }

        // Hapus card yang dibuang oleh user di form
        foreach ($existingCards as $existingId => $existingCard) {
            if (! in_array($existingId, $keptCardIds)) {
                if ($existingCard->icon_image && Storage::disk('public')->exists($existingCard->icon_image)) {
                    Storage::disk('public')->delete($existingCard->icon_image);
                }
                $existingCard->delete();
            }
        }

        $aboutSection->touch();

        $message = $isActive
            ? 'Konten Tentang Kami berhasil diperbarui dan ditampilkan di website.'
            : 'Konten Tentang Kami berhasil diperbarui.';

        return redirect()->route('admin.about-sections.index')
            ->with('success', $message);
    }

    /**
     * Remove the specified about section from storage.
     */
    public function destroy(AboutSection $aboutSection): RedirectResponse
    {
        // Hapus semua gambar card dan icon
        foreach ($aboutSection->cards as $card) {
            if ($card->icon_image && Storage::disk('public')->exists($card->icon_image)) {
                Storage::disk('public')->delete($card->icon_image);
            }
        }

        // Hapus gambar section lama jika ada
        if ($aboutSection->image && Storage::disk('public')->exists($aboutSection->image)) {
            Storage::disk('public')->delete($aboutSection->image);
        }

        $aboutSection->delete();

        return redirect()->route('admin.about-sections.index')
            ->with('success', 'Konten Tentang Kami berhasil dihapus.');
    }

    /**
     * Toggle the active status of the specified about section.
     */
    public function toggleStatus(AboutSection $aboutSection): RedirectResponse
    {
        $newStatus = ! $aboutSection->is_active;

        // Hanya 1 about section yang aktif: jika diaktifkan, nonaktifkan section lainnya
        if ($newStatus) {
            AboutSection::where('id', '!=', $aboutSection->id)
                ->where('is_active', true)
                ->update([
                    'is_active' => false,
                    'updated_at' => now(),
                ]);
        }

        $aboutSection->update([
            'is_active' => $newStatus,
        ]);
        $aboutSection->touch();

        $message = $newStatus
            ? 'Konten Tentang Kami berhasil diaktifkan dan ditampilkan di website.'
            : 'Konten Tentang Kami berhasil dinonaktifkan (disimpan sebagai draf).';

        return back()->with('success', $message);
    }
}
