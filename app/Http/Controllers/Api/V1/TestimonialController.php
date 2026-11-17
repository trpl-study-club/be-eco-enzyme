<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TestimonialSectionResource;
use App\Models\TestimonialSection;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class TestimonialController extends Controller
{
    #[OA\Get(
        path: '/testimonials',
        summary: 'Data Testimoni',
        description: 'Menampilkan section testimoni beserta daftar statistik dan testimoni pelanggan. Jika status section nonaktif, judul dan statistik disembunyikan sedangkan daftar testimoni pelanggan tetap ditampilkan.',
        tags: ['Testimonial'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Berhasil mengambil data',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'data', ref: '#/components/schemas/TestimonialSection'),
                    ]
                )
            ),
        ]
    )]
    public function index(): TestimonialSectionResource|JsonResponse
    {
        $testimonialSection = TestimonialSection::with(['statistics', 'testimonials'])
            ->where('is_active', true)
            ->first()
            ?? TestimonialSection::with(['statistics', 'testimonials'])->first();

        if (! $testimonialSection) {
            return response()->json(['data' => null]);
        }

        return new TestimonialSectionResource($testimonialSection);
    }
}
