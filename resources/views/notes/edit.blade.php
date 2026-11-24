<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar nota</title>

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
            max-width: 650px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.06);
        }

        h1 {
            text-align: center;
            margin-bottom: 25px;
        }

        .campo {
            margin-bottom: 20px;
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
            min-height: 180px;
            resize: vertical;
        }

        button,
        .boton {
            display: inline-block;
            padding: 12px 18px;
            border: none;
            border-radius: 7px;
            background: #2563eb;
            color: white;
            font-weight: bold;
            text-decoration: none;
            cursor: pointer;
        }

        button:hover,
        .boton:hover {
            background: #1d4ed8;
        }

        .errores {
            background: #fee2e2;
            color: #991b1b;
            padding: 13px;
            border-radius: 7px;
            margin-bottom: 18px;
        }

        .acciones {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
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
    </style>
</head>

<body>

    <div class="contenedor">

        <h1>Editar nota</h1>

        @if ($errors->any())
            <div class="errores">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('notes.update', $note) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="campo">
                <label for="title">Titulo de la nota</label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    value="{{ old('title', $note->title) }}"
                    required
                >
            </div>

            <div class="campo">
                <label for="category">Categoria</label>
                <input type="text" id="category" name="category" value="{{ old('category', $note->category) }}" maxlength="100">
            </div>

            <div class="campo">
                <label for="content">Contenido</label>
                <textarea
                    id="content"
                    name="content"
                    required
                >{{ old('content', $note->content) }}</textarea>
            </div>

            <div class="acciones">
                <button type="submit">Actualizar nota</button>

                <a href="{{ route('notes.index') }}" class="boton">
                    Cancelar
                </a>
            </div>

        </form>

        {{--Regresar al menu principal--}}
        <div class="contenedor-volver">
            <a href="{{ url('/') }}" class="boton-volver">
                Volver al menú principal
            </a>
        </div>

    </div>

</body>
</html>
