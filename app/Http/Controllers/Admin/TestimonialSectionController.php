<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TestimonialItem;
use App\Models\TestimonialSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TestimonialSectionController extends Controller
{
    /**
     * Display the Testimonial Hub.
     */
    public function index(Request $request): View
    {
        // Ensure there is a primary section record without forcing is_active to true
        $section = TestimonialSection::with('statistics')->where('is_active', true)->first()
            ?? TestimonialSection::with('statistics')->first();

        if (! $section) {
            $section = TestimonialSection::create([
                'title' => 'Apa Kata Mereka?',
                'is_active' => true,
            ]);
            $section->load('statistics');
        }

        // Search & pagination for testimonial items
        $query = $section->testimonials()->latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('quote', 'like', "%{$search}%");
            });
        }

        $testimonials = $query->paginate(10)->withQueryString();

        return view('admin.testimonial-section.index', compact('section', 'testimonials'));
    }

    /**
     * Store multiple testimonials in a single batch (Quick Batch Modal).
     */
    public function batchStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'items' => ['required', 'array', 'min:1'],
            'items.*.name' => ['required', 'string', 'max:255'],
            'items.*.location' => ['nullable', 'string', 'max:255'],
            'items.*.subtitle' => ['nullable', 'string', 'max:255'],
            'items.*.quote' => ['required', 'string'],
        ], [
            'items.required' => 'Setidaknya tambahkan satu ulasan testimoni.',
            'items.*.name.required' => 'Nama ulasan wajib diisi.',
            'items.*.quote.required' => 'Isi ulasan testimoni wajib diisi.',
        ]);

        $section = TestimonialSection::where('is_active', true)->first()
            ?? TestimonialSection::first()
            ?? TestimonialSection::create(['title' => 'Apa Kata Mereka?', 'is_active' => true]);

        $insertedCount = 0;

        DB::transaction(function () use ($validated, $section, &$insertedCount) {
            foreach ($validated['items'] as $itemData) {
                $name = trim($itemData['name'] ?? '');
                $quote = trim($itemData['quote'] ?? '');
                $location = trim($itemData['location'] ?? $itemData['subtitle'] ?? '');

                if ($name !== '' && $quote !== '') {
                    $section->testimonials()->create([
                        'name' => $name,
                        'location' => $location !== '' ? $location : null,
                        'quote' => $quote,
                    ]);
                    $insertedCount++;
                }
            }
            $section->touch();
        });

        return redirect()->route('admin.testimonials.index')
            ->with('success', "Berhasil menambahkan {$insertedCount} ulasan testimoni baru.");
    }

    /**
     * Update a single testimonial item.
     */
    public function updateItem(Request $request, TestimonialItem $testimonialItem): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'quote' => ['required', 'string'],
        ], [
            'name.required' => 'Nama pemberi testimoni wajib diisi.',
            'quote.required' => 'Isi ulasan testimoni wajib diisi.',
        ]);

        $locationVal = $validated['location'] ?? $validated['subtitle'] ?? null;

        $testimonialItem->update([
            'name' => trim($validated['name']),
            'location' => filled($locationVal) ? trim($locationVal) : null,
            'quote' => trim($validated['quote']),
        ]);

        $testimonialItem->touch();

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Ulasan testimoni berhasil diperbarui.');
    }

    /**
     * Delete a single testimonial item.
     */
    public function destroyItem(TestimonialItem $testimonialItem): RedirectResponse
    {
        $testimonialItem->delete();

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Ulasan testimoni berhasil dihapus.');
    }

    /**
     * Update header section title and impact statistics.
     */
    public function updateHeader(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'statistics' => ['nullable', 'array'],
            'statistics.*.id' => ['nullable', 'integer'],
            'statistics.*.value' => ['nullable', 'string', 'max:255'],
            'statistics.*.description' => ['nullable', 'string', 'max:255'],
        ], [
            'title.required' => 'Judul section testimonial wajib diisi.',
        ]);

        $section = TestimonialSection::where('is_active', true)->first()
            ?? TestimonialSection::first();

        if (! $section) {
            $section = TestimonialSection::create([
                'title' => $validated['title'],
                'is_active' => true,
            ]);
        }

        DB::transaction(function () use ($validated, $section, $request) {
            $isActive = ($request->has('has_is_active_toggle') || $request->has('is_active'))
                ? $request->boolean('is_active')
                : true;

            $section->update([
                'title' => trim($validated['title']),
                'is_active' => $isActive,
            ]);

            $submittedStats = $request->input('statistics', []);
            $existingStats = $section->statistics()->get()->keyBy('id');
            $keptStatIds = [];

            if (is_array($submittedStats)) {
                foreach ($submittedStats as $statData) {
                    $statId = ! empty($statData['id']) ? (int) $statData['id'] : null;
                    $val = trim($statData['value'] ?? '');
                    $desc = trim($statData['description'] ?? '');

                    if ($val !== '' || $desc !== '') {
                        if ($statId && $existingStats->has($statId)) {
                            $stat = $existingStats->get($statId);
                            $stat->update([
                                'value' => $val,
                                'description' => $desc,
                            ]);
                            $keptStatIds[] = $statId;
                        } else {
                            $newStat = $section->statistics()->create([
                                'value' => $val,
                                'description' => $desc,
                            ]);
                            $keptStatIds[] = $newStat->id;
                        }
                    }
                }
            }

            foreach ($existingStats as $existingId => $existingStat) {
                if (! in_array($existingId, $keptStatIds, true)) {
                    $existingStat->delete();
                }
            }

            $section->touch();
        });

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Pengaturan judul dan angka statistik berhasil diperbarui.');
    }

    /**
     * Legacy compatibility: create view
     */
    public function create(): View
    {
        return view('admin.testimonial-section.create');
    }

    /**
     * Legacy compatibility: edit view
     */
    public function edit(TestimonialSection $testimonialSection): View
    {
        $testimonialSection->load(['statistics', 'testimonials']);

        return view('admin.testimonial-section.edit', compact('testimonialSection'));
    }

    /**
     * Legacy compatibility: store section
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'is_active' => ['nullable'],
            'statistics' => ['nullable', 'array'],
            'testimonials' => ['nullable', 'array'],
        ]);

        $section = TestimonialSection::create([
            'title' => $validated['title'],
            'is_active' => true,
        ]);

        if ($request->has('statistics') && is_array($request->input('statistics'))) {
            foreach ($request->input('statistics') as $statData) {
                $val = trim($statData['value'] ?? '');
                $desc = trim($statData['description'] ?? '');
                if ($val !== '' || $desc !== '') {
                    $section->statistics()->create([
                        'value' => $val,
                        'description' => $desc,
                    ]);
                }
            }
        }

        if ($request->has('testimonials') && is_array($request->input('testimonials'))) {
            foreach ($request->input('testimonials') as $itemData) {
                $quote = trim($itemData['quote'] ?? '');
                $name = trim($itemData['name'] ?? '');
                $location = trim($itemData['location'] ?? $itemData['subtitle'] ?? '');
                if ($quote !== '' || $name !== '') {
                    $section->testimonials()->create([
                        'quote' => $quote,
                        'name' => $name,
                        'location' => $location !== '' ? $location : null,
                    ]);
                }
            }
        }

        return redirect()->route('admin.testimonials.index')->with('success', 'Konten testimoni berhasil disimpan.');
    }

    /**
     * Legacy compatibility: update section
     */
    public function update(Request $request, TestimonialSection $testimonialSection): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'is_active' => ['nullable'],
            'statistics' => ['nullable', 'array'],
            'testimonials' => ['nullable', 'array'],
        ]);

        $testimonialSection->update([
            'title' => $validated['title'],
            'is_active' => true,
        ]);

        return redirect()->route('admin.testimonials.index')->with('success', 'Konten testimoni berhasil diperbarui.');
    }

    /**
     * Legacy compatibility: destroy section
     */
    public function destroy(TestimonialSection $testimonialSection): RedirectResponse
    {
        $testimonialSection->delete();

        return redirect()->route('admin.testimonials.index')->with('success', 'Konten testimoni berhasil dihapus.');
    }

    /**
     * Toggle active status of the testimonial section.
     */
    public function toggleStatus(?TestimonialSection $testimonialSection = null): RedirectResponse
    {
        $section = $testimonialSection?->exists
            ? $testimonialSection
            : (TestimonialSection::where('is_active', true)->first() ?? TestimonialSection::first());

        if (! $section) {
            $section = TestimonialSection::create([
                'title' => 'Apa Kata Mereka?',
                'is_active' => false,
            ]);
            $newStatus = false;
        } else {
            $newStatus = ! $section->is_active;

            if ($newStatus) {
                TestimonialSection::where('id', '!=', $section->id)
                    ->where('is_active', true)
                    ->update([
                        'is_active' => false,
                        'updated_at' => now(),
                    ]);
            }

            $section->update([
                'is_active' => $newStatus,
            ]);
            $section->touch();
        }

        $message = $newStatus
            ? 'Bagian Testimoni berhasil diaktifkan dan ditampilkan di website.'
            : 'Bagian Testimoni berhasil dinonaktifkan (disimpan sebagai draf).';

        return back()->with('success', $message);
    }
}
