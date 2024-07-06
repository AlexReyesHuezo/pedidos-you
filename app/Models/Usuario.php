<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'correo', 'telefono'];

    public function pedido()
    {
        /**
         * La función hasMany() establece la relación de la tabla usuarios con la tabla pedidos
         * a través de la clave foránea id_usuario, esta relación es de un usuario tiene muchos pedidos
         * El primer parámetro es la clase del modelo con el que se establece la relación
         * El segundo parámetro es el nombre de la clave foránea
         * 
         * Dado que no uso el nombramiento estándar de Laravel para claves foraneas (usuario_id),
         * debo especificar el nombre de la clave foránea en el segundo parámetro por buenas prácticas
         */
        return $this->hasMany(Pedido::class, 'id_usuario');
    }
}
