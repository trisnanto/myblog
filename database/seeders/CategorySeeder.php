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
        Category::create([
            'name' => 'Uncategorized',
            'slug' => 'uncategorized',
            'color' => 'bg-red-100',
        ]);
        Category::create([
            'name' => 'Technology',
            'slug' => 'technology',
            'color' => 'bg-blue-100',
        ]);
        Category::create([
            'name' => 'Health',
            'slug' => 'health',
            'color' => 'bg-green-100',
        ]);
    }
}
