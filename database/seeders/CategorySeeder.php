<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Desarrollo Web',
            'Programación',
            'Diseño Gráfico',
            'Inteligencia Artificial',
            'Marketing Digital',
            'Ciberseguridad',
            'Bases de Datos',
            'Idiomas',
            'Música y Producción',
            'Arte y Creatividad',
            'Fotografía',
            'Ofimática',
            'Ciencia de Datos',
            'Matemáticas',
            'Negocios y Emprendimiento'
        ];

        foreach ($categories as $name) {
            Category::updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
        }
    }
}
