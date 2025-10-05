<?php

namespace Database\Seeders;

use App\Models\Personas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersonasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Persona::updateOrCreate(
            ['cedula' => 1234567],
            [
                'nombre' => 'María',
                'apellido' => 'González',
                'segundo_nombre' => 'Elena',
                'segundo_apellido' => 'Rodríguez',
                'nacionalidad' => 'Venezolana',
                'genero' => 'Femenino',
                'nacimiento' => '1985-03-15',
                'direccion' => 'Calle Principal 123, Bruzual',
                'telefono' => '04261234567',
                'email' => 'maria.gonzalez@email.com',
            ]
        );

        Persona::updateOrCreate(
            ['cedula' => 29970399],
            [
                'nombre' => 'Carlos',
                'apellido' => 'Martínez',
                'segundo_nombre' => 'José',
                'segundo_apellido' => 'Hernández',
                'nacionalidad' => 'Venezolana',
                'genero' => 'Masculino',
                'nacimiento' => '1979-11-20',
                'direccion' => 'Avenida Libertador 456, Bruzual',
                'telefono' => '04262997039',
                'email' => 'carlos.martinez@email.com',
            ]
        );

        Persona::updateOrCreate(
            ['cedula' => 12345678],
            [
                'nombre' => 'Ana',
                'apellido' => 'López',
                'segundo_nombre' => 'Carolina',
                'segundo_apellido' => 'Silva',
                'nacionalidad' => 'Venezolana',
                'genero' => 'Femenino',
                'nacimiento' => '1990-07-08',
                'direccion' => 'Urbanización El Valle, Bruzual',
                'telefono' => '04121234567',
                'email' => 'ana.lopez@email.com',
            ]
        );
    }
}