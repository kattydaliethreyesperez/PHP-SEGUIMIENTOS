<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    //Muestra las notas registradas y permite realizar busquedas
    public function index(Request $request)
    {
        $search = $request->input('search');
        $category = $request->input('category');

        $notes = Note::when($search, function ($query) use ($search) {
            $query->where('title', 'like', "%{$search}%");
        })->when($category, function ($query) use ($category) {
            $query->where('category', 'like', "%{$category}%");
        })->latest()->get();

        return view('notes.index', compact('notes', 'search', 'category'));
    }

    //Valida y registra una nueva nota
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:5000',
            'category' => 'nullable|string|max:100',
        ], [
            'title.required' => 'El titulo es obligatorio.',
            'title.max' => 'El titulo no puede superar los 255 caracteres.',
            'content.required' => 'El contenido es obligatorio.',
            'content.max' => 'El contenido no puede superar los 5000 caracteres.',
        ]);

        Note::create($validated);
        return redirect()->route('notes.index')->with('success', 'Nota registrada correctamente.');
    }

    //Formulario para editar una nota
    public function edit(Note $note)
    {
        return view('notes.edit', compact('note'));
    }

    //Valida y actualiza una nota existente
    public function update(Request $request, Note $note)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:5000',
            'category' => 'nullable|string|max:100',
        ], [
            'title.required' => 'El titulo es obligatorio.',
            'content.required' => 'El contenido es obligatorio.',
            'title.max' => 'El titulo no puede superar los 255 caracteres.',
            'content.max' => 'El contenido no puede superar los 5000 caracteres.',
        ]);

        $note->update($validated);
        return redirect()->route('notes.index')->with('success', 'Nota actualizada correctamente.');
    }

    // Elimina una nota existente
    public function destroy(Note $note)
    {
        $note->delete();
        return redirect()->route('notes.index')->with('success', 'Nota eliminada correctamente.');
    }
}
