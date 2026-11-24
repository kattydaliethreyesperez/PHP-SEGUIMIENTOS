<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    //Agrega el estado de confirmacion a las reservas
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->string('status')->default('pending')->after('notes');
        });
    }

    //Elimina el estado de las reservas
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
