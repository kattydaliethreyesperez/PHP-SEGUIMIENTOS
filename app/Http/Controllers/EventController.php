<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    //Muestra los eventos registrados ordenados por fecha y hora
    public function index()
    {
        $events = Event::orderBy('event_date', 'asc')->orderBy('event_time', 'asc')->get();

        $reminderEvents = $events->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'date' => $event->event_date->format('Y-m-d'),
                'time' => substr($event->event_time, 0, 5),
            ];
        });

        return view('events.index', compact('events', 'reminderEvents'));
    }

    //Valida y registra un nuevo evento
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'event_date' => 'required|date',
            'event_time' => 'required|date_format:H:i',
            'location' => 'nullable|string|max:255',
        ], [
            'title.required' => 'El nombre del evento es obligatorio.',
            'title.max' => 'El nombre del evento no puede superar los 255 caracteres.',
            'description.max' => 'La descripcion no puede superar los 1000 caracteres.',
            'event_date.required' => 'La fecha del evento es obligatoria.',
            'event_time.required' => 'La hora del evento es obligatoria.',
        ]);

        //Guarda el evento utilizando los datos validados
        Event::create($validated);
        return redirect()->route('events.index')->with('success', 'Evento registrado correctamente.');
    }


    //Valida y actualiza un evento existente
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'event_date' => 'required|date',
            'event_time' => 'required|date_format:H:i',
            'location' => 'nullable|string|max:255',
        ]);

        $event->update($validated);

        return redirect()->route('events.index')->with('success', 'Evento actualizado correctamente.');
    }

    //Elimina un evento ya existente
    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('events.index')->with('success', 'Evento eliminado correctamente.');
    }
}
