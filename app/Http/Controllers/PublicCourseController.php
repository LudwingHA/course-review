<?php

// app/Http/Controllers/PublicCourseController.php
namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class PublicCourseController extends Controller
{

    public function index(Request $request)
    {
        $query = Course::with('instructor', 'category')->withCount('likes');

        if ($search = $request->input('q')) {
            $query->where('title', 'like', "%{$search}%")
                ->orWhereHas('instructor', fn($q) => $q->where('name', 'like', "%{$search}%"));
        }

        if ($category = $request->input('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $category));
        }

        $courses = $query->latest()->paginate(9);
        $categories = \App\Models\Category::orderBy('name')->get();

        return view('home', compact('courses', 'categories'));
    }



    public function show(Course $course)
    {

        $course->load([
            'instructor',
            'reviews.user',
            'reviews.likes',
            'likes'
        ]);


        $userLiked = auth()->check()
            ? $course->likes()->where('user_id', auth()->id())->exists()
            : false;

        return view('courses.show', compact('course', 'userLiked'));
    }
}
