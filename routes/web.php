<?php

use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicProfileController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\PublicCourseController;
use App\Http\Controllers\AdminUserController;



Route::middleware(['auth'])->group(function () {
    Route::resource('courses', CourseController::class)->except(['show']);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');

Route::get('/admin/users/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
Route::put('/admin/users/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
Route::delete('/admin/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');

});
Route::get('/dashboard', function () {
    return redirect()->route('courses.index');
})->middleware(['auth'])->name('dashboard');
Route::get('/', [PublicCourseController::class, 'index'])->name('home');
Route::get('/curso/{course:slug}', [PublicCourseController::class, 'show'])->name('courses.show');
Route::post('/curso/{course}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
Route::post('/like/{type}/{id}', [LikeController::class, 'toggle'])->name('like.toggle');
Route::get('/perfil/{user}', [PublicProfileController::class, 'show'])->name('profile.public');

require __DIR__ . '/auth.php';
