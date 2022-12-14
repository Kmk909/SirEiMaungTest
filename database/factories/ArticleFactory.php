<?php

namespace Database\Factories;

use App\Article;


use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'user_id' => rand(1, 2),
            'body'  => $this->faker->paragraph(),
            'category_id' => rand(1, 5),

        ];
    }
}
