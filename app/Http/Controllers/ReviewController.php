<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

 
    public function store(Request $request, Course $course)
    {
        // Solo estudiantes pueden comentar
        if (!auth()->user()->isStudent()) {
            abort(403, 'Solo los estudiantes pueden dejar reseñas.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:5',
        ]);

        Review::create([
            'user_id' => auth()->id(),
            'course_id' => $course->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('courses.show', $course)
            ->with('success', '¡Reseña enviada correctamente!');
    }
}
