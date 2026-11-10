<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\HowToOrderSectionResource;
use App\Models\HowToOrderSection;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class HowToOrderController extends Controller
{
    #[OA\Get(
        path: '/how-to-orders',
        summary: 'Data Cara Pemesanan',
        description: 'Menampilkan section cara pemesanan (how to order) yang aktif beserta langkah-langkahnya. Hanya mengembalikan 1 section aktif.',
        tags: ['How To Order'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Berhasil mengambil data',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'data', ref: '#/components/schemas/HowToOrderSection'),
                    ]
                )
            ),
        ]
    )]
    public function index(): HowToOrderSectionResource|JsonResponse
    {
        $howToOrderSection = HowToOrderSection::with('steps')
            ->where('is_active', true)
            ->first();

        if (! $howToOrderSection) {
            return response()->json(['data' => null]);
        }

        return new HowToOrderSectionResource($howToOrderSection);
    }
}
