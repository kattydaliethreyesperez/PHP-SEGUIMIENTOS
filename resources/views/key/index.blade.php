
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generador de Claves</title>

    {{--Estilos de la interfaz--}}
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #dcdee2, #dcdbe7);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .contenedor {
            background: white;
            width: 100%;
            max-width: 480px;
            padding: 35px;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        h1 {
            text-align: center;
            color: #1e293b;
            margin-bottom: 10px;
        }

        .descripcion {
            text-align: center;
            color: #64748b;
            margin-bottom: 25px;
            line-height: 1.5;
        }

        label {
            display: block;
            color: #334155;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="number"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 16px;
        }

        .opciones {
            margin-bottom: 20px;
        }

        .opcion {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 12px 0;
            font-weight: normal;
        }

        .opcion input {
            width: 17px;
            height: 17px;
            accent-color: #4338ca;
        }

        button {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 8px;
            background: #4338ca;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background: #3730a3;
        }

        .resultado {
            margin-top: 25px;
            padding: 18px;
            background: #eef2ff;
            border: 1px solid #c7d2fe;
            border-radius: 10px;
        }

        .resultado p {
            color: #3730a3;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .clave-generada {
            overflow-wrap: anywhere;
            color: #1e293b;
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .error {
            color: #dc2626;
            font-size: 14px;
            margin-bottom: 12px;
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

        .contenedor-volver {
            text-align: center;
        }
    </style>
</head>

<body>

    {{--Contenedor principal del generador--}}
    <div class="contenedor">

        <h1>Generador de Claves</h1>

        <p class="descripcion">
            Crea claves seguras y personalizadas seleccionando
            la longitud y los tipos de caracteres
        </p>

        {{--Formulario para configurar la clave--}}
        <form action="{{ route('key.generar') }}" method="POST">
            @csrf

            <label for="longitud">Longitud de la clave:</label>

            <input
                type="number"
                id="longitud"
                name="longitud"
                min="8"
                max="32"
                value="{{ old('longitud', 12) }}"
                required
            >

        {{--Opciones de caracteres disponibles--}}
            <div class="opciones">
                <label>Tipos de caracteres:</label>

                <label class="opcion">
                    <input type="checkbox" name="mayusculas" value="1"
                        {{ old('mayusculas') ? 'checked' : '' }}>
                    Letras mayusculas (A-Z)
                </label>

                <label class="opcion">
                    <input type="checkbox" name="minusculas" value="1"
                        {{ old('minusculas') ? 'checked' : '' }}>
                    Letras minusculas (a-z)
                </label>

                <label class="opcion">
                    <input type="checkbox" name="numeros" value="1"
                        {{ old('numeros') ? 'checked' : '' }}>
                    Numeros (0-9)
                </label>

                <label class="opcion">
                    <input type="checkbox" name="simbolos" value="1"
                        {{ old('simbolos') ? 'checked' : '' }}>
                    Simbolos (!@#$%&)
                </label>
            </div>

            {{--Mensajes de validacio--}}
            @error('opciones')
                <p class="error">{{ $message }}</p>
            @enderror

            @error('longitud')
                <p class="error">{{ $message }}</p>
            @enderror

            <button type="submit">Generar clave segura</button>
        </form>

        {{--Resultado de la clave generada--}}
        @isset($key)
            <div class="resultado">
                <p>Tu clave generada es:</p>

                <div class="clave-generada">
                    {{ $key }}
                </div>
            </div>
        @endisset

        {{--Boton para regresar al menu principal--}}
            <div class="contenedor-volver">
                <a href="{{ url('/') }}" class="boton-volver">
                Volver al menú principal
                </a>
            </div>

</body>
</html>
