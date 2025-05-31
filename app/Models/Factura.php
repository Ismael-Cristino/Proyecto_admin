<?php

// app/Models/Factura.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $primaryKey = 'id_factura';
    public $timestamps = false;

    protected $fillable = [
        'precio_bruto', 'iva','precio_final'
    ];
}

