<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    //Indica que los campos se les pueden asignar varios valores a la vez
    //fillable deja guardar el titulo y el estado de la tarea en la bd
    protected $fillable = [
        'title',
        'completed'
    ];

    // Convierte el campo completed en tipo bandera
    protected $casts = [
        'completed' => 'boolean'
    ];
}
