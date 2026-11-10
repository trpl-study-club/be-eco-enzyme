<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductSectionController extends Controller
{
    /**
     * Display a listing of the product sections.
     */
    public function index(Request $request): View
    {
        $query = ProductSection::query()->with('products.detailImages')->latest();

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

        $productSections = $query->paginate(10)->withQueryString();
        $activeCount = ProductSection::where('is_active', true)->count();

        return view('admin.product-section.index', compact('productSections', 'activeCount'));
    }

    /**
     * Show the form for creating a new product section.
     */
    public function create(): View
    {
        return view('admin.product-section.create');
    }

    /**
     * Store a newly created product section in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'whatsapp_number' => ['nullable', 'string', 'max:50'],
            'is_active' => ['nullable'],
            'products' => ['nullable', 'array'],
            'products.*.name' => ['nullable', 'string', 'max:255'],
            'products.*.description' => ['nullable', 'string'],
            'products.*.benefit' => ['nullable', 'string', 'max:500'],
            'products.*.detail' => ['nullable', 'string'],
            'products.*.specs' => ['nullable', 'array'],
            'products.*.specs.netto' => ['nullable', 'string', 'max:255'],
            'products.*.specs.packaging' => ['nullable', 'string', 'max:255'],
            'products.*.specs.shape' => ['nullable', 'string', 'max:255'],
            'products.*.specs.suitability' => ['nullable', 'string', 'max:255'],
            'products.*.specs.stock' => ['nullable', 'string', 'max:255'],
            'products.*.specs.certification' => ['nullable', 'string', 'max:255'],
            'products.*.specs.ingredients' => ['nullable', 'string'],
            'products.*.specs.usage' => ['nullable', 'string'],
            'products.*.price' => ['nullable', 'string', 'max:255'],
            'products.*.image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'products.*.detail_images' => ['nullable', 'array', 'max:5'],
            'products.*.detail_images.*' => ['image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ], [
            'products.*.detail_images.max' => 'Setiap produk maksimal memiliki 5 detail gambar.',
            'products.*.detail_images.*.image' => 'Detail gambar harus berupa file gambar.',
            'products.*.detail_images.*.mimes' => 'Detail gambar harus berformat jpeg, png, jpg, atau webp.',
            'products.*.detail_images.*.max' => 'Ukuran detail gambar maksimal 2MB per file.',
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

        // Hanya 1 product section yang aktif: jika section ini aktif, nonaktifkan section lainnya
        if ($isActive) {
            ProductSection::where('is_active', true)->update([
                'is_active' => false,
                'updated_at' => now(),
            ]);
        }

        /** @var ProductSection $productSection */
        $productSection = ProductSection::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'whatsapp_number' => $validated['whatsapp_number'] ?? null,
            'is_active' => $isActive,
        ]);

        // Simpan multiple products
        if ($request->has('products') && is_array($request->input('products'))) {
            $order = 1;
            foreach ($request->input('products') as $index => $productData) {
                $productName = trim($productData['name'] ?? '');
                $productDesc = trim($productData['description'] ?? '');
                $productBenefit = trim($productData['benefit'] ?? '');
                $productDetail = trim($productData['detail'] ?? '');
                $productSpecs = $this->extractProductSpecs($productData);
                $hasSpecs = count(array_filter($productSpecs, fn ($v) => $v !== null)) > 0;
                $productPrice = trim($productData['price'] ?? '');
                $hasImage = $request->hasFile("products.{$index}.image");
                $hasDetailImages = $request->hasFile("products.{$index}.detail_images");

                if ($productName !== '' || $productDesc !== '' || $productBenefit !== '' || $productDetail !== '' || $hasSpecs || $productPrice !== '' || $hasImage || $hasDetailImages) {
                    $imagePath = null;
                    if ($hasImage) {
                        $imagePath = $request->file("products.{$index}.image")->store('product-images', 'public');
                    }

                    /** @var Product $newProduct */
                    $newProduct = $productSection->products()->create([
                        'name' => $productName ?: 'Product '.$order,
                        'description' => $productDesc,
                        'benefit' => $productBenefit ?: null,
                        'detail' => $productDetail ?: null,
                        'specs' => $productSpecs,
                        'price' => $productPrice,
                        'image' => $imagePath,
                        'order' => $order,
                    ]);

                    if ($hasDetailImages) {
                        $detailImages = $request->file("products.{$index}.detail_images");
                        if (is_array($detailImages)) {
                            $detailImages = array_slice($detailImages, 0, 5);
                            $detailOrder = 1;
                            foreach ($detailImages as $detailImgFile) {
                                $detailPath = $detailImgFile->store('product-detail-images', 'public');
                                $newProduct->detailImages()->create([
                                    'image' => $detailPath,
                                    'order' => $detailOrder++,
                                ]);
                            }
                        }
                    }

                    $order++;
                }
            }
        }

        $message = $isActive
            ? 'Katalog Produk berhasil disimpan dan ditampilkan di website.'
            : 'Katalog Produk berhasil disimpan sebagai draf.';

        return redirect()->route('admin.product-sections.index')
            ->with('success', $message);
    }

    /**
     * Show the form for editing the specified product section.
     */
    public function edit(ProductSection $productSection): View
    {
        $productSection->load('products.detailImages');

        return view('admin.product-section.edit', compact('productSection'));
    }

    /**
     * Update the specified product section in storage.
     */
    public function update(Request $request, ProductSection $productSection): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'whatsapp_number' => ['nullable', 'string', 'max:50'],
            'is_active' => ['nullable'],
            'products' => ['nullable', 'array'],
            'products.*.id' => ['nullable', 'integer'],
            'products.*.name' => ['nullable', 'string', 'max:255'],
            'products.*.description' => ['nullable', 'string'],
            'products.*.benefit' => ['nullable', 'string', 'max:500'],
            'products.*.detail' => ['nullable', 'string'],
            'products.*.specs' => ['nullable', 'array'],
            'products.*.specs.netto' => ['nullable', 'string', 'max:255'],
            'products.*.specs.packaging' => ['nullable', 'string', 'max:255'],
            'products.*.specs.shape' => ['nullable', 'string', 'max:255'],
            'products.*.specs.suitability' => ['nullable', 'string', 'max:255'],
            'products.*.specs.stock' => ['nullable', 'string', 'max:255'],
            'products.*.specs.certification' => ['nullable', 'string', 'max:255'],
            'products.*.specs.ingredients' => ['nullable', 'string'],
            'products.*.specs.usage' => ['nullable', 'string'],
            'products.*.price' => ['nullable', 'string', 'max:255'],
            'products.*.image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'products.*.remove_image' => ['nullable', 'boolean'],
            'products.*.detail_images' => ['nullable', 'array', 'max:5'],
            'products.*.detail_images.*' => ['image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'products.*.remove_detail_images' => ['nullable', 'array'],
            'products.*.remove_detail_images.*' => ['integer'],
        ], [
            'products.*.detail_images.max' => 'Setiap produk maksimal memiliki 5 detail gambar.',
            'products.*.detail_images.*.image' => 'Detail gambar harus berupa file gambar.',
            'products.*.detail_images.*.mimes' => 'Detail gambar harus berformat jpeg, png, jpg, atau webp.',
            'products.*.detail_images.*.max' => 'Ukuran detail gambar maksimal 2MB per file.',
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

        // Hanya 1 product section yang aktif: jika section ini aktif, nonaktifkan section lainnya
        if ($isActive) {
            ProductSection::where('id', '!=', $productSection->id)
                ->where('is_active', true)
                ->update([
                    'is_active' => false,
                    'updated_at' => now(),
                ]);
        }

        $productSection->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'whatsapp_number' => $validated['whatsapp_number'] ?? null,
            'is_active' => $isActive,
        ]);

        // Tangani sync products
        $submittedProducts = $request->input('products', []);
        $existingProducts = $productSection->products()->with('detailImages')->get()->keyBy('id');
        $keptProductIds = [];

        if (is_array($submittedProducts)) {
            $order = 1;
            foreach ($submittedProducts as $index => $productData) {
                $productId = ! empty($productData['id']) ? (int) $productData['id'] : null;
                $productName = trim($productData['name'] ?? '');
                $productDesc = trim($productData['description'] ?? '');
                $productBenefit = trim($productData['benefit'] ?? '');
                $productDetail = trim($productData['detail'] ?? '');
                $productSpecs = $this->extractProductSpecs($productData);
                $hasSpecs = count(array_filter($productSpecs, fn ($v) => $v !== null)) > 0;
                $productPrice = trim($productData['price'] ?? '');
                $hasImage = $request->hasFile("products.{$index}.image");
                $removeImage = ! empty($productData['remove_image']);
                $hasDetailImages = $request->hasFile("products.{$index}.detail_images");

                if ($productId && $existingProducts->has($productId)) {
                    /** @var Product $product */
                    $product = $existingProducts->get($productId);
                    $imagePath = $product->image;

                    if ($removeImage && $imagePath) {
                        if (Storage::disk('public')->exists($imagePath)) {
                            Storage::disk('public')->delete($imagePath);
                        }
                        $imagePath = null;
                    }

                    if ($hasImage) {
                        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                            Storage::disk('public')->delete($imagePath);
                        }
                        $imagePath = $request->file("products.{$index}.image")->store('product-images', 'public');
                    }

                    $product->update([
                        'name' => $productName ?: 'Product '.$order,
                        'description' => $productDesc,
                        'benefit' => $productBenefit ?: null,
                        'detail' => $productDetail ?: null,
                        'specs' => $productSpecs,
                        'price' => $productPrice,
                        'image' => $imagePath,
                        'order' => $order,
                    ]);

                    // Hapus detail images yang ditandai hapus
                    $removedDetailImageIds = $productData['remove_detail_images'] ?? [];
                    if (! empty($removedDetailImageIds) && is_array($removedDetailImageIds)) {
                        $imagesToDelete = $product->detailImages()->whereIn('id', $removedDetailImageIds)->get();
                        foreach ($imagesToDelete as $imgToDelete) {
                            if ($imgToDelete->image && Storage::disk('public')->exists($imgToDelete->image)) {
                                Storage::disk('public')->delete($imgToDelete->image);
                            }
                            $imgToDelete->delete();
                        }
                    }

                    // Tambah detail images baru (maksimal 5 total per produk)
                    if ($hasDetailImages) {
                        $newDetailImages = $request->file("products.{$index}.detail_images");
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

                    $keptProductIds[] = $productId;
                    $order++;
                } elseif ($productName !== '' || $productDesc !== '' || $productBenefit !== '' || $productDetail !== '' || $hasSpecs || $productPrice !== '' || $hasImage || $hasDetailImages) {
                    $imagePath = null;
                    if ($hasImage) {
                        $imagePath = $request->file("products.{$index}.image")->store('product-images', 'public');
                    }

                    /** @var Product $newProduct */
                    $newProduct = $productSection->products()->create([
                        'name' => $productName ?: 'Product '.$order,
                        'description' => $productDesc,
                        'benefit' => $productBenefit ?: null,
                        'detail' => $productDetail ?: null,
                        'specs' => $productSpecs,
                        'price' => $productPrice,
                        'image' => $imagePath,
                        'order' => $order,
                    ]);

                    if ($hasDetailImages) {
                        $newDetailImages = $request->file("products.{$index}.detail_images");
                        if (is_array($newDetailImages)) {
                            $imagesToAdd = array_slice($newDetailImages, 0, 5);
                            $detailOrder = 1;
                            foreach ($imagesToAdd as $detailImgFile) {
                                $detailPath = $detailImgFile->store('product-detail-images', 'public');
                                $newProduct->detailImages()->create([
                                    'image' => $detailPath,
                                    'order' => $detailOrder++,
                                ]);
                            }
                        }
                    }

                    $keptProductIds[] = $newProduct->id;
                    $order++;
                }
            }
        }

        // Hapus product yang dibuang oleh user di form
        foreach ($existingProducts as $existingId => $existingProduct) {
            if (! in_array($existingId, $keptProductIds)) {
                if ($existingProduct->image && Storage::disk('public')->exists($existingProduct->image)) {
                    Storage::disk('public')->delete($existingProduct->image);
                }
                foreach ($existingProduct->detailImages as $detailImage) {
                    if ($detailImage->image && Storage::disk('public')->exists($detailImage->image)) {
                        Storage::disk('public')->delete($detailImage->image);
                    }
                }
                $existingProduct->delete();
            }
        }

        $productSection->touch();

        $message = $isActive
            ? 'Katalog Produk berhasil diperbarui dan ditampilkan di website.'
            : 'Katalog Produk berhasil disimpan sebagai draf.';

        return redirect()->route('admin.product-sections.index')
            ->with('success', $message);
    }

    /**
     * Remove the specified product section from storage.
     */
    public function destroy(ProductSection $productSection): RedirectResponse
    {
        // Hapus semua gambar product dan detail gambar
        foreach ($productSection->products as $product) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            foreach ($product->detailImages as $detailImage) {
                if ($detailImage->image && Storage::disk('public')->exists($detailImage->image)) {
                    Storage::disk('public')->delete($detailImage->image);
                }
            }
        }

        $productSection->delete();

        return redirect()->route('admin.product-sections.index')
            ->with('success', 'Katalog Produk berhasil dihapus.');
    }

    /**
     * Toggle the active status of the specified product section.
     */
    public function toggleStatus(ProductSection $productSection): RedirectResponse
    {
        $newStatus = ! $productSection->is_active;

        // Hanya 1 product section yang aktif: jika diaktifkan, nonaktifkan section lainnya
        if ($newStatus) {
            ProductSection::where('id', '!=', $productSection->id)
                ->where('is_active', true)
                ->update([
                    'is_active' => false,
                    'updated_at' => now(),
                ]);
        }

        $productSection->update([
            'is_active' => $newStatus,
        ]);
        $productSection->touch();

        $message = $newStatus
            ? 'Katalog Produk berhasil diaktifkan dan ditampilkan di website.'
            : 'Katalog Produk berhasil dinonaktifkan (disimpan sebagai draf).';

        return back()->with('success', $message);
    }

    /**
     * @param  array<string, mixed>  $productData
     * @return array{netto: ?string, packaging: ?string, shape: ?string, suitability: ?string, stock: ?string, certification: ?string, ingredients: ?string, usage: ?string}
     */
    private function extractProductSpecs(array $productData): array
    {
        $rawSpecs = is_array($productData['specs'] ?? null) ? $productData['specs'] : [];
        $keys = ['netto', 'packaging', 'shape', 'suitability', 'stock', 'certification', 'ingredients', 'usage'];
        $specs = [];

        foreach ($keys as $key) {
            $val = isset($rawSpecs[$key]) ? trim((string) $rawSpecs[$key]) : '';
            $specs[$key] = $val !== '' ? $val : null;
        }

        return $specs;
    }
}
