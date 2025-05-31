<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Factura;

class FacturaSeeder extends Seeder
{
    public function run()
    {
        foreach (range(1, 100) as $i) {
            $precio_bruto = rand(100, 1000);
            $iva = 21;
            $precio_final = intval($precio_bruto * (1 + $iva / 100));

            Factura::create([
                'precio_bruto' => $precio_bruto,
                'iva' => $iva,
                'precio_final' => $precio_final,
            ]);
        }
    }
}

