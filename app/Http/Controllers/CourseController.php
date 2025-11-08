<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Mostrar lista de cursos del instructor autenticado
     */
    public function index()
    {
        $user = auth()->user();

        abort_unless($user->isInstructor(), 403, 'Solo los instructores pueden ver esto.');

        $courses = $user->courses()->with('category')->latest()->paginate(10);

        return view('courses.index', compact('courses'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        abort_unless(auth()->user()->isInstructor(), 403);

        $categories = Category::orderBy('name')->get();

        return view('courses.create', compact('categories'));
    }

    /**
     * Guardar nuevo curso
     */
    public function store(StoreCourseRequest $request)
    {
        $data = $request->validated();

        // Generar slug único por título
        $data['slug'] = Str::slug($data['title']);

        // Asignar datos del instructor
        $data['instructor_name'] = auth()->user()->name;
        $data['user_id'] = auth()->id();

        // Subida de imagen
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('courses', 'public');
        }

        Course::create($data);

        return redirect()
            ->route('courses.index')
            ->with('success', 'Curso creado correctamente.');
    }

    /**
     * Formulario de edición
     */
    public function edit(Course $course)
    {
        $this->authorize('update', $course);

        $categories = Category::orderBy('name')->get();

        return view('courses.edit', compact('course', 'categories'));
    }

    /**
     * Actualizar curso existente
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        $this->authorize('update', $course);

        $data = $request->validated();

        // Generar nuevo slug si cambia el título
        $data['slug'] = Str::slug($data['title']);

        // Reemplazar imagen si se sube una nueva
        if ($request->hasFile('image')) {
            if ($course->image) {
                Storage::disk('public')->delete($course->image);
            }
            $data['image'] = $request->file('image')->store('courses', 'public');
        }

        $course->update($data);

        return redirect()
            ->route('courses.index')
            ->with('success', 'Curso actualizado correctamente.');
    }

    /**
     * Eliminar curso
     */
    public function destroy(Course $course)
    {
        $this->authorize('delete', $course);

        if ($course->image) {
            Storage::disk('public')->delete($course->image);
        }

        $course->delete();

        return back()->with('success', 'Curso eliminado correctamente.');
    }
}
