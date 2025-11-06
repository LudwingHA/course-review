<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        return view('profile.edit', ['user' => $request->user()]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'avatar' => 'nullable|image|max:2048', // 2 MB
        ]);

        // Si sube una imagen nueva
        if ($request->hasFile('avatar')) {
            // Eliminar la anterior si existe
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Guardar la nueva
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->name = $request->name;
        $user->description = $request->description;
        $user->save();

        return back()->with('success', 'Perfil actualizado correctamente.');
    }
}