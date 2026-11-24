<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    //Crea la tabla donde se almacenaran los eventos
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('event_date');
            $table->time('event_time');
            $table->string('location')->nullable();
            $table->timestamps();
        });
    }

    //Elimina la tabla de eventos
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
