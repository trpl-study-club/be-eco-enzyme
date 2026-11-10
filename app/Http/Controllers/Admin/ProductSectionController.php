<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductSectionController extends Controller
{
    /**
     * Display a listing of individual products.
     */
    public function index(Request $request): View
    {
        $query = Product::query()->with('detailImages')->orderBy('order')->orderBy('id');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('detail', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('price', 'like', "%{$search}%");
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

        $products = $query->paginate(12)->withQueryString();
        $totalProducts = Product::count();
        $activeCount = Product::where('is_active', true)->count();
        $inactiveCount = Product::where('is_active', false)->count();

        return view('admin.product-section.index', compact(
            'products',
            'totalProducts',
            'activeCount',
            'inactiveCount'
        ));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create(): View
    {
        return view('admin.product-section.create');
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'string', 'max:255'],
            'detail' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'detail_images' => ['nullable', 'array', 'max:5'],
            'detail_images.*' => ['image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ], [
            'detail_images.max' => 'Setiap produk maksimal memiliki 5 foto tambahan.',
            'detail_images.*.image' => 'Foto tambahan harus berupa file gambar.',
            'detail_images.*.mimes' => 'Foto tambahan harus berformat jpeg, png, jpg, atau webp.',
            'detail_images.*.max' => 'Ukuran foto tambahan maksimal 2MB per file.',
        ]);

        $action = $request->input('action');
        if ($action === 'draft') {
            $isActive = false;
        } elseif ($action === 'publish') {
            $isActive = true;
        } else {
            $isActive = $request->has('is_active') ? $request->boolean('is_active') : true;
        }

        $detailText = trim((string) ($validated['detail'] ?? $validated['description'] ?? ''));
        $nextOrder = ((int) Product::max('order')) + 1;

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('product-images', 'public');
        }

        /** @var Product $product */
        $product = Product::create([
            'name' => trim($validated['name']),
            'price' => trim($validated['price']),
            'detail' => $detailText !== '' ? $detailText : null,
            'description' => $detailText !== '' ? $detailText : null,
            'image' => $imagePath,
            'order' => $nextOrder,
            'is_active' => $isActive,
        ]);

        if ($request->hasFile('detail_images')) {
            $detailImages = $request->file('detail_images');
            if (is_array($detailImages)) {
                $detailImages = array_slice($detailImages, 0, 5);
                $detailOrder = 1;
                foreach ($detailImages as $detailImgFile) {
                    $detailPath = $detailImgFile->store('product-detail-images', 'public');
                    $product->detailImages()->create([
                        'image' => $detailPath,
                        'order' => $detailOrder++,
                    ]);
                }
            }
        }

        $message = $isActive
            ? 'Produk berhasil ditambahkan dan ditampilkan di website.'
            : 'Produk berhasil ditambahkan dengan status Nonaktif.';

        return redirect()->route('admin.product-sections.index')
            ->with('success', $message);
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product): View
    {
        $product->load('detailImages');

        return view('admin.product-section.edit', compact('product'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'string', 'max:255'],
            'detail' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'remove_image' => ['nullable', 'boolean'],
            'detail_images' => ['nullable', 'array', 'max:5'],
            'detail_images.*' => ['image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'remove_detail_images' => ['nullable', 'array'],
            'remove_detail_images.*' => ['integer'],
        ], [
            'detail_images.max' => 'Setiap produk maksimal memiliki 5 foto tambahan.',
            'detail_images.*.image' => 'Foto tambahan harus berupa file gambar.',
            'detail_images.*.mimes' => 'Foto tambahan harus berformat jpeg, png, jpg, atau webp.',
            'detail_images.*.max' => 'Ukuran foto tambahan maksimal 2MB per file.',
        ]);

        $action = $request->input('action');
        if ($action === 'draft') {
            $isActive = false;
        } elseif ($action === 'publish') {
            $isActive = true;
        } else {
            $isActive = $request->boolean('is_active');
        }

        $imagePath = $product->image;

        if ($request->boolean('remove_image') && $imagePath) {
            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = null;
        }

        if ($request->hasFile('image')) {
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('product-images', 'public');
        }

        $detailText = trim((string) ($validated['detail'] ?? $validated['description'] ?? ''));

        $product->update([
            'name' => trim($validated['name']),
            'price' => trim($validated['price']),
            'detail' => $detailText !== '' ? $detailText : null,
            'description' => $detailText !== '' ? $detailText : null,
            'image' => $imagePath,
            'is_active' => $isActive,
        ]);

        $removedDetailImageIds = $validated['remove_detail_images'] ?? [];
        if (! empty($removedDetailImageIds) && is_array($removedDetailImageIds)) {
            $imagesToDelete = $product->detailImages()->whereIn('id', $removedDetailImageIds)->get();
            foreach ($imagesToDelete as $imgToDelete) {
                if ($imgToDelete->image && Storage::disk('public')->exists($imgToDelete->image)) {
                    Storage::disk('public')->delete($imgToDelete->image);
                }
                $imgToDelete->delete();
            }
        }

        if ($request->hasFile('detail_images')) {
            $newDetailImages = $request->file('detail_images');
            if (is_array($newDetailImages)) {
                $currentCount = $product->detailImages()->count();
                $availableSlots = max(0, 5 - $currentCount);
                $imagesToAdd = array_slice($newDetailImages, 0, $availableSlots);
                $highestOrder = (int) $product->detailImages()->max('order');

                foreach ($imagesToAdd as $detailImgFile) {
                    $highestOrder++;
                    $detailPath = $detailImgFile->store('product-detail-images', 'public');
                    $product->detailImages()->create([
                        'image' => $detailPath,
                        'order' => $highestOrder,
                    ]);
                }
            }
        }

        $message = $isActive
            ? 'Produk berhasil diperbarui dan ditampilkan di website.'
            : 'Produk berhasil diperbarui dengan status Nonaktif.';

        return redirect()->route('admin.product-sections.index')
            ->with('success', $message);
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        foreach ($product->detailImages as $detailImage) {
            if ($detailImage->image && Storage::disk('public')->exists($detailImage->image)) {
                Storage::disk('public')->delete($detailImage->image);
            }
        }

        $product->delete();

        // Re-sequence remaining products order automatically
        $remainingProducts = Product::orderBy('order')->orderBy('id')->get();
        foreach ($remainingProducts as $index => $item) {
            $item->update(['order' => $index + 1]);
        }

        return redirect()->route('admin.product-sections.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * Toggle the active status of the specified product.
     */
    public function toggleStatus(Product $product): RedirectResponse
    {
        $newStatus = ! $product->is_active;

        $product->update([
            'is_active' => $newStatus,
        ]);

        $message = $newStatus
            ? "Produk \"{$product->name}\" berhasil diaktifkan dan ditampilkan di website."
            : "Produk \"{$product->name}\" berhasil dinonaktifkan dari website.";

        return back()->with('success', $message);
    }
}
