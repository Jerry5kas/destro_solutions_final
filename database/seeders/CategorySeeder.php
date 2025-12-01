<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['title' => 'Automotive', 'order' => 1],
            ['title' => 'SDV', 'order' => 2],
            ['title' => 'Avionics', 'order' => 3],
            ['title' => 'Railways', 'order' => 4],
            ['title' => 'Health Care and Medical Devices', 'order' => 5],
            ['title' => 'Automative Technology', 'order' => 6],
            ['title' => 'Case Studies and Success Stories', 'order' => 7],
            ['title' => 'Company Updates', 'order' => 8],
            ['title' => 'Destro', 'order' => 9],
            ['title' => 'Insustry Insights', 'order' => 10],
            ['title' => 'Technical Deep Dives', 'order' => 11],
            ['title' => 'Uncategorized', 'order' => 12],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['title' => $category['title']],
                [
                    'slug' => \Illuminate\Support\Str::slug($category['title']),
                    'order' => $category['order'],
                    'is_active' => true
                ]
            );
        }

        $this->command->info('Categories seeded successfully!');
    }
}
