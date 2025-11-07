<?php

namespace Database\Seeders;

use App\Models\ContentItem;
use App\Models\Category;
use Illuminate\Database\Seeder;

class UpdateContentItemsCategoriesSeeder extends Seeder
{
    /**
     * Update existing content items with their categories based on title matching.
     */
    public function run(): void
    {
        // Load all categories into a map
        $categoriesMap = Category::pluck('id', 'title')->toArray();
        
        // Define category mappings for content items based on their titles/descriptions
        // This is a fallback for items that don't have categories set
        $categoryMappings = [
            // Quantum items
            'quantum' => [
                'Quantum Computing' => 'Research',
                'Quantum Sensors' => 'Sensors',
                'Quantum Cryptography' => 'Security',
                'Quantum Machine Learning' => 'AI/ML',
                'Quantum Simulation' => 'Simulation',
                'Quantum Networking' => 'Networking',
                'Quantum Error Correction' => 'Research',
                'Quantum Optimization' => 'Optimization',
                'Quantum AI Integration' => 'Integration',
                'Quantum Hardware' => 'Hardware',
                'Quantum Software' => 'Software',
                'Quantum Standards' => 'Standards',
            ],
            // Services items
            'services' => [
                'Cybersecurity' => 'Security',
                'Functional Safety' => 'Safety',
                'OTA Update' => 'Updates',
                'ASPICE' => 'Process',
                'AUTOSAR' => 'Architecture',
                'E/E Architecture' => 'Architecture',
                'Testing' => 'Testing',
                'Training' => 'Education',
                'SDV' => 'Platform',
                'Cloud' => 'Cloud',
                'Compliance' => 'Compliance',
                'Legacy System' => 'Support',
            ],
            // Products items
            'products' => [
                'Secure Gateway' => 'Hardware',
                'OTA Update Manager' => 'Software',
                'Safety Analysis' => 'Software',
                'AUTOSAR Configuration' => 'Software',
                'Cybersecurity Monitor' => 'Software',
                'SDV Middleware' => 'Platform',
                'Test Automation' => 'Testing',
                'Cloud Analytics' => 'Cloud',
                'Compliance Manager' => 'Software',
                'Vehicle Simulator' => 'Simulation',
                'Diagnostic Tool' => 'Tools',
                'API Gateway' => 'Platform',
            ],
            // Training items
            'training' => [
                'ISO 26262' => 'Safety',
                'ISO 21434' => 'Security',
                'AUTOSAR' => 'Architecture',
                'ASPICE' => 'Process',
                'OTA Update' => 'Updates',
                'SDV' => 'Platform',
                'E/E Architecture' => 'Architecture',
                'Automotive Testing' => 'Testing',
                'Cloud Integration' => 'Cloud',
                'Cybersecurity Testing' => 'Security',
                'Compliance' => 'Compliance',
                'Advanced AUTOSAR' => 'Architecture',
            ],
            // Blog items
            'blog' => [
                'Software Defined Vehicles' => 'Technology',
                'Cybersecurity' => 'Security',
                'ISO 26262' => 'Standards',
                'OTA Updates' => 'Technology',
                'AUTOSAR' => 'Architecture',
                'E/E Architecture' => 'Architecture',
                'ASPICE' => 'Process',
                'Cloud Services' => 'Cloud',
                'Testing Strategies' => 'Testing',
                'Quantum Computing' => 'Technology',
                'Compliance' => 'Compliance',
                'Legacy System' => 'Migration',
            ],
        ];
        
        $updated = 0;
        $notFound = 0;
        
        // Get all content items without categories
        $itemsWithoutCategories = ContentItem::whereNull('category_id')->get();
        
        foreach ($itemsWithoutCategories as $item) {
            $categoryId = null;
            
            // Try to find category from the item's title
            foreach ($categoryMappings[$item->type] ?? [] as $keyword => $categoryName) {
                if (stripos($item->title, $keyword) !== false) {
                    if (isset($categoriesMap[$categoryName])) {
                        $categoryId = $categoriesMap[$categoryName];
                        break;
                    }
                }
            }
            
            // If still not found, try to match by common patterns
            if (!$categoryId) {
                $title = strtolower($item->title);
                $description = strtolower($item->description ?? '');
                
                // Pattern matching
                if (stripos($title, 'security') !== false || stripos($description, 'security') !== false) {
                    $categoryId = $categoriesMap['Security'] ?? null;
                } elseif (stripos($title, 'safety') !== false || stripos($description, 'safety') !== false) {
                    $categoryId = $categoriesMap['Safety'] ?? null;
                } elseif (stripos($title, 'ota') !== false || stripos($title, 'update') !== false) {
                    $categoryId = $categoriesMap['Updates'] ?? null;
                } elseif (stripos($title, 'autosar') !== false || stripos($title, 'architecture') !== false) {
                    $categoryId = $categoriesMap['Architecture'] ?? null;
                } elseif (stripos($title, 'testing') !== false || stripos($title, 'test') !== false) {
                    $categoryId = $categoriesMap['Testing'] ?? null;
                } elseif (stripos($title, 'cloud') !== false) {
                    $categoryId = $categoriesMap['Cloud'] ?? null;
                } elseif (stripos($title, 'compliance') !== false) {
                    $categoryId = $categoriesMap['Compliance'] ?? null;
                } elseif (stripos($title, 'training') !== false || stripos($title, 'education') !== false) {
                    $categoryId = $categoriesMap['Education'] ?? null;
                } elseif (stripos($title, 'platform') !== false || stripos($title, 'sdv') !== false) {
                    $categoryId = $categoriesMap['Platform'] ?? null;
                } elseif (stripos($title, 'quantum') !== false) {
                    $categoryId = $categoriesMap['Research'] ?? null;
                } elseif (stripos($title, 'software') !== false) {
                    $categoryId = $categoriesMap['Software'] ?? null;
                } elseif (stripos($title, 'hardware') !== false) {
                    $categoryId = $categoriesMap['Hardware'] ?? null;
                } elseif (stripos($title, 'process') !== false || stripos($title, 'aspice') !== false) {
                    $categoryId = $categoriesMap['Process'] ?? null;
                } elseif (stripos($title, 'migration') !== false || stripos($title, 'legacy') !== false) {
                    $categoryId = $categoriesMap['Migration'] ?? null;
                } elseif (stripos($title, 'tool') !== false) {
                    $categoryId = $categoriesMap['Tools'] ?? null;
                } elseif (stripos($title, 'technology') !== false) {
                    $categoryId = $categoriesMap['Technology'] ?? null;
                }
            }
            
            if ($categoryId) {
                $item->update(['category_id' => $categoryId]);
                $updated++;
            } else {
                $notFound++;
                $this->command->warn("Could not assign category to: {$item->title} (Type: {$item->type})");
            }
        }
        
        $this->command->info("Updated {$updated} content items with categories.");
        if ($notFound > 0) {
            $this->command->warn("Could not assign categories to {$notFound} items.");
        }
    }
}

