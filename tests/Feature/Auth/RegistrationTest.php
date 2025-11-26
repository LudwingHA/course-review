<?php

use App\Models\User;
use Illuminate\Support\Facades\Storage;

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    Storage::fake('public');

    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',

        // ✅ Campos requeridos por tu controller
        'role' => 'student',
        'description' => 'Soy un usuario de prueba',

        // ✅ Avatar opcional simulado
        // Si no quieres probar imágenes, puedes omitir esta parte
        // 'avatar' => UploadedFile::fake()->image('avatar.jpg'),
    ]);

    // ✅ Debe autenticarse
    $this->assertAuthenticated();

    // ✅ Ahora validamos tu ruta real
    $response->assertRedirect(config('fortify.home'));
});
