<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\UsuarioController;

// Rutas de la API
Route::get('/pedidos', [PedidoController::class, 'index']);
Route::post('/pedidos', [PedidoController::class, 'store']);
Route::get('/pedidos/usuario/{id}', [PedidoController::class, 'show']);
Route::get('/pedidos/usuario/{id}/detalles', [PedidoController::class, 'showByUser']);
Route::get('/pedidos/total/rango', [PedidoController::class, 'showByTotal']);
Route::get('/pedidos/usuario/{id}/count', [PedidoController::class, 'countByUser']);
Route::get('/pedidos/usuarios', [PedidoController::class, 'showAllWithUser']);
Route::get('/pedidos/suma/total', [PedidoController::class, 'sumTotal']);
Route::get('/pedidos/economicos', [PedidoController::class, 'findCheapest']);
Route::get('/pedidos/total/por-usuario', [PedidoController::class, 'groupByUser']);

Route::get('/usuarios', [UsuarioController::class, 'index']);
Route::post('/usuarios', [UsuarioController::class, 'store']);
Route::get('/usuarios/letra', [UsuarioController::class, 'findByLetter']);
