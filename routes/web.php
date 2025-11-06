<?php

use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\PublicCourseController;

Route::middleware(['auth'])->group(function () {
    Route::resource('courses', CourseController::class)->except(['show']);
});

Route::get('/', [PublicCourseController::class, 'index'])->name('home');
Route::get('/curso/{course}', [PublicCourseController::class, 'show'])->name('courses.show');
Route::post('/curso/{course}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
Route::post('/like/{type}/{id}', [LikeController::class, 'toggle'])->name('likes.toggle');
require __DIR__.'/auth.php';
