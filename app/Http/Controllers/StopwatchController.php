<?php

namespace App\Http\Controllers;

class StopwatchController extends Controller
{
    //Muestra la herramienta del cronometro
    public function index()
    {
        return view('stopwatch.index');
    }
}
