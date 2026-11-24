<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    //Define los campos que se pueden registrar
    protected $fillable = [
        'description',
        'amount',
        'category',
        'expense_date'
    ];

    //Define el tipo de dato de cada campo
    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'expense_date' => 'date',
        ];
    }
}
