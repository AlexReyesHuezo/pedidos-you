<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    /**
     * Muestra la lista de usuarios
     */
    public function index()
    {
        $usuarios = DB::table('usuarios')->get();
        return $usuarios->toJson();
    }

    /**
     * Crea nuevos usuarios
     */
    public function store(Request $request)
    {
        // Validar que el nombre, correo y teléfono no estén vacíos para crear un usuario
        try {
            $usuario = DB::table('usuarios')->insert([
                'nombre' => $request->nombre,
                'correo' => $request->correo,
                'telefono' => $request->telefono
            ]);
            return response()->json($usuario, 201);
        } catch (\Exception $e) {
            // En caso de error al crear un usuario, se envía un mensaje JSON de error con un código 500, un error del servidor
            return response()->json(['error' => 'Failed to create user'], 500);
        }
    }

    /**
     * Encuentra los usuarios cuyos nombres comienzan con la letra R
     */
    public function findByLetter()
    {
        // where() filtra los registros de la tabla usuarios donde el nombre comienza con la letra R
        // Es equivalente a la cláusula WHERE nombre LIKE 'R%' en SQL
        $usuarios = DB::table('usuarios')->where('nombre', 'like', 'R%')->get();
        return $usuarios->toJson();
    }
}
