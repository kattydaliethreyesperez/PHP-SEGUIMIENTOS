<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class keyController extends Controller
{
    //Muestra la vista del generador de claves
    public function index()
    {
        return view('key.index');
    }

    //Genera la cotraseña segun las opciones seleccionadas
    public function generar(Request $request)
    {
        //Valida que el formulario si haya sido enviado
        $request->validate([
            'longitud' => 'required|integer|min:8|max:32',
            'mayusculas' => 'nullable',
            'minusculas' => 'nullable',
            'numeros' => 'nullable',
            'simbolos' => 'nullable',
        ]);

        //caracteres disponibles
        $caracteres = '';

        if ($request->has('mayusculas')) {
            $caracteres .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }

        if ($request->has('minusculas')) {
            $caracteres .= 'abcdefghijklmnopqrstuvwxyz';
        }

        if ($request->has('numeros')) {
            $caracteres .= '0123456789';
        }

        if ($request->has('simbolos')) {
            $caracteres .= '!@#$%&*?-_';
        }

        //Comprueba que el campo no este vacio
        if ($caracteres === '') {
            return back()->withErrors(['opciones' => 'Selecciona al menos un tipo de carácter.'])->withInput();
        }

        //Genera la clave aleatoria
        $key = '';

        for ($i = 0; $i < $request->longitud; $i++) {
            $indice = random_int(0, strlen($caracteres) - 1);
            $key .= $caracteres[$indice];
        }

        //regresa al menu con la clave generada
        return view('key.index', compact('key'));
    }
}
