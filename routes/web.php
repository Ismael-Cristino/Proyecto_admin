<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

// Página pública
Route::get('/', function () {
    return view('welcome');
})->name('public.home'); // <- esto define la ruta que te falta

// Autenticación
// Solo login/logout
Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// Área privada
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

Route::get('/calendario', [CalendarioController::class, 'index'])->name('calendario');

Route::get('/api/eventos-calendario', function () {
    $pedidos = DB::select("
        SELECT p.descripcion, p.estado, f.fecha_inicio, f.fecha_fin
        FROM pedidos p
        INNER JOIN fechas f ON p.id_fecha = f.id_fecha
        WHERE p.estado IN ('reservado', 'pagado', 'completado')
    ");

    $eventos = [];

    foreach ($pedidos as $pedido) {
        $color = match($pedido->estado) {
            'completado' => '#28a745',     // Verde
            'pagado'     => '#17a2b8',     // Azul verdoso
            'reservado'  => '#007bff',     // Azul
            default      => '#6c757d',     // Gris por defecto (no debería llegar)
        };

        $eventos[] = [
            'title' => $pedido->descripcion,
            'start' => Carbon::parse($pedido->fecha_inicio)->toIso8601String(),
            'end'   => Carbon::parse($pedido->fecha_fin)->toIso8601String(),
            'color' => $color,
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

    Route::get('/pedidos/{id}/edit', [PedidoController::class, 'edit'])->name('pedidos.edit');

    Route::put('/pedidos/{id}', [PedidoController::class, 'update'])->name('pedidos.update');
});

Route::middleware(['auth'])->group(function () {
    // Usuarios
    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
    Route::get('/usuarios/crear', [UserController::class, 'create'])->name('usuarios.create');
    Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');
    // Mostrar formulario de cambio de contraseña
    Route::get('/usuarios/password', fn() => view('usuarios.password'))->name('usuarios.password.form');
    // Procesar cambio de contraseña
    Route::post('/usuarios/password', [UserController::class, 'changePassword'])->name('usuarios.password');
    // Eliminar usuario
    Route::delete('/usuarios/{usuario}', [UserController::class, 'destroy'])->name('usuarios.destroy');
});
