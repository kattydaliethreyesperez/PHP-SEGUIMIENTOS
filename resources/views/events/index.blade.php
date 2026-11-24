<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario de eventos</title>

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

        .lista-eventos {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .evento {
            display: grid;
            grid-template-columns: 90px 1fr auto;
            gap: 18px;
            align-items: center;
            padding: 18px;
            border: 1px solid #e2e8f0;
            border-radius: 9px;
        }

        .fecha {
            text-align: center;
            background-color: #eff6ff;
            color: #1d4ed8;
            padding: 12px 8px;
            border-radius: 8px;
        }

        .fecha strong {
            display: block;
            font-size: 25px;
        }

        .fecha span {
            font-size: 13px;
            font-weight: bold;
        }

        .informacion h3 {
            margin-bottom: 7px;
            color: #1e293b;
        }

        .informacion p {
            color: #64748b;
            font-size: 14px;
            margin-top: 5px;
            line-height: 1.4;
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

        .sin-eventos {
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

            .evento {
                grid-template-columns: 70px 1fr;
            }

            .evento form {
                grid-column: 1 / -1;
                text-align: right;
            }
        }
    </style>
</head>
<body>
    <div class="contenedor">
        <h1>Calendario de eventos</h1>
        <p class="descripcion">Organiza tus actividades, fechas importantes y recordatorios</p>

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

        {{--Formulario para registrar un nuevo evento--}}
        <div class="tarjeta">
            <h2>Registrar nuevo evento</h2>

            <form action="{{ route('events.store') }}" method="POST" class="formulario">
                @csrf

                {{--Solicita el nombre y la descripcion del evento--}}
                <div class="campo campo-completo">
                    <label for="title">Nombre del evento</label>
                    <input type="text" id="title" name="title"
                        value="{{ old('title') }}"
                        placeholder="Ingresa el nombre del evento" required>
                </div>

                <div class="campo">
                    <label for="event_date">Fecha</label>
                    <input type="date" id="event_date" name="event_date"
                        value="{{ old('event_date') }}" required>
                </div>

                <div class="campo">
                    <label for="event_time">Hora</label>
                    <input type="time" id="event_time" name="event_time"
                        value="{{ old('event_time') }}" required>
                </div>

                <div class="campo campo-completo">
                    <label for="location">Lugar</label>
                    <input type="text" id="location" name="location"
                        value="{{ old('location') }}"
                        placeholder="Ingresa el lugar del evento (opcional)">
                </div>

                <div class="campo campo-completo">
                    <label for="description">Descripcion</label>
                    <textarea id="description" name="description"
                        placeholder="Agrega detalles del evento (opcional)">{{ old('description') }}</textarea>
                </div>

                <button type="submit" class="boton-registrar">
                    Registrar evento
                </button>
            </form>
        </div>

        <div class="tarjeta">
            <h2>Eventos programados</h2>
            <button type="button" class="boton-registrar" id="activar-recordatorios" style="margin-bottom:15px;">Activar notificaciones de recordatorio</button>
            <p id="estado-recordatorios" style="margin-bottom:15px;color:#64748b;"></p>

            @if ($events->count() > 0)

                {{--Recorre los eventos guardados y muestra su informacion--}}
                <div class="lista-eventos">
                    @foreach ($events as $event)
                        <div class="evento">
                            <div class="fecha">
                                <strong>{{ $event->event_date->format('d') }}</strong>
                                <span>{{ $event->event_date->translatedFormat('M Y') }}</span>
                            </div>

                            <div class="informacion">
                                <h3>{{ $event->title }}</h3>
                                <p>Hora: {{ substr($event->event_time, 0, 5) }}</p>
                                <p>Lugar: {{ $event->location ?: 'Sin lugar especificado' }}</p>
                                @if ($event->description)
                                    <p>{{ $event->description }}</p>
                                @endif
                            </div>

                            <details style="margin-top:10px;">
                                <summary style="cursor:pointer;color:#2563eb;font-weight:bold;">Editar evento</summary>
                                <form action="{{ route('events.update', $event) }}" method="POST" style="display:grid;gap:8px;margin-top:10px;">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" name="title" value="{{ $event->title }}" required maxlength="255" aria-label="Nombre del evento">
                                    <input type="date" name="event_date" value="{{ $event->event_date->format('Y-m-d') }}" required aria-label="Fecha">
                                    <input type="time" name="event_time" value="{{ substr($event->event_time, 0, 5) }}" required aria-label="Hora">
                                    <input type="text" name="location" value="{{ $event->location }}" maxlength="255" placeholder="Lugar">
                                    <textarea name="description" maxlength="1000" placeholder="Descripcion">{{ $event->description }}</textarea>
                                    <button type="submit" class="boton-registrar">Guardar cambios</button>
                                </form>
                            </details>

                            {{--Formulario para eliminar el evento seleccionado--}}
                            <form action="{{ route('events.destroy', $event) }}"
                                method="POST"
                                onsubmit="return confirm('¿Estas seguro de eliminar este evento?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="boton-eliminar">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>

            @else
                <p class="sin-eventos">Todavia no tienes eventos registrados.</p>
            @endif
        </div>

        {{--Regresa al menu principal--}}
        <div class="contenedor-volver">
            <a href="{{ url('/') }}" class="boton-volver">
                Volver al menú principal
            </a>
        </div>
    </div>
<script>
    const scheduledEvents = @json($reminderEvents)

    document.getElementById('activar-recordatorios').addEventListener('click', async function () {
        const status = document.getElementById('estado-recordatorios');
        if (!('Notification' in window)) {
            status.textContent = 'Este navegador no admite notificaciones.';
            return;
        }
        const permission = await Notification.requestPermission();
        if (permission !== 'granted') {
            status.textContent = 'No se concedio permiso para las notificaciones.';
            return;
        }
        status.textContent = 'Notificaciones activadas para eventos que comiencen en los proximos 15 minutos mientras esta pagina permanezca abierta.';
        const now = new Date();
        scheduledEvents.forEach(function (event) {
            const eventDate = new Date(event.date + 'T' + event.time + ':00');
            const difference = eventDate.getTime() - now.getTime();
            if (difference >= 0 && difference <= 15 * 60 * 1000) {
                new Notification('Recordatorio: ' + event.title, {
                    body: 'Tu evento comienza a las ' + event.time + '.'
                });
            }
        });
    });
</script>
</body>
</html>
