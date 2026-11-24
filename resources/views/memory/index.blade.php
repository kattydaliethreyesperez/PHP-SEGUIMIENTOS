
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juego de memoria</title>

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
            max-width: 650px;
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
            display: flex;
            justify-content: center;
            gap: 25px;
            flex-wrap: wrap;
            background-color: white;
            padding: 18px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.06);
        }

        .dato strong {
            display: block;
            font-size: 23px;
            color: #2563eb;
            margin-top: 5px;
        }

        .tablero {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 20px;
        }

        .carta {
            height: 125px;
            border: none;
            border-radius: 10px;
            background-color: #2563eb;
            color: white;
            font-size: 38px;
            cursor: pointer;
            transition: transform 0.2s, background-color 0.2s;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 4px;
            padding: 5px;
            overflow: hidden;
        }

        .carta:hover:not(:disabled) {
            background-color: #1d4ed8;
            transform: translateY(-2px);
        }

        .carta.revelada,
        .carta.acertada {
            background-color: white;
            border: 2px solid #2563eb;
            color: #1e293b;
            cursor: default;
        }

        .carta img {
            width: 100%;
            height: 85px;
            object-fit: cover;
            border-radius: 6px;
        }

        .nombre-carta {
            display: block;
            font-size: 12px;
            font-weight: bold;
            line-height: 14px;
        }

        .carta.acertada {
            background-color: #dcfce7;
            border-color: #16a34a;
        }

        .botones {
            display: flex;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .boton {
            padding: 12px 20px;
            border: none;
            border-radius: 7px;
            background-color: #2563eb;
            color: white;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
        }

        .boton:hover {
            background-color: #1d4ed8;
        }

        .resultado {
            min-height: 25px;
            margin: 18px 0;
            font-weight: bold;
            color: #166534;
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

        @media (max-width: 480px) {
            .tablero {
                gap: 8px;
            }

            .carta {
                height: 100px;
                font-size: 30px;
            }

            .carta img {
                height: 60px;
            }

            .nombre-carta {
                font-size: 10px;
            }

            .panel {
                gap: 15px;
                padding: 14px 8px;
                flex-wrap: wrap;
            }

            .dato {
                font-size: 13px;
            }
        }
    </style>

</head>

<body>

    <div class="contenedor">

        <h1>Juego de memoria</h1>

        <p class="descripcion">
            Encuentra las parejas de imágenes iguales. Cada pareja suma 10 puntos.
        </p>

        <div class="panel">

            <div class="dato">
                Dificultad
                <strong>
                    <select id="difficulty">
                        <option value="easy">Fácil</option>
                        <option value="medium" selected>Media</option>
                        <option value="hard">Difícil</option>
                    </select>
                </strong>
            </div>

            <div class="dato">
                Movimientos
                <strong id="movimientos">0</strong>
            </div>

            <div class="dato">
                Puntos
                <strong id="puntos">0</strong>
            </div>

            <div class="dato">
                Parejas
                <strong id="parejas">0 / 8</strong>
            </div>

            <div class="dato">
                Tiempo
                <strong id="tiempo">00:00</strong>
            </div>

        </div>

        {{-- Tablero donde se muestran las cartas del juego --}}
        <div class="tablero" id="tablero"></div>

        <p class="resultado" id="resultado"></p>

        <div class="botones">
            <button type="button" class="boton" id="reiniciar">
                Reiniciar juego
            </button>
        </div>

        {{-- Regresa al menú principal --}}
        <div class="contenedor-volver">
            <a href="{{ url('/') }}" class="boton-volver">
                Volver al menú principal
            </a>
        </div>

    </div>

    <script>

        //Imagenes utilizadas de Unsplash: https://unsplash.com/s/photos/animals
        // Define los animales que forman las parejas
        const images = [
            {
                name: 'Perro',
                image: 'https://images.unsplash.com/photo-1552053831-71594a27632d?w=300'
            },
            {
                name: 'Cachorro',
                image: 'https://images.unsplash.com/photo-1517849845537-4d257902454a?w=300'
            },
            {
                name: 'Gato',
                image: 'https://images.unsplash.com/photo-1533738363-b7f9aef128ce?w=300'
            },
            {
                name: 'Gatico',
                image: 'https://images.unsplash.com/photo-1573865526739-10659fec78a5?w=300'
            },
            {
                name: 'Loro',
                image: 'https://images.unsplash.com/photo-1552728089-57bdde30beb3?w=300'
            },
            {
                name: 'Perros',
                image: 'https://images.unsplash.com/photo-1548199973-03cce0bbc87b?w=300'
            },
            {
                name: 'Perro',
                image: 'https://images.unsplash.com/photo-1560807707-8cc77767d783?w=300'
            },
            {
                name: 'León',
                image: 'https://images.unsplash.com/photo-1546182990-dffeafbe841d?w=300'
            },
            {
                name: 'Zorro',
                image: 'https://images.unsplash.com/photo-1474511320723-9a56873867b5?w=300'
            },
            {
                name: 'Panda',
                image: 'https://images.unsplash.com/photo-1564349683136-77e08dba1ef7?w=300'
            },
            {
                name: 'Gato',
                image: 'https://images.unsplash.com/photo-1543852786-1cf6624b9987?w=300'
            },
            {
                name: 'Ciervo',
                image: 'https://images.unsplash.com/photo-1501706362039-c6e80948a6b5?w=300'
            }
        ];

        let numbers = [1, 2, 3, 4, 5, 6, 7, 8];
        let pairCount = 8;
        let difficulty = 'medium';

        // Guarda el estado actual del juego
        let firstCard = null;
        let secondCard = null;
        let lockBoard = false;
        let moves = 0;
        let matchedPairs = 0;
        let points = 0;
        let seconds = 0;
        let timer = null;
        let started = false;

        const board = document.getElementById('tablero');
        const movesElement = document.getElementById('movimientos');
        const pairsElement = document.getElementById('parejas');
        const pointsElement = document.getElementById('puntos');
        const timeElement = document.getElementById('tiempo');
        const resultElement = document.getElementById('resultado');

        // Mezcla las cartas para cambiar su posición en cada partida
        function shuffleCards(cards) {

            for (let i = cards.length - 1; i > 0; i--) {

                const randomIndex = Math.floor(Math.random() * (i + 1));

                [cards[i], cards[randomIndex]] = [cards[randomIndex], cards[i]];

            }

            return cards;
        }

        // Convierte los segundos en minutos y segundos
        function formatTime(totalSeconds) {

            const minutes = Math.floor(totalSeconds / 60);
            const remainingSeconds = totalSeconds % 60;

            return String(minutes).padStart(2, '0') + ':' +
                String(remainingSeconds).padStart(2, '0');

        }

        // Inicia el cronómetro cuando se voltea la primera carta
        function startTimer() {

            if (started) {
                return;
            }

            started = true;

            timer = setInterval(function () {

                seconds++;
                timeElement.textContent = formatTime(seconds);

            }, 1000);

        }

        // Actualiza los datos que aparecen sobre el tablero
        function updateScore() {

            movesElement.textContent = moves;
            pairsElement.textContent = matchedPairs + ' / ' + pairCount;
            pointsElement.textContent = points;
            timeElement.textContent = formatTime(seconds);

        }

        // Voltea una carta cuando el jugador la selecciona
        function flipCard() {

            if (lockBoard || this.classList.contains('revelada') ||
                this.classList.contains('acertada')) {
                return;
            }

            startTimer();

            this.classList.add('revelada');

            this.innerHTML = '<img src="' + this.dataset.image +
                '" alt="' + this.dataset.name + '">' +
                '<span class="nombre-carta">' + this.dataset.name + '</span>';

            if (!firstCard) {

                firstCard = this;
                return;

            }

            secondCard = this;

            moves++;
            updateScore();
            checkMatch();

        }

        // Comprueba si las dos cartas seleccionadas son iguales
        function checkMatch() {

            const isMatch = firstCard.dataset.number === secondCard.dataset.number;

            if (isMatch) {

                firstCard.classList.add('acertada');
                secondCard.classList.add('acertada');

                matchedPairs++;
                points += 10;

                resetTurn();
                updateScore();

                if (matchedPairs === pairCount) {

                    clearInterval(timer);

                    resultElement.textContent = '¡Felicidades! Encontraste todas las parejas en ' +
                        moves + ' movimientos, ' + points + ' puntos y ' +
                        formatTime(seconds) + '.';

                }

                return;

            }

            lockBoard = true;

            setTimeout(function () {

                firstCard.classList.remove('revelada');
                secondCard.classList.remove('revelada');

                firstCard.innerHTML = '?';
                secondCard.innerHTML = '?';

                resetTurn();

            }, 900);

        }

        // Prepara el turno para seleccionar otras dos cartas
        function resetTurn() {

            firstCard = null;
            secondCard = null;
            lockBoard = false;

        }

        // Crea las cartas y comienza una nueva partida
        function startGame() {

            clearInterval(timer);

            firstCard = null;
            secondCard = null;
            lockBoard = false;

            moves = 0;
            matchedPairs = 0;
            points = 0;
            seconds = 0;
            started = false;

            resultElement.textContent = '';

            updateScore();
            board.innerHTML = '';

            difficulty = document.getElementById('difficulty').value;

            pairCount = difficulty === 'easy' ? 4 :
                (difficulty === 'hard' ? 12 : 8);

            numbers = Array.from({ length: pairCount }, function (_, index) {
                return index + 1;
            });

            pairsElement.textContent = '0 / ' + pairCount;

            const cards = shuffleCards([...numbers, ...numbers]);

            cards.forEach(function (number) {

                const card = document.createElement('button');

                card.type = 'button';
                card.className = 'carta';
                card.textContent = '?';

                card.dataset.number = number;
                card.dataset.image = images[number - 1].image;
                card.dataset.name = images[number - 1].name;

                card.setAttribute('aria-label', 'Carta oculta');
                card.addEventListener('click', flipCard);

                board.appendChild(card);

            });

        }

        // Reinicia el juego cuando se presiona el botón
        document.getElementById('reiniciar').addEventListener('click', startGame);

        document.getElementById('difficulty').addEventListener('change', startGame);

        // Inicia la primera partida al cargar la página
        startGame();

    </script>

</body>
</html>
