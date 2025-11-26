<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->paragraph(),
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'tags' => 'laravel,php',
            'content_table' => 'Contenido de prueba',
            'youtube_urls' => 'https://youtube.com/test',
            'published_at' => now(),
            'instructor_name' => $this->faker->name(),
        ];
    }
}
