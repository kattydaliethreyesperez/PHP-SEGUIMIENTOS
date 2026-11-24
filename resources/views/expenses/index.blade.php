
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de gastos</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f1f5f9;
            padding: 30px 15px;
            color: #1e293b;
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

        input, select {
            padding: 11px;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            font-size: 14px;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #2563eb;
        }

        /*Boton que envia el formulario*/
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

        .error {
            color: #dc2626;
            font-size: 13px;
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

        /*Boton para eliminar un gasto*/
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

        .total {
            margin-top: 20px;
            text-align: right;
            font-size: 20px;
            font-weight: bold;
        }

        .sin-gastos {
            text-align: center;
            color: #64748b;
            padding: 20px;
        }

        /*Boton para regresar al menu principal*/
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
        <h1>Gestor de gastos</h1>
        <p class="descripcion">Registra y administra tus gastos personales</p>

        @if (session('success'))
            <div class="mensaje">
                {{ session('success') }}
            </div>
        @endif

        {{--Comprueba si existen errores de validacion--}}
        @if ($errors->any())
            <div class="mensaje" style="background-color: #fee2e2; color: #991b1b;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{--Formulario para registrar un nuevo gasto--}}
        <div class="tarjeta">
            <h2>Registrar nuevo gasto</h2>

            <form action="{{ route('expenses.store') }}" method="POST" class="formulario">

                @csrf

                {{--Solicita la descripcion del gasto al usuario--}}
                <div class="campo campo-completo">
                    <label for="description">Descripcion</label>
                    <input type="text" id="description" name="description"
                        value="{{ old('description') }}"
                        placeholder="Ejemplo: Compra de alimentos" required>
                </div>

                {{--Agrega el monto que se gasto--}}
                <div class="campo">
                    <label for="amount">Monto</label>
                    <input type="number" id="amount" name="amount"
                        value="{{ old('amount') }}"
                        min="0.01" step="0.01"
                        placeholder="Ejemplo: 50000" required>
                </div>

                {{--Permite seleccionar la categoria a la que pertenece el gasto--}}
                <div class="campo">
                    <label for="category">Categoria</label>
                    <select id="category" name="category" required>
                        <option value="">Selecciona una categoria</option>
                        <option value="Alimentacion" {{ old('category') == 'Alimentacion' ? 'selected' : '' }}>Alimentacion</option>
                        <option value="Transporte" {{ old('category') == 'Transporte' ? 'selected' : '' }}>Transporte</option>
                        <option value="Salud" {{ old('category') == 'Salud' ? 'selected' : '' }}>Salud</option>
                        <option value="Educacion" {{ old('category') == 'Educacion' ? 'selected' : '' }}>Educacion</option>
                        <option value="Entretenimiento" {{ old('category') == 'Entretenimiento' ? 'selected' : '' }}>Entretenimiento</option>
                        <option value="Otros" {{ old('category') == 'Otros' ? 'selected' : '' }}>Otros</option>
                    </select>
                </div>

                {{--Agrega fecha en la que se realizo el gasto--}}
                <div class="campo campo-completo">
                    <label for="expense_date">Fecha del gasto</label>
                    <input type="date" id="expense_date" name="expense_date"
                        value="{{ old('expense_date', date('Y-m-d')) }}" required>
                </div>

                {{--Resgistra el gasto--}}
                <button type="submit" class="boton-registrar">
                    Registrar gasto
                </button>
            </form>
        </div>

        <div class="tarjeta">
            <h2>Resumen mensual de gastos</h2>
            <form action="{{ route('expenses.index') }}" method="GET" style="display:flex;gap:10px;margin-bottom:18px;flex-wrap:wrap;">
                <label for="month">Selecciona el mes:</label>
                <input type="month" id="month" name="month" value="{{ $month }}" required>
                <button type="submit" class="boton-registrar">Consultar</button>
            </form>
            <h3 style="margin-bottom:15px;">Gastos de {{ $month }}</h3>

            @if ($expenses->count() > 0)

                {{--Tabla para organizar la informacion de cada gasto--}}
                <div class="tabla-contenedor">
                    <table>
                        <thead>
                            <tr>
                                <th>Descripcion</th>
                                <th>Monto</th>
                                <th>Categoria</th>
                                <th>Fecha</th>
                                <th>Accion</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($expenses as $expense)
                                <tr>
                                    <td>{{ $expense->description }}</td>

                                    <td>${{ number_format((float) $expense->amount, 2, ',', '.') }}</td>

                                    <td>{{ $expense->category }}</td>

                                    <td>{{ $expense->expense_date->format('d/m/Y') }}</td>

                                    {{--Frmulario para eliminar el gasto seleccionado--}}
                                    <td>
                                        <form action="{{ route('expenses.destroy', $expense) }}"
                                            method="POST"
                                            onsubmit="return confirm('¿Estas seguro de eliminar este gasto?')">

                                            @csrf

                                            @method('DELETE')

                                            {{--Boton que elimina el gasto seleccionado--}}
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

                {{--Calcula los montos--}}
                <div class="total">
                    Total: ${{ number_format((float) $monthlyTotal, 2, ',', '.') }}
                </div>
            @else
                <p class="sin-gastos">Todavia no tienes gastos registrados.</p>
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
