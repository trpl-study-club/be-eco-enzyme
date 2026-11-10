<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContactSectionResource;
use App\Models\ContactSection;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class ContactController extends Controller
{
    #[OA\Get(
        path: '/contact',
        summary: 'Data Kontak',
        description: 'Menampilkan section kontak yang aktif beserta daftar item kontak (alamat, email, WhatsApp, dll). Hanya mengembalikan 1 section aktif.',
        tags: ['Contact'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Berhasil mengambil data',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'data', ref: '#/components/schemas/ContactSection'),
                    ]
                )
            ),
        ]
    )]
    public function index(): ContactSectionResource|JsonResponse
    {
        $contactSection = ContactSection::with('items')
            ->where('is_active', true)
            ->latest()
            ->first();

        if (! $contactSection) {
            return response()->json(['data' => null]);
        }

        return new ContactSectionResource($contactSection);
    }
}
