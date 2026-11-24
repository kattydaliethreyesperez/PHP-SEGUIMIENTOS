<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Calculadora de propinas</title>

    <style>
        /*Estilos generales de la pagina */
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

        /*Contenedor principal */
        .contenedor {
            max-width: 600px;
            margin: auto;
            background-color: white;
            padding: 30px;
            border-radius: 12px;
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

        /*Campos del formulario */
        .grupo {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input,
        select {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-size: 16px;
        }

        /*Botn para los calculos*/
        button {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 6px;
            background-color: #2563eb;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #1d4ed8;
        }

        /*Mensajes de error*/
        .error {
            background-color: #fee2e2;
            color: #b91c1c;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        /*Contenedor de resultados*/
        .resultado {
            margin-top: 25px;
            padding: 20px;
            background-color: #eff6ff;
            border-radius: 8px;
        }

        .resultado h2 {
            margin-bottom: 15px;
            text-align: center;
        }

        .fila {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 12px;
        }

        .total {
            border-top: 1px solid #bfdbfe;
            padding-top: 15px;
            font-size: 20px;
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

        <h1>Calculadora de propinas</h1>

        <p class="descripcion">
            Calcula facilmente la propina y el total de tu cuenta!
        </p>

        {{--Muestra los errores de validacion--}}
        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        {{--Formulario para ingresar los datos--}}
        <form action="{{ route('tips.index') }}" method="GET">

            <div class="grupo">
                <label for="monto">Monto total de la cuenta ($)</label>

                <input
                    type="number"
                    id="monto"
                    name="monto"
                    step="0.01"
                    min="0.01"
                    placeholder="Ejemplo: 50000"
                    value="{{ old('monto', $monto) }}"
                    required
                >
            </div>

            <div class="grupo">
                <label for="porcentaje">Porcentaje de propina</label>

                <select id="porcentaje" name="porcentaje" required>
                    <option value="">Selecciona un porcentaje</option>

                    <option value="5" {{ $porcentaje == 5 ? 'selected' : '' }}>
                        5%
                    </option>

                    <option value="10" {{ $porcentaje == 10 ? 'selected' : '' }}>
                        10%
                    </option>

                    <option value="15" {{ $porcentaje == 15 ? 'selected' : '' }}>
                        15%
                    </option>

                    <option value="20" {{ $porcentaje == 20 ? 'selected' : '' }}>
                        20%
                    </option>

                    <option value="25" {{ $porcentaje == 25 ? 'selected' : '' }}>
                        25%
                    </option>
                </select>
            </div>

            {{--Identifica el envio del formulario--}}
            <input type="hidden" name="calcular" value="1">

            <button type="submit">
                Calcular propina
            </button>

        </form>

        {{--Muestra los resultados cuando se realiza el calculo--}}
        @if ($propina !== null)

            <div class="resultado">

                <h2>Resultados</h2>

                <div class="fila">
                    <span>Monto de la cuenta:</span>
                    <strong>${{ number_format($monto, 2, ',', '.') }}</strong>
                </div>

                <div class="fila">
                    <span>Propina ({{ $porcentaje }}%):</span>
                    <strong>${{ number_format($propina, 2, ',', '.') }}</strong>
                </div>

                <div class="fila total">
                    <span>Total a pagar:</span>
                    <strong>${{ number_format($total, 2, ',', '.') }}</strong>
                </div>

            </div>

        @endif

        {{--Boton para regresar al menu principal--}}
            <div class="contenedor-volver">
                <a href="{{ url('/') }}" class="boton-volver">
                Volver al menu principal
                </a>
            </div>

    </div>

</body>
</html>
