<?php

// app/Http/Controllers/PublicCourseController.php
namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class PublicCourseController extends Controller
{
    
    public function index()
    {
    
        $courses = Course::with('instructor')
            ->withCount('likes')
            ->latest()
            ->paginate(9);

        return view('home', compact('courses'));
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
