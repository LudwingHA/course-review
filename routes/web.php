<?php

use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicProfileController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\PublicCourseController;

Route::middleware(['auth'])->group(function () {
    Route::resource('courses', CourseController::class)->except(['show']);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::get('/', [PublicCourseController::class, 'index'])->name('home');
Route::get('/curso/{course:slug}', [PublicCourseController::class, 'show'])->name('courses.show');
Route::post('/curso/{course}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
Route::post('/like/{type}/{id}', [LikeController::class, 'toggle'])->name('like.toggle');
Route::get('/perfil/{user}', [PublicProfileController::class, 'show'])->name('profile.public');

require __DIR__ . '/auth.php';
