<?php

use App\Helpers\CurrencyHelper;

if (! function_exists('formatRupiah')) {
    /**
     * Format a numeric value into Indonesian Rupiah (e.g. "11000" -> "Rp 11.000").
     */
    function formatRupiah(mixed $value): ?string
    {
        return CurrencyHelper::formatRupiah($value);
    }
}
