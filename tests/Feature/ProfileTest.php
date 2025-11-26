<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'description' => ['nullable', 'string', 'max:1000'],
            'avatar' => ['nullable', 'image', 'max:2048'],
        ]);

        // ✅ Si cambia el email → quitar verificación
        if ($validated['email'] !== $user->email) {
            $user->email_verified_at = null;
        }

        // Avatar
        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->description = $validated['description'] ?? null;
        $user->save();

        // ✅ IMPORTANTE: redirección correcta
        return redirect('/profile');
    }

    public function destroy(Request $request)
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required']
        ]);

        $user = $request->user();

        if (! Hash::check($request->password, $user->password)) {
            return back()
                ->withErrors([
                    'password' => 'Incorrect password',
                ], 'userDeletion')
                ->withInput();
        }

        // eliminar avatar si existe
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        auth()->logout();
        $user->delete();

        return redirect('/');
    }
}
