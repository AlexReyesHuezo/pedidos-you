<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    //
    public function store(Request $request) {
       try
       {
            DB::table('usuarios')->insert([
                'nombre' => $request->nombre,
                'correo' => $request->correo,
                'telefono' => $request->telefono
            ]);

            return response()->json([
                'message' => 'Usuario almacenado correctamente'
            ], 200);
       } catch (Exception $error)
       {
            return response()->json([$error->getMessage()], 500);
       }
    }

    // Encuentra los nombres de los usuarios que empiecen con la letra 'R'
    public function getUsuarios() {
        try
        {
            // Esta consulta recupera los nombres de los usuarios que empiecen con la letra 'R'
            // Su equivalente en SQL sería: SELECT * FROM usuarios WHERE nombre LIKE 'R%'
            $usuarios = DB::table('usuarios')->where('nombre', 'like', 'R%')->get();

            return response()->json($usuarios, 200);
        } catch (Exception $error)
        {
            return response()->json([$error->getMessage()], 500);
        }
    }
}
