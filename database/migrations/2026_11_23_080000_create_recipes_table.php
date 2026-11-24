<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    //Crea la tabla para almacenar las recetas
    public function up(): void
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category')->nullable();
            $table->text('ingredients');
            $table->text('instructions');
            $table->unsignedInteger('prep_time')->nullable();
            $table->timestamps();
        });
    }

    //Elimina la tabla de recetas si se revierte la migracion
    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
