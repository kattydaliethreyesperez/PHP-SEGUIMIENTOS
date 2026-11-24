<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    //Define los campos que se pueden guardar en una nota
    protected $fillable = [
        'title',
        'content',
        'category'
    ];
}
