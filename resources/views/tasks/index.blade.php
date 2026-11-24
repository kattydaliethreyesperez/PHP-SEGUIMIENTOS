<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Lista de tareas</title>

    <style>
        /*Estilo general de la pagina*/
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            color: #1f2937;
            padding: 30px 15px;
        }

        /*Contenedor principal*/
        .contenedor {
            max-width: 700px;
            margin: auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
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

        /*Formulario para agregar tareas*/
        .formulario {
            display: flex;
            gap: 10px;
            margin-bottom: 25px;
        }

        .formulario input {
            flex: 1;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
        }

        button {
            border: none;
            padding: 10px 15px;
            border-radius: 6px;
            cursor: pointer;
            color: white;
        }

        .btn-agregar {
            background-color: #2563eb;
        }

        /*Mensajes de confirmacion*/
        .mensaje {
            background-color: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 15px;
        }

        .error {
            color: #dc2626;
            margin-bottom: 15px;
        }

        /*Elementos de la lista*/
        .tarea {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            padding: 15px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .tarea-completada {
            text-decoration: line-through;
            color: #94a3b8;
        }

        .acciones {
            display: flex;
            gap: 8px;
        }

        .btn-completar {
            background-color: #16a34a;
        }

        .btn-eliminar {
            background-color: #dc2626;
        }

        .vacio {
            text-align: center;
            color: #64748b;
            padding: 20px;
        }

        @media (max-width: 500px) {
            .formulario,
            .tarea {
                flex-direction: column;
                align-items: stretch;
            }

            .acciones {
                justify-content: flex-start;
            }
        }

        /*Contenedor del checkbox y el nombre de la tarea*/
        .tarea-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

    /*Diseño checkbox*/
    .check-completar {
        appearance: none;
        width: 20px;
        height: 20px;
        border: 2px solid #16a34a;
        border-radius: 50%;
        cursor: pointer;
        position: relative;
        flex-shrink: 0;
    }

    /*tarea completada */
    .check-completar:checked {
        background-color: #16a34a;
    }

    /*Marca de verificacion*/
    .check-completar:checked::after {
        content: "✓";
        color: white;
        position: absolute;
        top: -2px;
        left: 3px;
        font-size: 15px;
        font-weight: bold;
    }
    /*Boton para volver al menu principal*/
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

        /*boton de regreso*/
        .contenedor-volver {
            text-align: center;
        }

        @media (max-width: 500px) {
            .formulario,
            .tarea {
                flex-direction: column;
                align-items: stretch;
            }

            .acciones {
                justify-content: flex-start;
            }
        }

    </style>
</head>

<body>

    <div class="contenedor">

        <h1>Lista de tareas</h1>

        <p class="descripcion">
            Organiza tus actividades y controla tus pendientes.
        </p>

        {{--mensaje de exito cuando existe la sesion--}}
        @if (session('success'))
            <div class="mensaje">
                {{ session('success') }}
            </div>
        @endif

        {{--Muestra los errores de validacion--}}
        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        {{--campos pararegistrar una nueva tarea--}}
        <form action="{{ route('tasks.store') }}" method="POST" class="formulario">
            @csrf

            <input
                type="text"
                name="title"
                placeholder="Escribe una nueva tarea..."
                value="{{ old('title') }}"
                required
            >

            <button type="submit" class="btn-agregar">
                Agregar
            </button>

        </form>

        <h2>Mis tareas</h2>

        {{--Comprueba si existen tareas registradas--}}
        @forelse ($tasks as $task)

                    <div class="tarea">

            {{--Muestra el checkbox y el nombre de la tarea--}}
            <div class="tarea-info">

                {{--Formulario para cambiar el estado de la tarea--}}
                <form action="{{ route('tasks.toggle', $task) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <input
                        type="checkbox"
                        class="check-completar"
                        {{ $task->completed ? 'checked' : '' }}
                        onchange="this.form.submit()"
                        aria-label="Marcar tarea como completada"
                    >
                </form>

                {{-- acha el nombre cuando la tarea esta completada--}}
                <span class="{{ $task->completed ? 'tarea-completada' : '' }}">
                    {{ $task->title }}
                </span>

            </div>

            {{--Boton para eliminar--}}
            <div class="acciones">

                <form
                    action="{{ route('tasks.destroy', $task) }}"
                    method="POST"
                    onsubmit="return confirm('¿Estás seguro de eliminar esta tarea?')"
                >
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn-eliminar">
                        Eliminar
                    </button>
                </form>

            </div>

        </div>

            </div>

        {{--Mensaje cuando no hay tareas--}}
        @empty

            <p class="vacio">
                No hay tareas registradas. ¡Agrega una nueva tarea para comenzar!
            </p>

        @endforelse

         {{--Boton para regresar al menu principal--}}
        <div class="contenedor-volver">
            <a href="{{ url('/') }}" class="boton-volver">
                Volver al menú principal
            </a>
        </div>

    </div>

</body>
</html>
