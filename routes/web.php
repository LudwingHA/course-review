<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\PublicCourseController;

Route::middleware(['auth'])->group(function () {
    Route::resource('courses', CourseController::class)->except(['show']);
});

Route::get('/', [PublicCourseController::class, 'index'])->name('home');
Route::get('/curso/{course}', [PublicCourseController::class, 'show'])->name('courses.show');

require __DIR__.'/auth.php';
