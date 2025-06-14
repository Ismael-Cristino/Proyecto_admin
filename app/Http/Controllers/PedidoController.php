<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Fecha;
use App\Models\Factura;

class PedidoController extends Controller
{
    public function pendientes()
    {
        $pedidos = Pedido::with(['cliente', 'factura', 'fecha'])
            ->where('estado', 'pendiente')
            ->get();

        return view('pedidos.pendientes', compact('pedidos'));
    }

    public function reservados()
    {
        $pedidos = Pedido::where('estado', 'reservado')->get();
        return view('pedidos.reservados', compact('pedidos'));
    }

    public function pagados()
    {
        $pedidos = Pedido::where('estado', 'pagado')->get();
        return view('pedidos.pagados', compact('pedidos'));
    }

    public function cancelados()
    {
        $pedidos = Pedido::where('estado', 'cancelado')->get();
        return view('pedidos.cancelados', compact('pedidos'));
    }

    public function completados()
    {
        $pedidos = Pedido::where('estado', 'completado')->get();
        return view('pedidos.completados', compact('pedidos'));
    }

    public function edit($id)
    {
        $pedido = Pedido::findOrFail($id);
        $clientes = Cliente::all();
        $fechas = Fecha::all();
        return view('pedidos.edit', compact('pedido', 'clientes', 'fechas'))->with('redirect_back', url()->previous());
    }

    public function update(Request $request, $id_pedido)
    {
        $pedido = Pedido::findOrFail($id_pedido);

        // Validar (puedes ampliar si necesitas más reglas)
        $request->validate([
            'descripcion'    => 'required|string',
            'servicio'       => 'required|string',
            'estado'         => 'required|string',
            'nombre_cliente' => 'required|string|max:255',
            'fecha_inicio'   => 'required|date',
            'fecha_fin'      => 'required|date|after_or_equal:fecha_inicio',
            'precio_bruto'   => 'required|numeric|min:0',
            'redirect_back'  => 'nullable|url',
        ]);

        // Actualizar el cliente relacionado
        $cliente = Cliente::findOrFail($request->id_cliente);
        $cliente->nombre = $request->nombre_cliente;
        $cliente->save();

        // Actualizar el pedido
        $pedido->descripcion = $request->descripcion;
        $pedido->servicio = $request->servicio;
        $pedido->estado = $request->estado;
        $pedido->save();

        // Actualizar la fecha relacionada
        $fecha = Fecha::findOrFail($pedido->id_fecha);
        $fecha->fecha_inicio = $request->fecha_inicio;
        $fecha->fecha_fin = $request->fecha_fin;
        $fecha->save();

        // Actualizar factura
        $factura = $pedido->factura;
        $iva = 21;
        $precioBruto = $request->precio_bruto;
        $precioFinal = $precioBruto + ($precioBruto * $iva / 100);

        $factura->precio_bruto = $precioBruto;
        $factura->iva = $iva;
        $factura->precio_final = $precioFinal;
        $factura->save();

        // Redirigir: si viene redirect_back, úsalo; si no, decidir por estado
        if ($request->filled('redirect_back')) {
        return redirect($request->redirect_back)
               ->with('success', 'Pedido actualizado correctamente.');
    }

        // Redireccionar según el estado
        switch ($pedido->estado) {
            case 'pendiente':
                return redirect()->route('pedidos.pendientes')->with('success', 'Pedido actualizado correctamente.');
            case 'reservado':
                return redirect()->route('pedidos.reservados')->with('success', 'Pedido actualizado correctamente.');
            case 'pagado':
                return redirect()->route('pedidos.pagados')->with('success', 'Pedido actualizado correctamente.');
            case 'completado':
                return redirect()->route('pedidos.completados')->with('success', 'Pedido actualizado correctamente.');
            case 'cancelado':
                return redirect()->route('pedidos.cancelados')->with('success', 'Pedido actualizado correctamente.');
            default:
                return redirect()->route('home')->with('success', 'Pedido actualizado correctamente.');
        }
    }

    public function index()
    {
        $pedidos = Pedido::all();
        return view('pedidos.index', compact('pedidos'));
    }

    public function destroy($id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->delete();

        return redirect()->back()->with('success', 'Pedido eliminado correctamente.');
    }

    public function create()
    {
        return view('pedidos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'numero' => 'required|digits_between:8,15',
            'email' => 'required|email',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'servicio' => 'required|string',
            'direccionOri' => 'required|string',
            'direccionDes' => 'required|string',
            'descripcion' => 'required|string',
            'precio_bruto' => 'required|numeric|min:0',
        ]);

        $iva = 21;
        $precioBruto = $request->precio_bruto;
        $precioFinal = $precioBruto + ($precioBruto * $iva / 100);

        $cliente = Cliente::create([
            'nombre' => $request->nombre,
            'tel' => $request->numero,
            'email' => $request->email,
        ]);

        $fecha = Fecha::create([
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'estado' => 'ocupado',
        ]);

        $factura = Factura::create([
            'precio_bruto' => $precioBruto,
            'iva' => $iva,
            'precio_final' => $precioFinal,
        ]);

        Pedido::create([
            'id_cliente' => $cliente->id_cliente,
            'id_fecha' => $fecha->id_fecha,
            'id_factura' => $factura->id_factura,
            'servicio' => $request->servicio,
            'origen' => $request->direccionOri,
            'destino' => $request->direccionDes,
            'descripcion' => $request->descripcion,
            'estado' => 'reservado',
        ]);

        return redirect()->route('pedidos.reservados')->with('success', 'Pedido creado con éxito.');
    }
}
