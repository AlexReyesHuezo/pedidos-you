<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = ['producto', 'cantidad', 'total', 'id_usuario'];

    public function usuario()
    {
        /**
         * La función belongsTo() establece la relación de la tabla pedidos con la tabla usuarios
         * a través de la clave foránea id_usuario, esta relación es de un pedido pertenece a un usuario
         * El primer parámetro es la clase del modelo con el que se establece la relación
         * El segundo parámetro es el nombre de la clave foránea
         * 
         * Dado que no uso el nombramiento estándar de Laravel para claves foraneas (usuario_id),
         * debo especificar el nombre de la clave foránea en el segundo parámetro también por buenas prácticas
         */
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
}
