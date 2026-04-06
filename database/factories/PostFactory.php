<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BlogPost>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tags = ['Laravel', 'PHP', 'Web', 'Backend', 'Programming', 'Tutorial'];

        return [
            'title' => $this->faker->sentence(6),
            'author' => $this->faker->name(),
            'read_time' => $this->faker->numberBetween(3, 15),
            'summary' => $this->faker->paragraph(),
            'content' => $this->faker->paragraphs(5, true),
            'tags' => $this->faker->randomElements($tags, rand(1, 3)),
            'status' => $this->faker->randomElement(['draft', 'published', "review"]),
            'category_id' => $this->faker->numberBetween(1, 4),
        ];
    }
}
