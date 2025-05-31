<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $primaryKey = 'id_pedido';
    public $timestamps = false;

    protected $fillable = [
        'descripcion',
        'servicio',
        'estado',
        'id_fecha',
        'id_cliente',
        'id_factura',
        'origen',
        'destino'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    public function factura()
    {
        return $this->belongsTo(Factura::class, 'id_factura');
    }

    public function fecha()
    {
        return $this->belongsTo(Fecha::class, 'id_fecha');
    }
}
