<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Gestor de notas</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            color: #1e293b;
            padding: 30px 15px;
        }

        .contenedor {
            max-width: 900px;
            margin: auto;
        }

        h1 {
            text-align: center;
            margin-bottom: 10px;
            color: #1e293b;
        }

        .descripcion {
            text-align: center;
            margin-bottom: 30px;
            color: #64748b;
        }

        .panel {
            background: white;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 25px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.06);
        }

        .campo {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input,
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            font-size: 15px;
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        button,
        .boton {
            display: inline-block;
            border: none;
            padding: 11px 17px;
            border-radius: 7px;
            background: #2563eb;
            color: white;
            font-size: 14px;
            font-weight: bold;
            text-decoration: none;
            cursor: pointer;
        }

        button:hover,
        .boton:hover {
            background: #1d4ed8;
        }

        .busqueda {
            display: flex;
            gap: 10px;
        }

        .busqueda input {
            flex: 1;
        }

        .nota {
            border: 1px solid #e2e8f0;
            padding: 18px;
            border-radius: 9px;
            margin-top: 15px;
        }

        .nota h3 {
            margin-bottom: 10px;
        }

        .contenido {
            white-space: pre-wrap;
            line-height: 1.5;
            color: #475569;
            margin-bottom: 15px;
        }

        .acciones {
            display: flex;
            gap: 10px;
        }

        .eliminar {
            background: #dc2626;
        }

        .eliminar:hover {
            background: #b91c1c;
        }

        .mensaje {
            padding: 13px;
            background: #dcfce7;
            color: #166534;
            border-radius: 7px;
            margin-bottom: 18px;
        }

        .errores {
            background: #fee2e2;
            color: #991b1b;
            padding: 13px;
            border-radius: 7px;
            margin-bottom: 18px;
        }

        .vacio {
            text-align: center;
            padding: 25px;
            color: #64748b;
        }

        .contenedor-volver {
            text-align: center;
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

        @media (max-width: 550px) {
            .busqueda {
                flex-direction: column;
            }

            .acciones {
                flex-wrap: wrap;
            }
        }
    </style>
</head>

<body>

    <div class="contenedor">

        <h1>Gestor de notas</h1>
        <p class="descripcion">Organiza, consulta y administra tus notas personales</p>

        @if (session('success'))
            <div class="mensaje">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="errores">
                <strong>Corrige los siguientes errores:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="panel">
            <h2>Crear una nota</h2>
            <form action="{{ route('notes.store') }}" method="POST">

                @csrf

                <div class="campo">
                    <label for="title">Titulo de la nota</label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="{{ old('title') }}"
                        placeholder="Ejemplo: Pendientes de estudio"
                        required
                    >
                </div>

                <div class="campo">
                    <label for="category">Categoria</label>
                    <input type="text" id="category" name="category" value="{{ old('category') }}" maxlength="100" placeholder="Ejemplo: Estudio, Personal, Trabajo">
                </div>

                <div class="campo">
                    <label for="content">Contenido</label>
                    <textarea
                        id="content"
                        name="content"
                        placeholder="Escribe el contenido de tu nota..."
                        required
                    >{{ old('content') }}</textarea>
                </div>

                <button type="submit">Guardar nota</button>
            </form>
        </div>

        {{--Formulario para buscar notas por titulo--}}
        <div class="panel">
            <h2>Buscar notas</h2>

            <form action="{{ route('notes.index') }}" method="GET" class="busqueda">
                <input
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Escribe el titulo que deseas buscar"
                >
                <input type="text" name="category" value="{{ $category }}" placeholder="Filtrar por categoria">

                <button type="submit">Buscar</button>

                <a href="{{ route('notes.index') }}" class="boton">Limpiar</a>
            </form>
        </div>

        {{--Muestra las notas --}}
        <div class="panel">
            <h2>Mis notas</h2>

            @forelse ($notes as $note)

                {{--Muestra el cotenido de las notas--}}
                <div class="nota">

                    <h3>{{ $note->title }}</h3>
                    @if ($note->category)
                        <small>Categoria: {{ $note->category }}</small>
                    @endif

                    <p class="contenido">{{ $note->content }}</p>

                    <small>
                        Fecha de registro: {{ $note->created_at->format('d/m/Y H:i') }}
                    </small>

                    <div class="acciones" style="margin-top: 15px;">

                        <a href="{{ route('notes.edit', $note) }}" class="boton">
                            Editar
                        </a>
                        <form
                            action="{{ route('notes.destroy', $note) }}"
                            method="POST"
                            onsubmit="return confirm('¿Estás seguro de eliminar esta nota?')"
                        >
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="eliminar">
                                Eliminar
                            </button>
                        </form>

                    </div>
                </div>

            @empty

                <div class="vacio">
                    <p>No hay notas registradas</p>
                </div>

            @endforelse
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
