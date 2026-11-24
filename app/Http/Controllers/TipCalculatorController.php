<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TipCalculatorController extends Controller
{
    //Muestra la calculadora y realiza los calculos necesarios
    public function index(Request $request)
    {
        //Inicializa todos los atributos
        $propina = null;
        $total = null;
        $monto = null;
        $porcentaje = null;

        //Comprueba que el formulario ya fue enviado
        if ($request->has('calcular')) {

            //Valida los datos ingresados
            $datos = $request->validate([
                'monto' => 'required|numeric|min:0.01',
                'porcentaje' => 'required|in:5,10,15,20,25'
            ]);

            //Obtiene el monto y el porcentaje que ya fueron seleccionados y validos
            $monto = $datos['monto'];
            $porcentaje = $datos['porcentaje'];

            //Calcula el valor de la propina
            $propina = $monto * ($porcentaje / 100);
            //Calcula el total incluyendo la propina
            $total = $monto + $propina;
        }

        // Envía los resultados a la vista
        return view('tips.index', compact(
            'propina',
            'total',
            'monto',
            'porcentaje'
        ));
    }
}

