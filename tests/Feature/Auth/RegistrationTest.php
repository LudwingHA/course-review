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
        'role' => 'student',
        'description' => 'Soy un usuario de prueba',

    
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(config('fortify.home'));
});
