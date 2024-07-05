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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            /**
             * El método string crea un campo de tipo VARCHAR equivalente en la BD
             * El segundo parámetro es la longitud del campo, que también se puede indicar solo con el valor del parámetro así:
             * $table->string('nombre', 100);
             */
            $table->string('nombre', length: 100);
            // El método unique() hace que el valor del campo sea único
            $table->string('correo', length: 100)->unique();
            // El método nullable() permite que el campo sea nulo o vacío
            $table->string('telefono', length: 15)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
