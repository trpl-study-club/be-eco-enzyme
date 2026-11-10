<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Attributes as OA;

class ProductSectionController extends Controller
{
    /**
     * Display a listing of products from the active product section.
     */
    #[OA\Get(
        path: '/products',
        summary: 'Daftar Produk aktif',
        description: 'Menampilkan semua produk dari product section yang berstatus aktif beserta gambar dan spesifikasinya, diurutkan berdasarkan order secara ascending.',
        tags: ['Product Section'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Berhasil mengambil data',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/Product')
                        ),
                    ]
                )
            ),
        ]
    )]
    public function index(): AnonymousResourceCollection
    {
        $products = Product::with('detailImages')
            ->whereHas('productSection', fn ($query) => $query->where('is_active', true))
            ->orderBy('order')
            ->get();

        return ProductResource::collection($products);
    }
}
