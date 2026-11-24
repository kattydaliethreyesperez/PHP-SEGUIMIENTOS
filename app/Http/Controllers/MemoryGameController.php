<?php

namespace App\Http\Controllers;

class MemoryGameController extends Controller
{
    //Muestra el juego de memoria
    public function index()
    {
        return view('memory.index');
    }
}
