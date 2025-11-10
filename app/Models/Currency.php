<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = [
        'code',
        'name',
        'symbol',
        'decimals',
        'exchange_rate',
        'is_default',
    ];

    protected $casts = [
        'decimals' => 'integer',
        'exchange_rate' => 'decimal:6',
        'is_default' => 'boolean',
    ];

    public static function defaultCurrency(): self
    {
        return static::where('is_default', true)->first()
            ?? static::first()
            ?? new static([
                'code' => 'INR',
                'name' => 'Indian Rupee',
                'symbol' => '₹',
                'decimals' => 2,
                'exchange_rate' => 1,
                'is_default' => true,
            ]);
    }
}

