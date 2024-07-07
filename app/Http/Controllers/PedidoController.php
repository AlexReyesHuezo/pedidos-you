<?php

namespace App\Http\Controllers;

/**
 * Con Query Builder, necesitamos usar esencialmente dos clases:
 * la clase Request para obtener los datos de la solicitud HTTP
 * y la clase DB para realizar consultas a la base de datos
 */
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PedidoController extends Controller
{
    /**
     * Mostrar la lista de pedidos
     */
    public function index()
    {
        // get() obtiene todos los registros de la tabla pedidos
        $pedidos = DB::table('pedidos')->get();
        // Convertir la colección de pedidos a formato JSON y devolverla
        return $pedidos->toJson();
    }

    /**
     * Crear nuevos pedidos. Usamos store() porque creamos una API, en una app web sería create()
     */
    public function store(Request $request)
    {
        // Validar que el producto, cantidad, total y el id del usuario no estén vacíos para crear un pedido
        try {
            $pedido = DB::table('pedidos')->insert([
                'producto' => $request->producto,
                'cantidad' => $request->cantidad,
                'total' => $request->total,
                'id_usuario' => $request->id_usuario,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            return response()->json($pedido, 201);
        } catch (\Exception $e) {
            // En caso de error al crear un pedido, se envía un mensaje JSON de error con un código 500
            return response()->json(['error' => 'Failed to create order'], 500);
        }
    }

    /**
     * Mostrar los pedidos del usuario con el ID especificado
     */
    public function show(string $id)
    {
        $pedidos = DB::table('pedidos')->where('id_usuario', $id)->get();
        // Convertir la colección de pedidos a formato JSON y devolverla
        return $pedidos->toJson();
    }

    /**
     * Mostrar los pedidos de un usuario con su nombre y correo
     */
    public function showByUser(string $id)
    {
        $pedidos = DB::table('pedidos')
            // Unir la tabla pedidos con la tabla usuarios a través de la clave foránea id_usuario
            ->join('usuarios', 'pedidos.id_usuario', '=', 'usuarios.id')
            // Seleccionar todos los campos de la tabla pedidos y los campos nombre y correo de la tabla usuarios
            ->select('pedidos.*', 'usuarios.nombre', 'usuarios.correo')
            // Filtrar los pedidos por el ID del usuario
            ->where('usuarios.id', $id)
            ->get();
        return $pedidos->toJson();
    }

    /**
     * Mostrar los pedidos cuyo total esté entre $100 y $250
     */
    public function showByTotal()
    {
        $pedidos = DB::table('pedidos')
            // Filtrar los pedidos por el rango de total entre $100 y $250
            ->whereBetween('total', [100, 250])
            ->get();
        return $pedidos->toJson();
    }

    /**
     * Calcular el total de registros de la tabla pedidos para un usuario
     */
    public function countByUser(string $id)
    {
        $total = DB::table('pedidos')
            // Contar los registros de la tabla pedidos donde el id_usuario sea igual al ID proporcionado
            ->where('id_usuario', $id)
            // Contar el total de registros de la tabla pedidos
            ->count();
        return response()->json($total);
    }

    /**
     * Recuperar todos los pedidos y la info del usuario, ordenandolos descendentemente por el total del pedido
     */
    public function showAllWithUser()
    {
        $pedidos = DB::table('pedidos')
            ->join('usuarios', 'pedidos.id_usuario', '=', 'usuarios.id')
            ->select('pedidos.*', 'usuarios.nombre', 'usuarios.correo', 'usuarios.telefono')
            // Ordenar los pedidos por el total en orden descendente
            ->orderBy('total', 'desc')
            ->get();
        return $pedidos->toJson();
    }

    /**
     * Obtén la suma total del campo total de la tabla pedidos
     */
    public function sumTotal()
    {
        // Sumar el campo total de la tabla pedidos
        $total = DB::table('pedidos')->sum('total');
        return response()->json($total);
    }

    /**
     * Encuentra el pedido más económico, junto con el nombre del usuario que lo realizó
     */
    public function findCheapest()
    {
        $pedido = DB::table('pedidos')
            ->join('usuarios', 'pedidos.id_usuario', '=', 'usuarios.id')
            ->select('pedidos.*', 'usuarios.nombre')
            // Ordenar los pedidos por el total en orden ascendente y obtener el primero, el más económico
            ->orderBy('total', 'asc')
            ->first();
        return response()->json($pedido);
    }

    /**
     * Obtener el producto, cantidad y total de cada pedido, agrupandolos por usuario
     */
    public function groupByUser()
    {
        $pedidos = DB::table('pedidos')
            ->join('usuarios', 'pedidos.id_usuario', '=', 'usuarios.id')
            // Agrupar los pedidos por el nombre del usuario
            ->select('usuarios.nombre', 'pedidos.producto', 'pedidos.cantidad', 'pedidos.total')
            ->get();
        return $pedidos->toJson();
    }
}
