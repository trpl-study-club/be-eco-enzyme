<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\AboutSectionResource;
use App\Models\AboutSection;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Attributes as OA;

class AboutSectionController extends Controller
{
    /**
     * Display a listing of active about sections.
     */
    #[OA\Get(
        path: '/about',
        summary: 'Daftar About Section aktif',
        description: 'Menampilkan semua about section yang berstatus aktif beserta cards dan points-nya. Digunakan untuk menampilkan konten "Tentang Program" di landing page.',
        tags: ['About Section'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Berhasil mengambil data',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/AboutSection')
                        ),
                    ]
                )
            ),
        ]
    )]
    public function index(): AnonymousResourceCollection
    {
        $aboutSections = AboutSection::with('cards')
            ->where('is_active', true)
            ->latest()
            ->get();

        return AboutSectionResource::collection($aboutSections);
    }

    /**
     * Display the specified about section.
     */
    #[OA\Get(
        path: '/about/{id}',
        summary: 'Detail About Section',
        description: 'Menampilkan detail satu about section berdasarkan ID, termasuk cards dan points-nya.',
        tags: ['About Section'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'ID About Section',
                schema: new OA\Schema(type: 'integer', example: 1)
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Berhasil mengambil data',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'data', ref: '#/components/schemas/AboutSection'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Data tidak ditemukan'),
        ]
    )]
    public function show(AboutSection $aboutSection): AboutSectionResource
    {
        $aboutSection->load('cards');

        return new AboutSectionResource($aboutSection);
    }
}
