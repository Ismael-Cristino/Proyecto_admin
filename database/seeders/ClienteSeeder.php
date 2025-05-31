<?php

namespace Database\Seeders;

// database/seeders/ClienteSeeder.php
use Illuminate\Database\Seeder;
use App\Models\Cliente;
use Faker\Factory as Faker;

class ClienteSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 100) as $i) {
            Cliente::create([
                'nombre' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'tel' => $faker->numerify('6########'),
            ]);
        }
    }
}