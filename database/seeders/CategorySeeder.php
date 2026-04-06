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
        $categories = ['Tech', 'Programming', 'Tutorial', 'News'];
        $data = array_map(fn ($category) => [
            'name' => $category,
        ], $categories);
        Category::insert($data);
    }
}

//  Class "Database\Seeders\Category" not found
