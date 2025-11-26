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

    /**
     * PRUEBA 1:
     * La página principal debe cargar con código 200.
     */
    public function test_home_page_is_accessible()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * PRUEBA 2:
     * La página de detalle muestra el título del curso.
     */
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

    /**
     * PRUEBA 3:
     * Un invitado no puede acceder a la página de creación de cursos.
     */
    public function test_guest_cannot_access_create_course_page()
    {
        $response = $this->get(route('courses.create'));

        $response->assertRedirect('/login');
    }

    /**
     * PRUEBA 4:
     * Un usuario autenticado con rol instructor puede crear un curso.
     */
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
