
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seguimientos PHP</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            color: #1f2937;
        }

        header {
            background-color: #1e293b;
            color: white;
            text-align: center;
            padding: 40px 20px;
        }

        header h1 {
            margin-bottom: 10px;
        }

        main {
            max-width: 1200px;
            margin: 35px auto;
            padding: 0 20px;
        }

        main h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        .contenedor {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .tarjeta {
            background-color: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        }

        .tarjeta h3 {
            margin-bottom: 12px;
            color: #2563eb;
        }

        .tarjeta p {
            color: #64748b;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .tarjeta a {
            display: inline-block;
            background-color: #2563eb;
            color: white;
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 6px;
        }

        .tarjeta a:hover {
            background-color: #1d4ed8;
        }

        footer {
            text-align: center;
            padding: 20px;
            color: #64748b;
        }
    </style>
</head>

<body>

    <header>
        <h1>SEGUIMIENTOS PHP</h1>
        <p>Menú principal de actividades</p>
    </header>

    <main>
        <h2>Selecciona una actividad</h2>

        <div class="contenedor">

            <div class="tarjeta">
                <h3>1. Lista de tareas</h3>
                <p>Agregar, eliminar y completar tareas.</p>
                <a href="{{ route('tasks.index') }}">Entrar</a>
            </div>

            <div class="tarjeta">
                <h3>2. Calculadora de propinas</h3>
                <p>Calcular propinas según el porcentaje seleccionado.</p>
                <a href="{{ route('tips.index') }}">Entrar</a>
            </div>

            <!-- Generador de contraseñas -->
            <div class="tarjeta">
                <h3>3. Generador de contraseñas</h3>
                <p>Generar contraseñas seguras y personalizadas.</p>
                <a href="{{ route('key.index') }}">Entrar</a>
            </div>

            <div class="tarjeta">
                <h3>4. Gestor de gastos</h3>
                <p>Registrar y organizar gastos diarios.</p>
                <a href="{{ route('expenses.index') }}">Entrar</a>
            </div>

            <div class="tarjeta">
                <h3>5. Sistema de reservas</h3>
                <p>Consultar disponibilidad y reservar servicios.</p>
                <a href="{{ route('reservations.index') }}">Entrar</a>
            </div>

            <div class="tarjeta">
                <h3>6. Gestor de notas</h3>
                <p>Crear, guardar y buscar notas.</p>
                <a href="{{ route('notes.index') }}">Entrar</a>
            </div>

            <div class="tarjeta">
                <h3>7. Calendario de eventos</h3>
                <p>Organizar eventos y recordatorios.</p>
                <a href="{{ route('events.index') }}">Entrar</a>
            </div>

            <div class="tarjeta">
                <h3>8. Plataforma de recetas</h3>
                <p>Buscar y guardar recetas.</p>
                <a href="{{ route('recipes.index') }}">Entrar</a>
            </div>

            <div class="tarjeta">
                <h3>9. Juego de memoria</h3>
                <p>Encontrar parejas de cartas y acumular puntos.</p>
                <a href="{{ route('memory.index') }}">Entrar</a>
            </div>

            <div class="tarjeta">
                <h3>10. Plataforma de encuestas</h3>
                <p>Crear encuestas y consultar resultados.</p>
                <a href="{{ route('surveys.index') }}">Entrar</a>
            </div>

            <div class="tarjeta">
                <h3>11. Cronómetro online</h3>
                <p>Medir tiempos y registrar vueltas.</p>
                <a href="{{ route('stopwatch.index') }}">Entrar</a>
            </div>

        </div>
    </main>

    <footer>
        <p>EJERCICIOS DE SEGUIMIENTOS PHP</p>
    </footer>

</body>
</html>
