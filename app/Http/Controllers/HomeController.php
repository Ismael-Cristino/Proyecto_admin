<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home', [
            'pendientes' => Pedido::where('estado', 'pendiente')->count(),
            'reservados' => Pedido::where('estado', 'reservado')->count(),
            'pagados' => Pedido::where('estado', 'pagado')->count(),
            'completados' => Pedido::where('estado', 'completado')->count(),
            'cancelados' => Pedido::where('estado', 'cancelado')->count(),
        ]);
    }
}
