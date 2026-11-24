<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plataforma de encuestas</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            color: #1e293b;
            padding: 30px 15px;
        }

        .contenedor {
            max-width: 950px;
            margin: auto;
        }

        h1,
        .descripcion {
            text-align: center;
        }

        h1 {
            margin-bottom: 10px;
        }

        .descripcion {
            color: #64748b;
            margin-bottom: 25px;
        }

        .panel {
            background: white;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 22px;
            box-shadow: 0 3px 10px #0000000d;
        }

        h2 {
            margin-bottom: 18px;
            font-size: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin: 12px 0 7px;
        }

        input,
        textarea {
            width: 100%;
            padding: 11px;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            font: inherit;
        }

        textarea {
            min-height: 75px;
            resize: vertical;
        }

        .opciones {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        button {
            border: 0;
            border-radius: 7px;
            padding: 11px 16px;
            color: white;
            background: #2563eb;
            cursor: pointer;
            font-weight: bold;
        }

        button:hover {
            background: #1d4ed8;
        }

        .principal {
            margin-top: 16px;
            width: 100%;
        }

        .mensaje,
        .errores {
            padding: 12px;
            border-radius: 7px;
            margin-bottom: 18px;
        }

        .mensaje {
            background: #dcfce7;
            color: #166534;
        }

        .errores {
            background: #fee2e2;
            color: #991b1b;
        }

        .encuesta {
            border: 1px solid #e2e8f0;
            padding: 20px;
            border-radius: 9px;
            margin-top: 15px;
        }

        .encuesta h3 {
            margin-bottom: 7px;
        }

        .encuesta p {
            color: #64748b;
            margin-bottom: 15px;
        }

        .opcion-voto {
            display: flex;
            gap: 9px;
            align-items: center;
            margin: 12px 0;
        }

        .opcion-voto input {
            width: auto;
        }

        .opcion-voto label {
            margin: 0;
            font-weight: normal;
        }

        .barra-fondo {
            height: 12px;
            background: #e2e8f0;
            border-radius: 20px;
            overflow: hidden;
            margin: 6px 0 12px;
        }

        .barra {
            height: 100%;
            background: #2563eb;
        }

        .resultado-linea {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            font-size: 14px;
        }

        .acciones {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-top: 18px;
            flex-wrap: wrap;
        }

        .eliminar {
            background: #dc2626;
        }

        .boton-volver {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 22px;
            background: #1e293b;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
        }

        .contenedor-volver {
            text-align: center;
        }

        .vacio {
            text-align: center;
            color: #64748b;
            padding: 20px;
        }

        @media(max-width:600px) {
            .opciones {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="contenedor">
        <h1>Plataforma de encuestas</h1>
        <p class="descripcion">Crea encuestas, participa y consulta los resultados</p>

        @if (session('success'))
            <div class="mensaje">{{ session('success') }}</div>
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

        <section class="panel">
            <h2>Crear una encuesta</h2>
            <form action="{{ route('surveys.store') }}" method="POST">
                @csrf
                <label for="title">Pregunta o titulo</label>
                <input id="title" name="title" value="{{ old('title') }}" maxlength="255" required>
                <label for="description">Descripcion (opcional)</label>
                <textarea id="description" name="description">{{ old('description') }}</textarea>
                <label>Opciones de respuesta (minimo 2 y maximo 10)</label>
                <div class="opciones">
                    @for ($i = 0; $i < 4; $i++)
                        <input name="options[]" maxlength="150" placeholder="Opcion {{ $i + 1 }}"
                            value="{{ old('options.' . $i) }}" {{ $i < 2 ? 'required' : '' }}>
                    @endfor
                </div>
                <button class="principal" type="submit">Crear encuesta</button>
            </form>
        </section>

        <section class="panel">
            <h2>Encuestas disponibles y resultados</h2>
            @forelse ($surveys as $survey)
                @php
                    $total = $survey->responses->count();
                @endphp
                <article class="encuesta">
                    <h3>{{ $survey->title }}</h3>
                    @if ($survey->description)
                        <p>{{ $survey->description }}</p>
                    @endif
                    <form action="{{ route('surveys.vote', $survey) }}" method="POST">
                        @csrf
                        @foreach ($survey->options as $option)
                            <div class="opcion-voto">
                                <input type="radio" id="survey-{{ $survey->id }}-{{ $loop->index }}"
                                    name="option" value="{{ $option }}" required>
                                <label
                                    for="survey-{{ $survey->id }}-{{ $loop->index }}">{{ $option }}</label>
                            </div>
                        @endforeach
                        <button type="submit">Enviar respuesta</button>
                    </form>

                    <h4 style="margin:20px 0 12px;">Resultados ({{ $total }} respuestas)</h4>
                    @foreach ($survey->options as $option)
                        @php
                            $votes = $survey->responses->where('option', $option)->count();
                            $percentage = $total > 0 ? round(($votes / $total) * 100, 1) : 0;
                        @endphp
                        <div class="resultado-linea">
                            <span>{{ $option }}</span>
                            <strong>{{ $votes }} ({{ $percentage }}%)</strong>
                        </div>
                        <div class="barra-fondo">
                            <div class="barra" style="width: {{ $percentage }}%;"></div>
                        </div>
                    @endforeach

                    <div class="acciones">
                        <small>Creada el {{ $survey->created_at->format('d/m/Y') }}</small>
                        <form action="{{ route('surveys.destroy', $survey) }}" method="POST"
                            onsubmit="return confirm('¿Eliminar esta encuesta y sus respuestas?')">
                            @csrf
                            @method('DELETE')
                            <button class="eliminar" type="submit">Eliminar encuesta</button>
                        </form>
                    </div>
                </article>
            @empty
                <p class="vacio">Todavia no hay encuestas creadas.</p>
            @endforelse
        </section>

        <div class="contenedor-volver">
            <a href="{{ url('/') }}" class="boton-volver">Volver al menu principal</a>
        </div>
    </div>
</body>

</html>
