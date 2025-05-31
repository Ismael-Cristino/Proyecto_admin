<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\PedidoController;
use Illuminate\Support\Facades\DB;

// Página pública
Route::get('/', function () {
    return view('welcome');
})->name('public.home'); // <- esto define la ruta que te falta

// Autenticación
Auth::routes();

// Área privada
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

Route::get('/calendario', [CalendarioController::class, 'index'])->name('calendario');

Route::get('/api/pedidos', function () {
    $pedidos = DB::select("
        SELECT p.descripcion, p.horas, f.fecha
        FROM pedidos p
        INNER JOIN fechas f ON p.id_fecha = f.id
        WHERE f.estado IN ('reservado', 'pagado')
    ");

    $eventos = [];

    foreach ($pedidos as $pedido) {
        $horas = (float) $pedido->horas;

        $startDateTime = new DateTime($pedido->fecha);
        $horasEnteras = floor($horas);
        $minutos = ($horas - $horasEnteras) * 60;

        $interval = new DateInterval(sprintf('PT%dH%dM', $horasEnteras, $minutos));
        $endDateTime = clone $startDateTime;
        $endDateTime->add($interval);

        $eventos[] = [
            'title' => $pedido->descripcion,
            'start' => $startDateTime->format('Y-m-d\TH:i:s'),
            'end' => $endDateTime->format('Y-m-d\TH:i:s'),
            'color' => '#3788d8', // azul
        ];
    }

    return response()->json($eventos);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/pedidos/pendientes', [PedidoController::class, 'pendientes'])->name('pedidos.pendientes');
    Route::get('/pedidos/reservados', [PedidoController::class, 'reservados'])->name('pedidos.reservados');
    Route::get('/pedidos/pagados', [PedidoController::class, 'pagados'])->name('pedidos.pagados');
    Route::get('/pedidos/cancelados', [PedidoController::class, 'cancelados'])->name('pedidos.cancelados');
    Route::get('/pedidos/completados', [PedidoController::class, 'completados'])->name('pedidos.completados');


    Route::delete('/pedidos/{id}', [PedidoController::class, 'destroy'])->name('pedidos.destroy');

    // Mostrar formulario
    Route::get('/pedidos/crear', [PedidoController::class, 'create'])->name('pedidos.create');

    // Procesar formulario
    Route::post('/pedidos', [PedidoController::class, 'store'])->name('pedidos.store');

    Route::resource('pedidos', PedidoController::class);
});
