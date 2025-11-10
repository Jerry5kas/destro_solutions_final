<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Currency::query()->update(['is_default' => false]);

        $currencies = [
            [
                'code' => 'INR',
                'name' => 'Indian Rupee',
                'symbol' => '₹',
                'decimals' => 2,
                'exchange_rate' => 1,
                'is_default' => true,
            ],
            [
                'code' => 'EUR',
                'name' => 'Euro',
                'symbol' => '€',
                'decimals' => 2,
                'exchange_rate' => 0.92,
                'is_default' => false,
            ],
            [
                'code' => 'USD',
                'name' => 'US Dollar',
                'symbol' => '$',
                'decimals' => 2,
                'exchange_rate' => 1.10,
                'is_default' => false,
            ],
            [
                'code' => 'YEN',
                'name' => 'Japanese Yen',
                'symbol' => '¥',
                'decimals' => 0,
                'exchange_rate' => 158.50,
                'is_default' => false,
            ],
            [
                'code' => 'GER',
                'name' => 'German Mark',
                'symbol' => 'DM',
                'decimals' => 2,
                'exchange_rate' => 1.79,
                'is_default' => false,
            ],
        ];

        foreach ($currencies as $currency) {
            Currency::updateOrCreate(['code' => $currency['code']], $currency);
        }
    }
}

