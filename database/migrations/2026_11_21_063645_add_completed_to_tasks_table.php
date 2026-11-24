<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    //Agrega el campo completed a la tabla tasks.
    //Por defecto, todas las tareas estarán pendientes.
    Schema::table('tasks', function (Blueprint $table) {
        $table->boolean('completed')->default(false);
    });
}

   public function down(): void
    {
    //Elimina el campo completed si se revierte la migración.
    Schema::table('tasks', function (Blueprint $table) {
        $table->dropColumn('completed');
    });
}
};
