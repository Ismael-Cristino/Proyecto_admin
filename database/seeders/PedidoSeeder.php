<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Fecha;
use App\Models\Factura;
use Faker\Factory as Faker;

class PedidoSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 100) as $i) {
            Pedido::create([
                'descripcion' => $faker->sentence(4),
                'servicio' => $faker->randomElement(['trasladoDom', 'trasladoOfi', 'retiro', 'vaciado', 'otros']),
                'estado' => $faker->randomElement(['pendiente', 'reservado', 'pagado', 'cancelado','completado']),
                'id_cliente' => Cliente::inRandomOrder()->first()->id_cliente,
                'id_fecha' => Fecha::inRandomOrder()->first()->id_fecha,
                'id_factura' => Factura::inRandomOrder()->first()->id_factura,
                'origen' => $faker->address,
                'destino' => $faker->address,
            ]);
        }
    }
}
