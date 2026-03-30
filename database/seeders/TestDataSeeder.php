<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create categories
        Category::firstOrCreate(
            ['name' => 'Desserts'],
            ['description' => 'Sweet treats and desserts']
        );
        
        Category::firstOrCreate(
            ['name' => 'Salads'],
            ['description' => 'Fresh and healthy salads']
        );

        // Create tags
        Tag::firstOrCreate(['name' => 'Vegan']);
        Tag::firstOrCreate(['name' => 'Gluten-Free']);
    }
}
