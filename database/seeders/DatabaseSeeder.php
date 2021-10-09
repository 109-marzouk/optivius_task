<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Profile;
use App\Models\Article;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Profile::factory()->count(50)->create();
        Article::factory()->count(1000)->create(); 
    }
}
