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
            Fecha::create([
                'fecha' => $faker->dateTimeBetween('+1 days', '+1 month'),
                'estado' => $faker->randomElement(['disponible', 'ocupado']),
            ]);
        }
    }
}
