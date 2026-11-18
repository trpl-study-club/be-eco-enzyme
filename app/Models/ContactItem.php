<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ContactItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_section_id',
        'type',
        'label',
        'value',
        'icon_name',
        'icon_image',
        'order',
        'is_active',
    ];

    protected $attributes = [
        'is_active' => true,
    ];

    protected $casts = [
        'order' => 'integer',
        'is_active' => 'boolean',
    ];

    protected $touches = ['contactSection'];

    /**
     * Bootstrap model hooks to keep contact item values consistently normalized.
     */
    protected static function booted(): void
    {
        static::saving(function (self $item): void {
            $item->value = self::normalizeValue($item->type, $item->value);
        });
    }

    /**
     * Determine whether the given contact type represents a WhatsApp or phone channel.
     */
    public static function isWhatsappType(?string $type): bool
    {
        return in_array(
            strtolower(trim((string) $type)),
            ['whatsapp', 'wa', 'phone', 'telepon', 'telp', 'hp'],
            true
        );
    }

    /**
     * Normalize a WhatsApp or Indonesian phone value into international digits (e.g. "6281234567890").
     */
    public static function normalizeWhatsappNumber(?string $value): string
    {
        $raw = trim((string) $value);
        if ($raw === '') {
            return '';
        }

        $candidate = self::extractPhoneFromWhatsappUrl($raw) ?? $raw;
        $digits = preg_replace('/\D+/', '', $candidate) ?? '';

        if ($digits === '') {
            return $raw;
        }

        if (str_starts_with($digits, '620')) {
            return '62'.substr($digits, 3);
        }

        if (str_starts_with($digits, '0')) {
            return '62'.substr($digits, 1);
        }

        if (str_starts_with($digits, '8')) {
            return '62'.$digits;
        }

        return $digits;
    }

    /**
     * Normalize a contact item's value according to its channel type.
     */
    public static function normalizeValue(?string $type, ?string $value): string
    {
        $trimmed = trim((string) $value);

        if (self::isWhatsappType($type)) {
            return self::normalizeWhatsappNumber($trimmed);
        }

        return $trimmed;
    }

    /**
     * Extract the target phone number when an admin pastes a wa.me or api.whatsapp.com URL.
     */
    private static function extractPhoneFromWhatsappUrl(string $raw): ?string
    {
        $urlCandidate = preg_match('#^(wa\.me|api\.whatsapp\.com)/#i', $raw)
            ? 'https://'.$raw
            : $raw;

        if (! preg_match('#^https?://#i', $urlCandidate)) {
            return null;
        }

        $parts = parse_url($urlCandidate);
        if (! is_array($parts)) {
            return null;
        }

        $host = strtolower($parts['host'] ?? '');
        if (! str_contains($host, 'wa.me') && ! str_contains($host, 'whatsapp.com')) {
            return null;
        }

        if (! empty($parts['query'])) {
            parse_str($parts['query'], $query);
            if (! empty($query['phone']) && is_string($query['phone'])) {
                return $query['phone'];
            }
        }

        if (! empty($parts['path'])) {
            $segment = trim(explode('/', ltrim($parts['path'], '/'))[0] ?? '');
            if ($segment !== '' && preg_match('/\d/', $segment)) {
                return $segment;
            }
        }

        return null;
    }

    public function contactSection(): BelongsTo
    {
        return $this->belongsTo(ContactSection::class);
    }

    /**
     * Get the full URL for the custom icon image.
     */
    public function getIconImageUrlAttribute(): ?string
    {
        if (! $this->icon_image) {
            return null;
        }

        return Storage::disk('public')->url($this->icon_image);
    }
}
