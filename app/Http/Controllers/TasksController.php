<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    //Mostrar una lista de  todas las tareas registradas
    public function index()
    {
        // Obtiene las tareas ordenadas en orden descendente tomando la fecha de creacion
        $tasks = Tasks::orderBy('created_at', 'desc')->get();
        return view('tasks.index', compact('tasks'));
    }

    //Registrar una nueva tarea
    public function store(Request $request)
    {
        //condion de validacon para el campo obligatorio
        $request->validate([
            'title' => 'required|string|max:255'
        ]);

        //Guarda la nueva tarea en la bd
        Tasks::create([
            'title' => $request->title,
            'completed' => false
        ]);

        //regresa a la lista de las taeas y asigna mensaje de confirmacion
        return redirect()->route('tasks.index')->with('success', 'Tarea creada correctamente.');
    }

    //Cambiar los estados de las tareas
    public function toggle(Tasks $task)
    {
        // Invierte el estado actual de la tarea
        $task->update([
            'completed' => !$task->completed
        ]);

        // Regresa a la lista con un mensaje.
        return redirect()->route('tasks.index')->with('success', 'Tarea actualizada correctamente.');
    }

    //Eliminar una tarea de la lista
    public function destroy(Tasks $task)
    {
        // Elimina la tarea de la base de datos.
        $task->delete();

        // Regresa a la lista con un mensaje.
        return redirect()->route('tasks.index')->with('success', 'Tarea eliminada correctamente.');
    }
}
