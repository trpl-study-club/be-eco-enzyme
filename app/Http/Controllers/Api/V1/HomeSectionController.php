<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\HomeSectionResource;
use App\Models\HomeSection;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Attributes as OA;

class HomeSectionController extends Controller
{
    /**
     * Display a listing of active home sections.
     */
    #[OA\Get(
        path: '/home',
        summary: 'Daftar Home Section aktif',
        description: 'Menampilkan semua home section yang berstatus aktif. Digunakan untuk menampilkan konten hero/banner pada landing page.',
        tags: ['Home Section'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Berhasil mengambil data',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/HomeSection')
                        ),
                    ]
                )
            ),
        ]
    )]
    public function index(): AnonymousResourceCollection
    {
        $homeSections = HomeSection::where('is_active', true)
            ->latest()
            ->get();

        return HomeSectionResource::collection($homeSections);
    }

    /**
     * Display the specified home section.
     */
    #[OA\Get(
        path: '/home/{id}',
        summary: 'Detail Home Section',
        description: 'Menampilkan detail satu home section berdasarkan ID.',
        tags: ['Home Section'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'ID Home Section',
                schema: new OA\Schema(type: 'integer', example: 1)
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Berhasil mengambil data',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'data', ref: '#/components/schemas/HomeSection'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Data tidak ditemukan'),
        ]
    )]
    public function show(HomeSection $homeSection): HomeSectionResource
    {
        return new HomeSectionResource($homeSection);
    }
}
