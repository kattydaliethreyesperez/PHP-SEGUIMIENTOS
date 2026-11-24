<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plataforma de recetas</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f1f5f9;
            color: #1e293b;
            padding: 30px 15px;
        }

        .contenedor {
            max-width: 1050px;
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

        .panel {
            background-color: white;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 25px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.07);
        }

        h2 {
            margin-bottom: 18px;
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
            width: 100%;
            padding: 11px;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            font-size: 14px;
            font-family: Arial, sans-serif;
        }

        textarea {
            min-height: 110px;
            resize: vertical;
        }

        button, .boton {
            display: inline-block;
            padding: 11px 17px;
            border: none;
            border-radius: 7px;
            background-color: #2563eb;
            color: white;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover, .boton:hover {
            background-color: #1d4ed8;
        }

        .boton-guardar {
            grid-column: 1 / -1;
        }

        .busqueda {
            display: flex;
            gap: 10px;
        }

        .busqueda input {
            flex: 1;
        }

        .recetas {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 18px;
        }

        .receta {
            border: 1px solid #e2e8f0;
            border-radius: 9px;
            padding: 18px;
        }

        .receta h3 {
            margin-bottom: 8px;
        }

        .categoria {
            display: inline-block;
            background-color: #dbeafe;
            color: #1d4ed8;
            padding: 5px 9px;
            border-radius: 15px;
            font-size: 12px;
            margin-bottom: 12px;
        }

        .receta p {
            color: #475569;
            line-height: 1.5;
            margin-bottom: 10px;
            white-space: pre-wrap;
        }

        .receta strong {
            color: #1e293b;
        }

        .boton-eliminar {
            background-color: #dc2626;
            margin-top: 8px;
        }

        .boton-eliminar:hover {
            background-color: #b91c1c;
        }

        .mensaje {
            padding: 13px;
            background-color: #dcfce7;
            color: #166534;
            border-radius: 7px;
            margin-bottom: 18px;
        }

        .errores {
            padding: 13px;
            background-color: #fee2e2;
            color: #991b1b;
            border-radius: 7px;
            margin-bottom: 18px;
        }

        .vacio {
            text-align: center;
            color: #64748b;
            padding: 20px;
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

        @media (max-width: 600px) {
            .formulario {
                grid-template-columns: 1fr;
            }

            .campo-completo, .boton-guardar {
                grid-column: auto;
            }

            .busqueda {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="contenedor">
        <h1>Plataforma de recetas</h1>
        <p class="descripcion">Guarda tus recetas favoritas y encuentra facilmente lo que deseas preparar</p>

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

        {{--Formulario para guardar una nueva receta--}}
        <div class="panel">
            <h2>Agregar receta</h2>

            <form action="{{ route('recipes.store') }}" method="POST" class="formulario">
                @csrf

                <div class="campo campo-completo">
                    <label for="title">Nombre de la receta</label>
                    <input type="text" id="title" name="title"
                        value="{{ old('title') }}" placeholder="Ejemplo: Arroz con pollo" required>
                </div>

                <div class="campo">
                    <label for="category">Categoria</label>
                    <input type="text" id="category" name="category"
                        value="{{ old('category') }}" placeholder="Ejemplo: Almuerzo">
                </div>

                <div class="campo">
                    <label for="prep_time">Tiempo de preparacion (minutos)</label>
                    <input type="number" id="prep_time" name="prep_time"
                        value="{{ old('prep_time') }}" min="1" max="1440" placeholder="Ejemplo: 30">
                </div>

                <div class="campo campo-completo">
                    <label for="ingredients">Ingredientes</label>
                    <textarea id="ingredients" name="ingredients"
                        placeholder="Escribe los ingredientes y sus cantidades" required>{{ old('ingredients') }}</textarea>
                </div>

                <div class="campo campo-completo">
                    <label for="instructions">Preparacion</label>
                    <textarea id="instructions" name="instructions"
                        placeholder="Explica los pasos para preparar la receta" required>{{ old('instructions') }}</textarea>
                </div>

                <button type="submit" class="boton-guardar">Guardar receta</button>
            </form>
        </div>

        {{--Formulario para buscar recetas por nombre o categoria--}}
        <div class="panel">
            <h2>Buscar recetas</h2>

            <form action="{{ route('recipes.index') }}" method="GET" class="busqueda">
                <input type="text" name="search" value="{{ $search }}"
                    placeholder="Buscar por nombre">
                <input type="text" name="category" value="{{ $category }}" placeholder="Filtrar por tipo de comida">
                <input type="text" name="ingredient" value="{{ $ingredient }}" placeholder="Filtrar por ingrediente">
                <button type="submit">Buscar</button>
                <a href="{{ route('recipes.index') }}" class="boton">Limpiar</a>
            </form>
        </div>

        {{--Muestra las recetas que se encuentran guardadas--}}
        <div class="panel">
            <h2>Mis recetas</h2>

            @forelse ($recipes as $recipe)
                <div class="recetas" style="margin-bottom: 15px;">
                    <div class="receta">
                        <h3>{{ $recipe->title }}</h3>

                        @if ($recipe->category)
                            <span class="categoria">{{ $recipe->category }}</span>
                        @endif

                        @if ($recipe->prep_time)
                            <p><strong>Tiempo:</strong> {{ $recipe->prep_time }} minutos</p>
                        @endif

                        <p><strong>Ingredientes:</strong>
{{ $recipe->ingredients }}</p>

                        <p><strong>Preparacion:</strong>
{{ $recipe->instructions }}</p>

                        <button type="button" class="boton" onclick="shareRecipe(this)" data-title="{{ $recipe->title }}" data-text="{{ $recipe->ingredients }}\n{{ $recipe->instructions }}">Compartir receta</button>

                        {{--Formulario para eliminar la receta seleccionada--}}
                        <form action="{{ route('recipes.destroy', $recipe) }}" method="POST"
                            onsubmit="return confirm('¿Estas seguro de eliminar esta receta?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="boton-eliminar">Eliminar receta</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="vacio">No hay recetas registradas.</p>
            @endforelse
        </div>

        {{--Regresa al menu principal--}}
        <div class="contenedor-volver">
            <a href="{{ url('/') }}" class="boton-volver">Volver al menu principal</a>
        </div>
    </div>
<script>
    async function shareRecipe(button) {
        const data = { title: button.dataset.title, text: button.dataset.text };
        if (navigator.share) {
            try { await navigator.share(data); } catch (error) { }
        } else if (navigator.clipboard) {
            await navigator.clipboard.writeText(data.title + "\\n" + data.text);
            alert('Receta copiada para compartir.');
        } else {
            alert('Tu navegador no permite compartir desde esta pagina.');
        }
    }
</script>
</body>
</html>
