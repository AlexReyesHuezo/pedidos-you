<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    /**
     * Cuando hacemos consultas Query Builder en Laravel, estamos utilizando una interfaz orientada a objetos
     * para construir consultas SQL en lugar de escribir directamente las consultas SQL.
     * Necesitamos la clase Request para obtener los datos enviados por el cliente.
     * Usamos la clase DB para interactuar con la base de datos.
     * Y la función table() para especificar la tabla con la que queremos interactuar.
     */
    public function store(Request $request) {
        try
        {
            DB::table('pedidos')->insert([
                'producto' => $request->producto,
                'cantidad' => $request->cantidad,
                'total' => $request->total,
                'id_usuario' => $request->id_usuario
            ]);

            return response()->json([
                'message' => 'Pedido almacenado correctamente'
            ], 200);
        } catch (Exception $error)
        {
            return response()->json([$error->getMessage()], 500);
        }
    }

    public function getPedidos($id_usuario) {
        try
        {
            // Esta consulta recupera todos los pedidos de un usuario en específico
            $pedidos = DB::table('pedidos')->where('id_usuario', $id_usuario)->get();

            return response()->json($pedidos, 200);
        } catch (Exception $error)
        {
            return response()->json([$error->getMessage()], 500);
        }
    }

    public function getDetallesPedido($id_pedido) {
        try
        {
            /**
             * Esta consulta recupera toda la información de un pedido, así como el nombre y correo del usuario que lo realizó
             * Su equivalente en SQL sería:
             * SELECT pedidos.*, usuarios.nombre, usuarios.correo FROM pedidos JOIN usuarios ON pedidos.id_usuario = usuarios.id WHERE pedidos.id = $id_pedido
             */
            $pedido = DB::table('pedidos')
                ->join('usuarios', 'pedidos.id_usuario', '=', 'usuarios.id')
                ->select('pedidos.*', 'usuarios.nombre', 'usuarios.correo')
                ->where('pedidos.id', $id_pedido)
                ->get();

            return response()->json($pedido, 200);
        } catch (Exception $error)
        {
            return response()->json([$error->getMessage()], 500);
        }
    }

    public function getPedidosRango() {
        try
        {
            /**
             * Con whereBetween() podemos recuperar todos los pedidos cuyo total sea mayor entre $100 a $250
             * Su equivalente en SQL sería: SELECT * FROM pedidos WHERE total BETWEEN 100 AND 250
             */
            $pedidos = DB::table('pedidos')
                ->whereBetween('total', [100, 250])
                ->get();

            return response()->json($pedidos, 200);
        } catch (Exception $error)
        {
            return response()->json([$error->getMessage()], 500);
        }
    }

    public function getTotalPedidosUsuario($id_usuario) {
        try
        {
            /**
             * Esta consulta calcula el total de los pedidos realizados por un usuario
             * Su equivalente en SQL sería: SELECT SUM(total) FROM pedidos WHERE id_usuario = $id_usuario
             * La función sum() nos permite sumar los valores de una columna en particular
             */
            $total = DB::table('pedidos')
                ->where('id_usuario', $id_usuario)
                ->sum('total');

            return response()->json($total, 200);
        } catch (Exception $error)
        {
            return response()->json([$error->getMessage()], 500);
        }
    }

    public function getInfoPedidosUsuarios() {
        try
        {
            /** Esta consulta recupera todos los pedidos junto con la información de los usuarios, ordenándolos de forma descendente según el total del pedido.
             * Su equivalente en SQL sería:
             * SELECT pedidos.*, usuarios.nombre, usuarios.correo FROM pedidos JOIN usuarios ON pedidos.id_usuario = usuarios.id ORDER BY pedidos.total DESC
             */
            $pedidos = DB::table('pedidos')
                ->join('usuarios', 'pedidos.id_usuario', '=', 'usuarios.id')
                ->select('pedidos.*', 'usuarios.nombre', 'usuarios.correo')
                ->orderBy('pedidos.total', 'desc')
                ->get();

            return response()->json($pedidos, 200);
        } catch (Exception $error)
        {
            return response()->json([$error->getMessage()], 500);
        }
    }

    public function getTotalPedidos() {
        try
        {
            /**
             * Esta consulta calcula la suma total del campo "total" en la tabla de pedidos
             * Su equivalente en SQL sería: SELECT SUM(total) FROM pedidos
             */
            $total = DB::table('pedidos')->sum('total');

            return response()->json($total, 200);
        } catch (Exception $error)
        {
            return response()->json([$error->getMessage()], 500);
        }
    }

    public function getPedidoEconomico() {
        try
        {
            /**
             * Esta consulta recupera el pedido más económico, junto con el nombre del usuario asociado
             * Su equivalente en SQL sería:
             * SELECT pedidos.*, usuarios.nombre FROM pedidos JOIN usuarios ON pedidos.id_usuario = usuarios.id ORDER BY pedidos.total ASC LIMIT 1
             */
            $pedido = DB::table('pedidos')
                ->join('usuarios', 'pedidos.id_usuario', '=', 'usuarios.id')
                ->select('pedidos.*', 'usuarios.nombre')
                ->orderBy('pedidos.total', 'asc')
                ->limit(1)
                ->get();

            return response()->json($pedido, 200);
        } catch (Exception $error)
        {
            return response()->json([$error->getMessage()], 500);
        }
    }

    public function getPedidosAgrupados() {
        try {
            /**
             * Esta consulta selecciona el id del usuario, la cantidad total de productos y el total de los pedidos
             *  agrupados por el id del usuario
             * Su equivalente en SQL sería:
             * SELECT id_usuario, SUM(cantidad) as cantidad_total, SUM(total) as total FROM pedidos GROUP BY id_usuario
             */
            $pedidos = DB::table('pedidos')
                ->select('id_usuario', DB::raw('SUM(cantidad) as cantidad_total'), DB::raw('SUM(total) as total'))
                ->groupBy('id_usuario')
                ->get();
    
            return response()->json($pedidos, 200);
        } catch (Exception $error) {
            return response()->json([$error->getMessage()], 500);
        }
    }
}
