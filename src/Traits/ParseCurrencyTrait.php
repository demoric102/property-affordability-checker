<?php

namespace App\Traits;

/**
 * Trait ParseCurrencyTrait
 *
 * Provides a method to parse currency strings into float values.
 */
trait ParseCurrencyTrait
{
    /**
     * Parse the currency string into a float value.
     *
     * @param string|null $amount The currency string (e.g., '£1,200.50')
     * @return float The parsed float value (e.g., 1200.50)
     */
    public function parseCurrency(?string $amount): float
    {
        if ($amount === null) {
            return 0.00;
        }
        return (float) str_replace(['£', ','], '', $amount);
    }
}