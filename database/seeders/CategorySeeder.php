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
            ['title' => 'Security', 'order' => 1],
            ['title' => 'Safety', 'order' => 2],
            ['title' => 'Updates', 'order' => 3],
            ['title' => 'Process', 'order' => 4],
            ['title' => 'Architecture', 'order' => 5],
            ['title' => 'Education', 'order' => 6],
            ['title' => 'Platform', 'order' => 7],
            ['title' => 'Cloud', 'order' => 8],
            ['title' => 'Testing', 'order' => 9],
            ['title' => 'Compliance', 'order' => 10],
            ['title' => 'Migration', 'order' => 11],
            ['title' => 'Research', 'order' => 12],
            ['title' => 'Sensors', 'order' => 13],
            ['title' => 'AI/ML', 'order' => 14],
            ['title' => 'Simulation', 'order' => 15],
            ['title' => 'Networking', 'order' => 16],
            ['title' => 'Optimization', 'order' => 17],
            ['title' => 'Integration', 'order' => 18],
            ['title' => 'Hardware', 'order' => 19],
            ['title' => 'Software', 'order' => 20],
            ['title' => 'Standards', 'order' => 21],
            ['title' => 'Support', 'order' => 22],
            ['title' => 'Technology', 'order' => 23],
            ['title' => 'Tools', 'order' => 24],
            ['title' => 'Diagnostics', 'order' => 25],
            ['title' => 'Data', 'order' => 26],
            ['title' => 'Development', 'order' => 27],
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
