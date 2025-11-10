<?php

namespace App\Support;

use App\Models\Currency;

class Money
{
    /**
     * Cache of loaded currencies keyed by code.
     *
     * @var array<string, \App\Models\Currency>
     */
    protected static array $cache = [];

    /**
     * Resolve a currency model by code (falls back to default currency).
     */
    public static function currency(?string $code = null): Currency
    {
        $code = $code ? strtoupper($code) : null;

        if ($code && isset(self::$cache[$code])) {
            return self::$cache[$code];
        }

        if ($code) {
            $currency = Currency::where('code', $code)->first();
            if ($currency) {
                return self::$cache[$code] = $currency;
            }
        }

        if (!isset(self::$cache['__default'])) {
            $defaultCurrency = Currency::defaultCurrency();
            self::$cache['__default'] = $defaultCurrency;
            if ($defaultCurrency && $defaultCurrency->code) {
                self::$cache[strtoupper($defaultCurrency->code)] = $defaultCurrency;
            }
        }

        return self::$cache['__default'];
    }

    /**
     * Format an amount using the resolved currency.
     */
    public static function format($amount, ?string $currencyCode = null, bool $withSymbol = true): string
    {
        if ($amount === null || $amount === '') {
            return '';
        }

        $currency = self::currency($currencyCode);
        $symbol = $currency->symbol ?? $currency->code;
        $decimals = $currency->decimals ?? 2;

        $formatted = number_format((float) $amount, $decimals);

        return $withSymbol ? trim($symbol . ' ' . $formatted) : $formatted;
    }

    /**
     * Get the code used for formatting when none supplied.
     */
    public static function defaultCode(): string
    {
        return self::currency()->code;
    }
}

