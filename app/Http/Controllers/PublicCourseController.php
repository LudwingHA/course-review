<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;

class PublicCourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::query()
            ->with(['instructor', 'category'])
            ->withCount(['likes', 'reviews'])  
            ->withAvg('reviews', 'rating');  


        if ($search = $request->input('q')) {
            $query->where('title', 'like', "%{$search}%")
                ->orWhereHas('instructor', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
        }

   
        if ($category = $request->input('category')) {
            $query->whereHas('category', function ($q) use ($category) {
                $q->where('slug', $category);
            });
        }


        $courses = $query->latest()->paginate(9);
        $categories = Category::orderBy('name')->get();

        return view('home', compact('courses', 'categories'));
    }

    public function show(Course $course)
    {
        $course->load([
            'instructor',
            'reviews.user',
            'reviews.likes',
            'likes'
        ])
        ->loadCount('likes', 'reviews')
        ->loadAvg('reviews', 'rating');

        $userLiked = auth()->check()
            ? $course->likes()->where('user_id', auth()->id())->exists()
            : false;

        return view('courses.show', compact('course', 'userLiked'));
    }
}
