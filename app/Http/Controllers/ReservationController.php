<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    //Muestra todas las reservas registradas
    public function index()
    {
        $reservations = Reservation::orderBy('reservation_date', 'asc')->orderBy('reservation_time', 'asc')->get();
        $selectedDate = request('date', date('Y-m-d'));
        $occupiedTimes = Reservation::whereDate('reservation_date', $selectedDate)->where('status', '!=', 'cancelled')->pluck('reservation_time')->map(function ($time) { return substr($time, 0, 5); })->toArray();
        $availableTimes = [];
        for ($hour = 9; $hour <= 17; $hour++) {
            $time = sprintf('%02d:00', $hour);
            if (!in_array($time, $occupiedTimes)) $availableTimes[] = $time;
        }
        return view('reservations.index', compact('reservations', 'selectedDate', 'availableTimes'));
    }

    //Valida y registra una nueva reserva
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'reservation_date' => 'required|date|after_or_equal:today',
            'reservation_time' => 'required|date_format:H:i',
            'guests' => 'required|integer|min:1|max:20',
            'notes' => 'nullable|string|max:1000',
        ], [
            'customer_name.required' => 'El nombre del cliente es obligatorio.',
            'email.required' => 'El correo electronico es obligatorio.',
            'email.email' => 'Ingresa un correo electronico valido.',
            'reservation_date.required' => 'La fecha de la reserva es obligatoria.',
            'reservation_date.after_or_equal' => 'La fecha no puede ser anterior al dia de hoy.',
            'reservation_time.required' => 'La hora de la reserva es obligatoria.',
            'guests.required' => 'Indica la cantidad de personas.',
            'guests.min' => 'La reserva debe tener al menos una persona.',
            'guests.max' => 'La reserva permite un maximo de 20 personas.',
        ]);

        //Comprueba que el horario no este ocupado
        $occupied = Reservation::whereDate('reservation_date', $validated['reservation_date'])
            ->whereTime('reservation_time', $validated['reservation_time'])
            ->where('status', '!=', 'cancelled')
            ->exists();

        if ($occupied) {
            return back()->withErrors(['reservation_time' => 'Ya existe una reserva para esa fecha y hora.'])->withInput();
        }

        //Guarda la reserva utilizando los datos validados
        $validated['status'] = 'pending';
        Reservation::create($validated);

        return redirect()->route('reservations.index')->with('success', 'Reserva registrada correctamente.');
    }

    //Confirma una reserva registrada
    public function confirm(Reservation $reservation)
    {
        $reservation->update(['status' => 'confirmed']);
        return redirect()->route('reservations.index')->with('success', 'Reserva confirmada correctamente.');
    }

    //Elimina una reserva ya existente
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return redirect()->route('reservations.index')->with('success', 'Reserva eliminada correctamente.');
    }
}
