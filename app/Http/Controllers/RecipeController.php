<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    //Muestra las recetas registradas y permite buscarlas
    public function index(Request $request)
    {
        $search = $request->input('search');
        $category = $request->input('category');
        $ingredient = $request->input('ingredient');

        $recipes = Recipe::when($search, function ($query) use ($search) {
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('category', 'like', "%{$search}%");
        })->when($category, function ($query) use ($category) {
            $query->where('category', 'like', "%{$category}%");
        })->when($ingredient, function ($query) use ($ingredient) {
            $query->where('ingredients', 'like', "%{$ingredient}%");
        })->latest()->get();

        return view('recipes.index', compact('recipes', 'search', 'category', 'ingredient'));
    }

    //Valida y registra una nueva receta
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'ingredients' => 'required|string|max:5000',
            'instructions' => 'required|string|max:5000',
            'prep_time' => 'nullable|integer|min:1|max:1440',
        ], [
            'title.required' => 'El nombre de la receta es obligatorio.',
            'ingredients.required' => 'Los ingredientes son obligatorios.',
            'instructions.required' => 'Las instrucciones son obligatorias.',
            'prep_time.integer' => 'El tiempo de preparacion debe ser un numero.',
            'prep_time.min' => 'El tiempo de preparacion debe ser mayor que cero.',
        ]);

        Recipe::create($validated);

        return redirect()->route('recipes.index')->with('success', 'Receta guardada correctamente.');
    }

    //Elimina una receta existente
    public function destroy(Recipe $recipe)
    {
        $recipe->delete();

        return redirect()->route('recipes.index')->with('success', 'Receta eliminada correctamente.');
    }
}
