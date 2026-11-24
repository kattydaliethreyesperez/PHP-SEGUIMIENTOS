<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //Define los campos que se pueden registrar en un evento
    protected $fillable = [
        'title',
        'description',
        'event_date',
        'event_time',
        'location'
    ];

    //Define los tipos de datos que utiliza el modelo
    protected function casts(): array
    {
        return [
            'event_date' => 'date',
        ];
    }
}
