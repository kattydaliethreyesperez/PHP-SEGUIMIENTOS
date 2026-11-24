<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de reservas</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f1f5f9;
            color: #1e293b;
            padding: 30px 15px;
        }

        .contenedor {
            max-width: 950px;
            margin: auto;
        }

        h1 {
            text-align: center;
            margin-bottom: 10px;
        }

        .descripcion {
            text-align: center;
            color: #64748b;
            margin-bottom: 25px;
        }

        .tarjeta {
            background-color: white;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 25px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        }

        h2 {
            margin-bottom: 20px;
            font-size: 20px;
        }

        .formulario {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .campo {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .campo-completo {
            grid-column: 1 / -1;
        }

        label {
            font-weight: bold;
            font-size: 14px;
        }

        input, textarea {
            padding: 11px;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            font-size: 14px;
            width: 100%;
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: #2563eb;
        }

        textarea {
            resize: vertical;
            min-height: 90px;
        }

        .boton-registrar {
            grid-column: 1 / -1;
            padding: 12px;
            background-color: #2563eb;
            color: white;
            border: none;
            border-radius: 7px;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
        }

        .boton-registrar:hover {
            background-color: #1d4ed8;
        }

        .mensaje {
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 7px;
            background-color: #dcfce7;
            color: #166534;
        }

        .errores {
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 7px;
            background-color: #fee2e2;
            color: #991b1b;
        }

        .tabla-contenedor {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 13px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        th {
            background-color: #f8fafc;
            color: #475569;
        }

        .boton-eliminar {
            padding: 8px 12px;
            background-color: #dc2626;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .boton-eliminar:hover {
            background-color: #b91c1c;
        }

        .sin-reservas {
            text-align: center;
            color: #64748b;
            padding: 20px;
        }

        .boton-volver {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 22px;
            background-color: #1e293b;
            color: white;
            text-decoration: none;
            text-align: center;
            font-size: 15px;
            font-weight: bold;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .boton-volver:hover {
            background-color: #334155;
        }

        .contenedor-volver {
            text-align: center;
        }

        @media (max-width: 600px) {
            .formulario {
                grid-template-columns: 1fr;
            }

            .campo-completo,
            .boton-registrar {
                grid-column: auto;
            }
        }
    </style>
</head>
<body>
    <div class="contenedor">
        <h1>Sistema de reservas</h1>
        <p class="descripcion">Registra y administra tus reservas</p>

        @if (session('success'))
            <div class="mensaje">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="errores">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{--Formulario para registrar una nueva reserva--}}
        <div class="tarjeta">
            <h2>Registrar nueva reserva</h2>

            <form action="{{ route('reservations.store') }}" method="POST" class="formulario">

                @csrf

                {{--Solicita los datos del usuario--}}
                <div class="campo">
                    <label for="customer_name">Nombre completo</label>
                    <input type="text" id="customer_name" name="customer_name"
                        value="{{ old('customer_name') }}"
                        placeholder="Ingresa el nombre completo" required>
                </div>

                <div class="campo">
                    <label for="email">Correo electronico</label>
                    <input type="email" id="email" name="email"
                        value="{{ old('email') }}"
                        placeholder="ejemplo@correo.com" required>
                </div>

                <div class="campo">
                    <label for="reservation_date">Fecha de la reserva</label>
                    <input type="date" id="reservation_date" name="reservation_date"
                        value="{{ old('reservation_date') }}"
                        min="{{ date('Y-m-d') }}" required>
                </div>

                <div class="campo">
                    <label for="reservation_time">Hora de la reserva</label>
                    <input type="time" id="reservation_time" name="reservation_time"
                        value="{{ old('reservation_time') }}" required>
                </div>

                <div class="campo campo-completo">
                    <label for="guests">Cantidad de personas</label>
                    <input type="number" id="guests" name="guests"
                        value="{{ old('guests', 1) }}"
                        min="1" max="20" required>
                </div>

                <div class="campo campo-completo">
                    <label for="notes">Observaciones</label>
                    <textarea id="notes" name="notes"
                        placeholder="Agrega alguna observacion (opcional)">{{ old('notes') }}</textarea>
                </div>

                <button type="submit" class="boton-registrar">
                    Registrar reserva
                </button>
            </form>
        </div>

        <div class="tarjeta">
            <h2>Reservas registradas</h2>

            @if ($reservations->count() > 0)

                {{--Organiza la informacion de las reservas--}}
                <div class="tabla-contenedor">
                    <table>
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th>Correo</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Personas</th>
                                <th>Observaciones</th>
                                <th>Accion</th>
                            </tr>
                        </thead>

                        <tbody>
                            {{--Recorre las reservas guardadas--}}
                            @foreach ($reservations as $reservation)
                                <tr>
                                    <td>{{ $reservation->customer_name }}</td>
                                    <td>{{ $reservation->email }}</td>
                                    <td>{{ $reservation->reservation_date->format('d/m/Y') }}</td>
                                    <td>{{ substr($reservation->reservation_time, 0, 5) }}</td>
                                    <td>{{ $reservation->guests }}</td>
                                    <td>{{ $reservation->notes ?: 'Sin observaciones' }}</td>

                                    {{--Formulario para eliminar la reserva seleccionada--}}
                                    <td>
                                        <form action="{{ route('reservations.destroy', $reservation) }}"
                                            method="POST"
                                            onsubmit="return confirm('¿Estas seguro de eliminar esta reserva?')">

                                            @csrf

                                            @method('DELETE')

                                            <button type="submit" class="boton-eliminar">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            @else
                <p class="sin-reservas">Todavia no tienes reservas registradas.</p>
            @endif
        </div>

        {{--Regresa al menu principal--}}
        <div class="contenedor-volver">
            <a href="{{ url('/') }}" class="boton-volver">
                Volver al menú principal
            </a>
        </div>

    </div>
</body>
</html>
