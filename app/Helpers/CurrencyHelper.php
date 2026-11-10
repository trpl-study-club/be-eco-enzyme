<?php

namespace App\Helpers;

class CurrencyHelper
{
    /**
     * Normalize and format a numeric or currency value into Indonesian Rupiah (IDR).
     */
    public static function formatRupiah(mixed $value): ?string
    {
        if ($value === null || is_bool($value) || is_array($value) || is_object($value)) {
            return null;
        }

        if (is_int($value) || is_float($value)) {
            return self::formatNumber((float) $value);
        }

        $trimmed = trim((string) $value);

        if ($trimmed === '') {
            return null;
        }

        if (is_numeric($trimmed)) {
            return self::formatNumber((float) $trimmed);
        }

        if (preg_match('/^(?:rp\.?\s*)?(-?\d{1,3}(?:\.\d{3})+|-?\d+)(?:,\d{1,2}|,-)?$/i', $trimmed, $matches)) {
            $normalized = str_replace('.', '', $matches[1]);

            if (is_numeric($normalized)) {
                return self::formatNumber((float) $normalized);
            }
        }

        return null;
    }

    private static function formatNumber(float $amount): string
    {
        if ($amount < 0) {
            return '-Rp '.number_format(abs($amount), 0, ',', '.');
        }

        return 'Rp '.number_format($amount, 0, ',', '.');
    }
}
