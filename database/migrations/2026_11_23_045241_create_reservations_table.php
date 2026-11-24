<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    //Crea la tabla donde se almacenaran las reservas
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('email');
            $table->date('reservation_date');
            $table->time('reservation_time');
            $table->unsignedTinyInteger('guests');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    //Elimina la tabla de reservas
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
