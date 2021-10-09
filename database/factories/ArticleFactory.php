<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'user_id' => intVal($this->faker->numberBetween(1, 50)),
            'title' => json_encode([
                "en" => "In English: " . $this->faker->sentence,
                "ar" => "In Arabic: " . $this->faker->sentence
            ]),
            'content' => json_encode([
                "en" => "In English: " . $this->faker->paragraph,
                "ar" => "In Arabic: " . $this->faker->paragraph
            ]),
        ];
    }
}
