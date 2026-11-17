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
     * Retrieve or initialize the primary ContactSection record.
     */
    private function getPrimarySection(): ContactSection
    {
        $section = ContactSection::with('items')->where('is_active', true)->first()
            ?? ContactSection::with('items')->latest()->first();

        if (! $section) {
            $section = ContactSection::create([
                'title' => 'Ada Pertanyaan? Kami Siap Membantu.',
                'description' => 'Ingin tahu lebih banyak tentang produk, cara pembuatan, atau peluang kolaborasi? Jangan ragu untuk menghubungi kami.',
                'is_active' => true,
            ]);
            $section->load('items');
        }

        return $section;
    }

    /**
     * Resolve canonical contact item type from explicit input or label/value hints.
     */
    private function resolveItemType(?string $explicitType, string $label, string $value): string
    {
        $trimmedType = strtolower(trim($explicitType ?? ''));
        if ($trimmedType !== '') {
            return $trimmedType;
        }

        $lowerLabel = strtolower($label);
        $trimmedValue = trim($value);
        $lowerValue = strtolower($trimmedValue);

        if (str_contains($lowerLabel, 'email') || str_contains($lowerLabel, 'mail') || filter_var($trimmedValue, FILTER_VALIDATE_EMAIL)) {
            return 'email';
        }

        if (str_contains($lowerLabel, 'lokasi') || str_contains($lowerLabel, 'alamat') || str_contains($lowerLabel, 'location') || str_contains($lowerLabel, 'kantor')) {
            return 'location';
        }

        if (str_contains($lowerLabel, 'instagram') || preg_match('/\big\b/', $lowerLabel)) {
            return 'instagram';
        }

        if (str_contains($lowerLabel, 'jam') || str_contains($lowerLabel, 'operasional') || str_contains($lowerLabel, 'jadwal') || str_contains($lowerLabel, 'hours')) {
            return 'hours';
        }

        if (
            str_contains($lowerLabel, 'whatsapp')
            || str_contains($lowerLabel, 'telepon')
            || str_contains($lowerLabel, 'phone')
            || preg_match('/\b(wa|hp|telp)\b/', $lowerLabel)
            || str_contains($lowerValue, 'wa.me/')
            || preg_match('/^\+?[0-9][0-9\s\-()]{6,19}$/', $trimmedValue)
        ) {
            return 'whatsapp';
        }

        return $lowerLabel;
    }

    /**
     * Display the unified Contact Hub.
     */
    public function index(Request $request): View
    {
        $section = $this->getPrimarySection();

        $query = $section->items()->orderBy('order')->orderBy('id');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('label', 'like', "%{$search}%")
                    ->orWhere('value', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        if ($request->filled('status')) {
            $status = $request->input('status');
            if ($status === 'active') {
                $query->where('is_active', true);
            } elseif ($status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $contactItems = $query->get();
        $activeCount = $section->items()->where('is_active', true)->count();
        $inactiveCount = $section->items()->where('is_active', false)->count();

        return view('admin.contact-section.index', compact(
            'section',
            'contactItems',
            'activeCount',
            'inactiveCount'
        ));
    }

    /**
     * Update the header title & description of the primary ContactSection.
     */
    public function updateHeader(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ], [
            'title.required' => 'Judul bagian kontak wajib diisi.',
        ]);

        $section = $this->getPrimarySection();

        $section->update([
            'title' => trim($validated['title']),
            'description' => filled($validated['description'] ?? null) ? trim($validated['description']) : null,
        ]);

        return redirect()->route('admin.contact-sections.index')
            ->with('success', 'Judul dan pengantar bagian kontak berhasil diperbarui.');
    }

    /**
     * Store a single contact channel item directly from the Contact Hub.
     */
    public function storeItem(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'label' => ['required', 'string', 'max:255'],
            'type' => ['nullable', 'string', 'max:50'],
            'value' => ['required', 'string'],
            'icon_name' => ['nullable', 'string', 'max:100'],
            'icon_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:1024'],
        ], [
            'label.required' => 'Nama saluran / label kontak wajib diisi.',
            'value.required' => 'Isi kontak (nomor / email / alamat) wajib diisi.',
        ]);

        $section = $this->getPrimarySection();
        $nextOrder = ((int) $section->items()->max('order')) + 1;

        $iconImagePath = null;
        if ($request->hasFile('icon_image')) {
            $iconImagePath = $request->file('icon_image')->store('contact-icons', 'public');
        }

        $label = trim($validated['label']);
        $value = trim($validated['value']);

        $section->items()->create([
            'label' => $label,
            'type' => $this->resolveItemType($validated['type'] ?? null, $label, $value),
            'value' => $value,
            'icon_name' => filled($validated['icon_name'] ?? null) ? trim($validated['icon_name']) : null,
            'icon_image' => $iconImagePath,
            'order' => $nextOrder,
            'is_active' => $request->has('is_active') ? $request->boolean('is_active') : true,
        ]);

        $section->touch();

        return redirect()->route('admin.contact-sections.index')
            ->with('success', "Saluran kontak \"{$label}\" berhasil ditambahkan.");
    }

    /**
     * Update a single contact channel item.
     */
    public function updateItem(Request $request, ContactItem $contactItem): RedirectResponse
    {
        $validated = $request->validate([
            'label' => ['required', 'string', 'max:255'],
            'type' => ['nullable', 'string', 'max:50'],
            'value' => ['required', 'string'],
            'icon_name' => ['nullable', 'string', 'max:100'],
            'icon_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:1024'],
            'remove_icon_image' => ['nullable', 'boolean'],
        ], [
            'label.required' => 'Nama saluran / label kontak wajib diisi.',
            'value.required' => 'Isi kontak (nomor / email / alamat) wajib diisi.',
        ]);

        $iconImagePath = $contactItem->icon_image;

        if ($request->boolean('remove_icon_image') && $iconImagePath) {
            if (Storage::disk('public')->exists($iconImagePath)) {
                Storage::disk('public')->delete($iconImagePath);
            }
            $iconImagePath = null;
        }

        if ($request->hasFile('icon_image')) {
            if ($iconImagePath && Storage::disk('public')->exists($iconImagePath)) {
                Storage::disk('public')->delete($iconImagePath);
            }
            $iconImagePath = $request->file('icon_image')->store('contact-icons', 'public');
        }

        $label = trim($validated['label']);
        $value = trim($validated['value']);

        $contactItem->update([
            'label' => $label,
            'type' => $this->resolveItemType($validated['type'] ?? null, $label, $value),
            'value' => $value,
            'icon_name' => filled($validated['icon_name'] ?? null) ? trim($validated['icon_name']) : null,
            'icon_image' => $iconImagePath,
        ]);

        $contactItem->touch();

        return redirect()->route('admin.contact-sections.index')
            ->with('success', "Saluran kontak \"{$label}\" berhasil diperbarui.");
    }

    /**
     * Remove a single contact channel item and re-sequence order.
     */
    public function destroyItem(ContactItem $contactItem): RedirectResponse
    {
        $label = $contactItem->label;
        $section = $contactItem->contactSection;

        if ($contactItem->icon_image && Storage::disk('public')->exists($contactItem->icon_image)) {
            Storage::disk('public')->delete($contactItem->icon_image);
        }

        $contactItem->delete();

        if ($section) {
            $remaining = $section->items()->orderBy('order')->orderBy('id')->get();
            foreach ($remaining as $index => $item) {
                $item->update(['order' => $index + 1]);
            }
            $section->touch();
        }

        return redirect()->route('admin.contact-sections.index')
            ->with('success', "Saluran kontak \"{$label}\" berhasil dihapus.");
    }

    /**
     * Toggle the active status of a single contact channel item.
     */
    public function toggleItemStatus(ContactItem $contactItem): RedirectResponse
    {
        $newStatus = ! $contactItem->is_active;

        $contactItem->update([
            'is_active' => $newStatus,
        ]);
        $contactItem->touch();

        $message = $newStatus
            ? "Saluran kontak \"{$contactItem->label}\" berhasil diaktifkan dan ditampilkan di website."
            : "Saluran kontak \"{$contactItem->label}\" berhasil dinonaktifkan dari website.";

        return back()->with('success', $message);
    }

    /**
     * Show the form for creating a new contact section (legacy support).
     */
    public function create(): View
    {
        return view('admin.contact-section.create');
    }

    /**
     * Store a newly created contact section in storage (legacy support).
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
                            'type' => $this->resolveItemType($type, $label, $value),
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
     * Show the form for editing the specified contact section (legacy support).
     */
    public function edit(ContactSection $contactSection): View
    {
        $contactSection->load('items');

        return view('admin.contact-section.edit', compact('contactSection'));
    }

    /**
     * Update the specified contact section in storage (legacy support).
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
                                'type' => $this->resolveItemType($type, $label, $value),
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
                                'type' => $this->resolveItemType($type, $label, $value),
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
     * Remove the specified contact section from storage (legacy support).
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
     * Toggle the active status of the contact section.
     */
    public function toggleStatus(?ContactSection $contactSection = null): RedirectResponse
    {
        $section = ($contactSection && $contactSection->exists)
            ? $contactSection
            : $this->getPrimarySection();

        $newStatus = ! $section->is_active;

        if ($newStatus) {
            ContactSection::where('id', '!=', $section->id)
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

        $message = $newStatus
            ? 'Informasi Kontak berhasil diaktifkan dan ditampilkan di website.'
            : 'Informasi Kontak berhasil dinonaktifkan dari website.';

        return back()->with('success', $message);
    }
}
