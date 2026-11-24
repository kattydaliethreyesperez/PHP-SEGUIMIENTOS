<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    //Muestra las encuestas y sus resultados
    public function index()
    {
        $surveys = Survey::with('responses')->latest()->get();

        return view('surveys.index', compact('surveys'));
    }

    //Valida y registra una encuesta
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'options' => 'required|array|min:2|max:4',
            'options.*' => 'required|string|max:150',
        ], [
            'title.required' => 'El titulo de la encuesta es obligatorio.',
            'options.min' => 'Agrega al menos dos opciones.',
            'options.*.required' => 'Todas las opciones deben tener texto.',
        ]);

        $options = array_values(array_unique(array_map('trim', $validated['options'])));

        if (count($options) < 2) {
            return back()->withErrors(['options' => 'La encuesta necesita al menos dos opciones diferentes.'])->withInput();
        }

        Survey::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'options' => $options,
        ]);

        return redirect()->route('surveys.index')->with('success', 'Encuesta creada correctamente.');
    }

    //Registra una respuesta valida
    public function vote(Request $request, Survey $survey)
    {
        $validated = $request->validate([
            'option' => 'required|string',
        ]);

        if (!in_array($validated['option'], $survey->options, true)) {
            return back()->withErrors(['option' => 'Selecciona una opcion valida.']);
        }

        $survey->responses()->create([
            'option' => $validated['option'],
        ]);

        return redirect()->route('surveys.index')->with('success', 'Tu respuesta fue registrada.');
    }

    //Elimina una encuesta y sus respuestas
    public function destroy(Survey $survey)
    {
        $survey->delete();

        return redirect()->route('surveys.index')->with('success', 'Encuesta eliminada correctamente.');
    }
}
