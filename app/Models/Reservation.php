<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    //Define los campos que se pueden registrar en una reserva
    protected $fillable = [
        'customer_name',
        'email',
        'reservation_date',
        'reservation_time',
        'guests',
        'notes'
    ];

    //Define los tipos de datos que utiliza el modelo
    protected function casts(): array
    {
        return [
            'reservation_date' => 'date',
            'guests' => 'integer',
        ];
    }
}
