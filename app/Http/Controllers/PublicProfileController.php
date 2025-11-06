<?php

// app/Http/Controllers/PublicProfileController.php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PublicProfileController extends Controller
{
    public function show(User $user)
    {
        // Cargar relaciones según tipo de usuario
        if ($user->isInstructor()) {
            $user->load(['courses.reviews']);
        } elseif ($user->isStudent()) {
            $user->load(['reviews.course']);
        }

        return view('profile.public', compact('user'));
    }
}

