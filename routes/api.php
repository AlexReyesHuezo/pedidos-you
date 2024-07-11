<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\UsuarioController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/pedidos', [PedidoController::class, 'store']);
Route::get('/pedidos/usuario/{id_usuario}', [PedidoController::class, 'getPedidos']);
Route::get('/pedidos/detalles/{id_pedido}', [PedidoController::class, 'getDetallesPedido']);
Route::get('/pedidos/rango', [PedidoController::class, 'getPedidosRango']);
Route::get('/pedidos/total/usuario/{id_usuario}', [PedidoController::class, 'getTotalPedidosUsuario']);
Route::get('/pedidos/info-usuarios', [PedidoController::class, 'getInfoPedidosUsuarios']);
Route::get('/pedidos/total', [PedidoController::class, 'getTotalPedidos']);
Route::get('/pedidos/economico', [PedidoController::class, 'getPedidoEconomico']);
Route::get('/pedidos/agrupados', [PedidoController::class, 'getPedidosAgrupados']);

Route::post('/usuarios', [UsuarioController::class, 'store']);
Route::get('/usuarios', [UsuarioController::class, 'getUsuarios']);
