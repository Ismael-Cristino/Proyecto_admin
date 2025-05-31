<?php

// app/Models/Cliente.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $primaryKey = 'id_cliente';
    public $timestamps = false;

    protected $fillable = [
        'tel', 'email','nombre'
    ];
}

