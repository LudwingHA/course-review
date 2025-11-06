<?php

// app/Http/Controllers/CourseController.php
namespace App\Http\Controllers;

use App\Models\Course;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); 
    }

    public function index()
    {
        $courses = auth()->user()->isInstructor()
            ? auth()->user()->courses()->latest()->paginate(10)
            : abort(403, 'Solo los instructores pueden ver esto.');

        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        if (!auth()->user()->isInstructor()) abort(403);
        return view('courses.create');
    }

    public function store(StoreCourseRequest $request)
    {
        $course = Course::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'instructor_name' => auth()->user()->name,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('courses.index')->with('success', 'Curso creado correctamente.');
    }

    public function edit(Course $course)
    {
        $this->authorize('update', $course);
        return view('courses.edit', compact('course'));
    }

    public function update(UpdateCourseRequest $request, Course $course)
    {
        $this->authorize('update', $course);
        $course->update($request->validated());
        return redirect()->route('courses.index')->with('success', 'Curso actualizado.');
    }

    public function destroy(Course $course)
    {
        $this->authorize('delete', $course);
        $course->delete();
        return back()->with('success', 'Curso eliminado.');
    }
}
