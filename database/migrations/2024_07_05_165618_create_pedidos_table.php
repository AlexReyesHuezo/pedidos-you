<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->string('producto', length: 25);
            // El método integer crea un campo de tipo INT equivalente en la BD
            $table->integer('cantidad');
            /**
             * El método float crea un campo de tipo FLOAT equivalente en la BD
             * El segundo parámetro es la cantidad de dígitos que se pueden almacenar en el campo
             * El tercer parámetro es la cantidad de decimales que se pueden almacenar en el campo
             */
            $table->float('total', 7, 2);
            /**
             * El método foreignId crea un campo que es una clave foránea en la BD
             * Este campo solo tandrá valores enteros grandes (BIGINT) positivos (UNSIGNED)
             * El método constrained() establece la relación de la clave foránea con la tabla de la que es clave primaria,
             * en este caso la tabla usuarios
             */
            $table->foreignId('id_usuario')->constrained('usuarios');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
