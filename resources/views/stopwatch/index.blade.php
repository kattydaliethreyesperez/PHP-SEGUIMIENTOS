<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cronometro online</title>
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
            max-width: 700px;
            margin: auto;
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
            padding: 30px 20px;
            border-radius: 12px;
            box-shadow: 0 3px 10px #0000000d;
        }

        .tiempo {
            font-size: clamp(42px, 10vw, 70px);
            font-weight: bold;
            font-variant-numeric: tabular-nums;
            margin: 20px 0 28px;
        }

        .controles {
            display: flex;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        button {
            padding: 12px 20px;
            border: 0;
            border-radius: 7px;
            color: white;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
        }

        button:disabled {
            opacity: .45;
            cursor: not-allowed;
        }

        .iniciar {
            background: #16a34a;
        }

        .pausar {
            background: #d97706;
        }

        .reiniciar {
            background: #dc2626;
        }

        .vuelta {
            background: #2563eb;
        }

        .lista {
            text-align: left;
            margin-top: 28px;
        }

        .lista h2 {
            margin-bottom: 12px;
            font-size: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 11px;
            border-bottom: 1px solid #e2e8f0;
            text-align: left;
        }

        th {
            background: #f8fafc;
        }

        .vacio {
            color: #64748b;
            text-align: center;
            padding: 15px;
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

        @media(max-width:450px) {

            th,
            td {
                padding: 8px 5px;
                font-size: 13px;
            }
        }
    </style>
</head>

<body>
    <div class="contenedor">
        <h1>Cronometro online</h1>
        <p class="descripcion">Mide el tiempo, pausa y registra tus vueltas</p>

        <section class="panel">
            <div class="tiempo" id="display" aria-live="polite">00:00:00.00</div>
            <div class="controles">
                <button type="button" class="iniciar" id="start">Iniciar</button>
                <button type="button" class="pausar" id="pause" disabled>Pausar</button>
                <button type="button" class="vuelta" id="lap" disabled>Registrar vuelta</button>
                <button type="button" class="reiniciar" id="reset">Reiniciar</button>
            </div>

            <div class="lista">
                <h2>Vueltas registradas</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Vuelta</th>
                            <th>Tiempo parcial</th>
                            <th>Tiempo acumulado</th>
                        </tr>
                    </thead>
                    <tbody id="laps">
                        <tr>
                            <td colspan="3" class="vacio">Todavia no hay vueltas registradas.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <a href="{{ url('/') }}" class="boton-volver">Volver al menu principal</a>
    </div>

    <script>
        const display = document.getElementById('display');
        const startButton = document.getElementById('start');
        const pauseButton = document.getElementById('pause');
        const lapButton = document.getElementById('lap');
        const resetButton = document.getElementById('reset');
        const lapsBody = document.getElementById('laps');

        let startTime = 0;
        let elapsed = 0;
        let interval = null;
        let lastLap = 0;
        let lapCount = 0;

        function formatTime(milliseconds) {
            const centiseconds = Math.floor(milliseconds / 10) % 100;
            const totalSeconds = Math.floor(milliseconds / 1000);
            const seconds = totalSeconds % 60;
            const minutes = Math.floor(totalSeconds / 60) % 60;
            const hours = Math.floor(totalSeconds / 3600);
            return String(hours).padStart(2, '0') + ':' +
                String(minutes).padStart(2, '0') + ':' +
                String(seconds).padStart(2, '0') + '.' +
                String(centiseconds).padStart(2, '0');
        }

        function updateDisplay() {
            const current = elapsed + (interval ? Date.now() - startTime : 0);
            display.textContent = formatTime(current);
        }

        startButton.addEventListener('click', function() {
            if (interval) return;
            startTime = Date.now();
            interval = setInterval(updateDisplay, 10);
            startButton.disabled = true;
            pauseButton.disabled = false;
            lapButton.disabled = false;
        });

        pauseButton.addEventListener('click', function() {
            if (!interval) return;
            elapsed += Date.now() - startTime;
            clearInterval(interval);
            interval = null;
            updateDisplay();
            startButton.disabled = false;
            pauseButton.disabled = true;
            lapButton.disabled = true;
        });

        lapButton.addEventListener('click', function() {
            if (!interval) return;
            const total = elapsed + Date.now() - startTime;
            const partial = total - lastLap;
            lapCount++;
            lastLap = total;

            if (lapCount === 1) lapsBody.innerHTML = '';
            const row = document.createElement('tr');
            [lapCount, formatTime(partial), formatTime(total)].forEach(function(value) {
                const cell = document.createElement('td');
                cell.textContent = value;
                row.appendChild(cell);
            });
            lapsBody.prepend(row);
        });

        resetButton.addEventListener('click', function() {
            if (interval) clearInterval(interval);
            interval = null;
            elapsed = 0;
            startTime = 0;
            lastLap = 0;
            lapCount = 0;
            display.textContent = '00:00:00.00';
            lapsBody.innerHTML = '<tr><td colspan="3" class="vacio">Todavia no hay vueltas registradas.</td></tr>';
            startButton.disabled = false;
            pauseButton.disabled = true;
            lapButton.disabled = true;
        });
    </script>
</body>

</html>
