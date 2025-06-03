<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fecha;
use Faker\Factory as Faker;

class FechaSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 100) as $i) {
            $fechaInicio = $faker->dateTimeBetween('+1 days', '+1 month');

            // Clonamos y sumamos entre 1 y 5 horas para fecha_fin
            $fechaFin = (clone $fechaInicio)->modify('+' . rand(1, 5) . ' hours');

            Fecha::create([
                'fecha_inicio' => $fechaInicio,
                'fecha_fin' => $fechaFin,
                'estado' => $faker->randomElement(['disponible', 'ocupado']),
            ]);
        }
    }
}
