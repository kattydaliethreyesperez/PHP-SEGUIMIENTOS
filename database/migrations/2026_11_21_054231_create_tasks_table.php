<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    //crear la tabla de tareas con sus campos y sus tipos de datoss
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->timestamps();
        });
    }

    // Permitir eliminar la tabla si se revierte la migracion
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
