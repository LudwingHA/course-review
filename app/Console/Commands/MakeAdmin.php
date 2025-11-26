<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class MakeAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * Así se llamará el comando en la terminal:
     * php artisan user:admin correo@email.com
     */
    protected $signature = 'user:admin {email}';

    /**
     * The console command description.
     */
    protected $description = 'Convierte un usuario en administrador';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');

        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("❌ Usuario no encontrado con el correo: $email");
            return;
        }

        $user->role = 'admin';
        $user->save();

        $this->info("El usuario {$user->name} ahora es ADMIN");
    }
}
