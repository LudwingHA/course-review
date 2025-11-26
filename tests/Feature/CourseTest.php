<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CourseTest extends TestCase
{
    use RefreshDatabase;
    public function test_home_page_is_accessible()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_course_detail_page_displays_course_title()
    {
        $instructor = User::factory()->create([
            'role' => 'instructor',
        ]);

        $category = Category::factory()->create();

        $course = Course::factory()->create([
            'title' => 'Curso Profesional de Laravel',
            'user_id' => $instructor->id,
            'category_id' => $category->id,
        ]);

        $response = $this->get(route('courses.show', $course->slug));

        $response->assertStatus(200);
        $response->assertSee('Curso Profesional de Laravel');
    }

    public function test_guest_cannot_access_create_course_page()
    {
        $response = $this->get(route('courses.create'));

        $response->assertRedirect('/login');
    }

  
    public function test_authenticated_user_can_create_a_course()
    {
        $instructor = User::factory()->create([
            'role' => 'instructor',
        ]);

        $category = Category::factory()->create();

        $this->actingAs($instructor);

        $response = $this->post(route('courses.store'), [
            'title' => 'Nuevo Curso Testing',
            'description' => 'Curso creado mediante PHPUnit',
            'category_id' => $category->id,
            'tags' => 'laravel,testing',
            'content_table' => 'Contenido de prueba',
            'youtube_urls' => 'https://youtube.com/example',
            'published_at' => now(),
        ]);

        $response->assertRedirect(route('courses.index'));

        $this->assertDatabaseHas('courses', [
            'title' => 'Nuevo Curso Testing',
            'user_id' => $instructor->id,
        ]);
    }
}

