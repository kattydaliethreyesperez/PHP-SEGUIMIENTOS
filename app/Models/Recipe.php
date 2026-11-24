<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    //Define los campos que se pueden registrar en una receta
    protected $fillable = [
        'title',
        'category',
        'ingredients',
        'instructions',
        'prep_time'
    ];
}
