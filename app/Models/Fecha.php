<?php

// app/Models/Fecha.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fecha extends Model
{
    protected $primaryKey = 'id_fecha';
    public $timestamps = false;

    protected $fillable = [
        'fecha_inicio', 'fecha_fin', 'estado'
    ];
}

