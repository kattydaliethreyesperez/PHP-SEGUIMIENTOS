<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    //Muestra la lista de gastos
    public function index(Request $request)
    {
        $month = $request->input('month', now()->format('Y-m'));

        $request->validate([
            'month' => 'sometimes|date_format:Y-m'
        ]);

        $expenses = Expense::whereYear('expense_date', substr($month, 0, 4))->whereMonth('expense_date', substr($month, 5, 2))->orderBy('expense_date', 'desc')->get();

        $monthlyTotal = $expenses->sum('amount');

        return view('expenses.index', compact('expenses', 'month', 'monthlyTotal'));
    }
    //Guarda un nuevo gasto
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'category' => 'required|string|max:100',
            'expense_date' => 'required|date',
        ], [
            'description.required' => 'La descripción es obligatoria.',
            'amount.required' => 'El monto es obligatorio.',
            'amount.numeric' => 'El monto debe ser un número válido.',
            'amount.min' => 'El monto debe ser mayor que cero.',
            'category.required' => 'La categoría es obligatoria.',
            'expense_date.required' => 'La fecha es obligatoria.',
        ]);

        Expense::create($request->all());
        return redirect()->route('expenses.index')->with('success', 'Gasto registrado correctamente.');
    }

    //Elimina un gasto
    public function destroy(Expense $expense)
    {
        $expense->delete();
        return redirect()->route('expenses.index')->with('success', 'Gasto eliminado correctamente.');
    }
}
