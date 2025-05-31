<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $path = database_path('scripts/bd.sql');

        if (!file_exists($path)) {
            throw new \Exception("SQL file not found at: $path");
        }

        $sql = file_get_contents($path);
        DB::unprepared($sql);

        $this->command->info('Base de datos importada desde bd.sql');

        $this->call([
            ClienteSeeder::class,
            FechaSeeder::class,
            FacturaSeeder::class,
            PedidoSeeder::class,
        ]);
    }
}
