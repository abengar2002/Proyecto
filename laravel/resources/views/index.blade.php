<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cine Screenbites - Inicio</title>

    <style>
        :root {
            --color-negro: #000000;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Arial Black', 'Arial Bold', sans-serif;
            overflow: hidden;
            background-color: var(--color-negro);
            width: 100%;
            height: 100vh;
        }

        .hero-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            z-index: 1;
            transition: opacity 0.4s ease;
        }

        .hero-bg.fade {
            opacity: 0.2;
        }

        header {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 5% 30px 2.5%;
            z-index: 1000;
        }

        header .logo img {
            height: 80px;
        }

        header nav ul {
            list-style: none;
            display: flex;
            gap: 40px;
        }

        header nav a {
            text-decoration: none;
            color: var(--color-negro);
            text-transform: uppercase;
            font-size: 13px;
            font-weight: 900;
            letter-spacing: 2px;
            transition: color 0.3s ease;
        }

        /* --- HERO CONTAINER --- */
        .hero {
            height: 100vh;
            display: flex;
            align-items: center;
            padding: 0 5%;
            position: relative;
            color: var(--color-negro);
            transition: color 0.3s ease;
        }

        .hero-container {
            display: flex;
            width: 100%;
            justify-content: space-between;
            align-items: flex-end;
            padding-bottom: 5vh;
            position: relative;
            z-index: 10;
        }

        /* --- INFO IZQUIERDA --- */
        .hero-info {
            width: 35%;
        }

        .title-wrapper {
            display: flex;
            align-items: flex-end;
            gap: 20px;
        }

        .number {
            font-size: 150px;
            font-weight: 100;
            font-family: Arial, sans-serif;
            color: transparent;
            -webkit-text-stroke: 2px currentColor;
            line-height: 0.75;
            transition: all 0.3s ease;
        }

        .title-details {
            padding-bottom: 5px;
        }

        .title-details h1 {
            font-size: 50px;
            margin: 0 0 5px 0;
            font-weight: 900;
            display: flex;
            align-items: center;
            gap: 15px;
            letter-spacing: -1px;
        }

        .age-rating {
            font-size: 14px;
            border: 2px solid currentColor;
            padding: 3px 8px;
            border-radius: 4px;
            letter-spacing: 1px;
        }

        /* --- ESTILOS PARA LAS ESTRELLAS EN IMAGEN --- */
        .stars {
            display: flex;
            align-items: center;
            gap: 4px;
            margin-top: 5px;
        }

        .star-icon {
            width: 18px;
            height: auto;
        }

        .genre {
            font-size: 12px;
            margin-top: 8px;
            font-weight: bold;
        }

        .hero-buttons {
            margin-top: 40px;
            display: flex;
            gap: 20px;
        }

        .btn-primary,
        .btn-secondary {
            padding: 12px 25px;
            font-weight: 900;
            font-size: 12px;
            letter-spacing: 1px;
            text-transform: uppercase;
            cursor: pointer;
            border-radius: 4px;
            border: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-primary {
            background: var(--color-negro);
            color: #ffd000;
            gap: 10px;
        }

        .btn-primary img {
            width: 20px;
        }

        .btn-secondary {
            background: transparent;
            border: 2px solid currentColor;
            color: inherit;
        }

        /* --- CARRUSEL --- */
        .hero-slider-section {
            width: 45%;
            position: relative;
            height: 400px;
        }

        .custom-slider {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .slide-item {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 220px;
            transition: all 0.5s cubic-bezier(0.25, 0.8, 0.25, 1);
            pointer-events: none;
        }

        .slide-item img.poster-img {
            width: 100%;
            border-radius: 4px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            border: 4px solid transparent;
            transition: border-color 0.3s ease;
        }

        .slide-item.active {
            transform: translate(-50%, -60%) scale(1.15);
            opacity: 1;
            z-index: 10;
            pointer-events: auto;
        }

        .slide-item.prev {
            transform: translate(-140%, -50%) scale(0.85);
            opacity: 0.5;
            z-index: 5;
            pointer-events: auto;
            cursor: pointer;
        }

        .slide-item.next {
            transform: translate(40%, -50%) scale(0.85);
            opacity: 0.5;
            z-index: 5;
            pointer-events: auto;
            cursor: pointer;
        }

        .slide-item.hidden-left {
            transform: translate(-250%, -50%) scale(0.5);
            opacity: 0;
            z-index: 1;
        }

        .slide-item.hidden-right {
            transform: translate(150%, -50%) scale(0.5);
            opacity: 0;
            z-index: 1;
        }

        /* --- BARRITA DE PROGRESO ANIMADA --- */
        .progress-track {
            position: absolute;
            bottom: -15px;
            left: 0;
            width: 100%;
            height: 4px;
            background: rgba(128, 128, 128, 0.3);
            border-radius: 2px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .slide-item.active .progress-track {
            opacity: 1;
        }

        .progress-fill {
            height: 100%;
            width: 0%;
            background: currentColor;
            border-radius: 2px;
        }

        @keyframes fillBar {
            0% {
                width: 0%;
            }

            100% {
                width: 100%;
            }
        }

        .slide-item.active .progress-fill {
            animation: fillBar 6s linear forwards;
        }

        /* Flechas */
        .hero-navigation {
            position: absolute;
            bottom: -20px;
            width: 100%;
            display: flex;
            justify-content: center;
            gap: 15px;
            z-index: 20;
        }

        .nav-btn {
            width: 40px;
            height: 40px;
            border: 2px solid currentColor;
            border-radius: 50%;
            background: transparent;
            color: inherit;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .nav-btn:hover {
            background: var(--color-negro);
            color: white;
            border-color: var(--color-negro);
        }
    </style>
</head>

<body>

    <main class="hero" id="main-hero">

        <img src="{{ asset('img/1-Kill-Bill/Portada.png') }}" alt="Fondo Pantalla" class="hero-bg" id="hero-bg">

        <header>
            <div class="logo">
                <img src="{{ asset('img/img/Logo-Negro.png') }}" alt="Cine Logo" id="main-logo">
            </div>
            <nav>
                <ul>
                    <li><a href="/">HOME</a></li>
                    <li><a href="/peliculas">FILMS</a></li>
                    <li><a href="/bar">MENUS</a></li>
                    <li><a href="/contacto">CONTACT</a></li>
                </ul>
            </nav>
        </header>

        <div class="hero-container">

            <div class="hero-info">
                <div class="title-wrapper">
                    <span class="number" id="movie-id">01</span>
                    <div class="title-details">
                        <h1 id="movie-title">Kill Bill <span class="age-rating" id="movie-age">+18</span></h1>

                        <div class="stars" id="movie-stars"></div>

                        <p class="genre" id="movie-genre">Genre: Action, Suspense, Drama</p>
                    </div>
                </div>

                <div class="hero-buttons">
                    <button class="btn-primary" id="btn-buy">
                        <img src="{{ asset('img/img/Ticket-amarillo.png') }}" id="ticket-icon"> BUY TICKETS
                    </button>
                    <button class="btn-secondary">VIEW FILM</button>
                </div>
            </div>

            <div class="hero-slider-section">
                <div class="custom-slider" id="slider-track">
                </div>

                <div class="hero-navigation">
                    <button class="nav-btn" id="btn-prev">❮</button>
                    <button class="nav-btn" id="btn-next">❯</button>
                </div>
            </div>

        </div>
    </main>

    <script>
        // 1. BASE DE DATOS CON COLORES CALCADOS DE TUS MAQUETAS
        const movies = [
            { id: "01", title: "Kill Bill", age: "+18", rating: 4, genre: "Action, Suspense, Drama", bg: "#ffd000", textColor: "black", bgImg: "{{ asset('img/1-Kill-Bill/Portada.png') }}", poster: "{{ asset('img/1-Kill-Bill/Mini.png') }}" },
            { id: "02", title: "Five Nights", age: "+16", rating: 3, genre: "Horror, Thriller", bg: "#1a0429", textColor: "white", bgImg: "{{ asset('img/2-Five-Nights/Portada.png') }}", poster: "{{ asset('img/2-Five-Nights/Mini.png') }}" },
            { id: "03", title: "Godzilla", age: "+12", rating: 4, genre: "Action, Sci-Fi", bg: "#0a2233", textColor: "white", bgImg: "{{ asset('img/3-Godzilla/Portada.png') }}", poster: "{{ asset('img/3-Godzilla/Mini.png') }}" },
            { id: "04", title: "Oppenheimer", age: "+16", rating: 5, genre: "Biography, Drama, History", bg: "#2e1409", textColor: "white", bgImg: "{{ asset('img/4-Oppenheimer/Portada.png') }}", poster: "{{ asset('img/4-Oppenheimer/Mini.png') }}" },
            { id: "05", title: "Up", age: "TP", rating: 5, genre: "Animation, Adventure, Comedy", bg: "#a1cce0", textColor: "black", bgImg: "{{ asset('img/5-Up/Portada.png') }}", poster: "{{ asset('img/5-Up/Mini.png') }}" },
            { id: "06", title: "The Joker", age: "+18", rating: 5, genre: "Crime, Drama, Thriller", bg: "#120908", textColor: "white", bgImg: "{{ asset('img/6-The-Joker/Portada.png') }}", poster: "{{ asset('img/6-The-Joker/Mini.png') }}" },
            { id: "07", title: "Alien", age: "+18", rating: 4, genre: "Horror, Sci-Fi", bg: "#051417", textColor: "white", bgImg: "{{ asset('img/7-Alien/Portada.png') }}", poster: "{{ asset('img/7-Alien/Mini.png') }}" },
            { id: "08", title: "Interstellar", age: "+12", rating: 5, genre: "Adventure, Drama, Sci-Fi", bg: "#090a0a", textColor: "white", bgImg: "{{ asset('img/8-Interstellar/Portada.png') }}", poster: "{{ asset('img/8-Interstellar/Mini.png') }}" },
            { id: "09", title: "Barbie", age: "TP", rating: 4, genre: "Comedy, Fantasy", bg: "#51caf5", textColor: "white", bgImg: "{{ asset('img/9-Barbie/Portada.png') }}", poster: "{{ asset('img/9-Barbie/Mini.png') }}" }
        ];

        let currentIndex = 0;
        const totalMovies = movies.length;

        let autoPlayTimer;
        const AUTO_PLAY_DELAY = 6000;

        const sliderTrack = document.getElementById('slider-track');
        const mainHero = document.getElementById('main-hero');
        const heroBg = document.getElementById('hero-bg');

        movies.forEach((movie, index) => {
            const div = document.createElement('div');
            div.classList.add('slide-item');
            div.innerHTML = `
                <img src="${movie.poster}" alt="${movie.title}" class="poster-img">
                <div class="progress-track"><div class="progress-fill"></div></div>
            `;

            div.addEventListener('click', () => {
                if (div.classList.contains('prev')) moveSlider(-1);
                if (div.classList.contains('next')) moveSlider(1);
            });
            sliderTrack.appendChild(div);
        });

        const slides = document.querySelectorAll('.slide-item');

        function updateCarousel() {
            slides.forEach((slide, index) => {
                slide.className = 'slide-item';

                let diff = (index - currentIndex + totalMovies) % totalMovies;

                if (diff === 0) {
                    slide.classList.add('active');
                } else if (diff === 1) {
                    slide.classList.add('next');
                } else if (diff === totalMovies - 1) {
                    slide.classList.add('prev');
                } else if (diff > 1 && diff <= totalMovies / 2) {
                    slide.classList.add('hidden-right');
                } else {
                    slide.classList.add('hidden-left');
                }
            });

            const activeMovie = movies[currentIndex];

            heroBg.classList.add('fade');
            setTimeout(() => {
                heroBg.src = activeMovie.bgImg;
                heroBg.classList.remove('fade');
            }, 200);

            document.getElementById('movie-id').textContent = activeMovie.id;
            document.getElementById('movie-title').innerHTML = `${activeMovie.title} <span class="age-rating">${activeMovie.age}</span>`;
            document.getElementById('movie-genre').textContent = `Genre: ${activeMovie.genre}`;

            // --- LÓGICA DE LAS ESTRELLAS EN IMAGEN ---
            const isBlackStar = activeMovie.id === "01"; // Solo la 01 lleva estrellas negras, como pediste
            const starFilled = isBlackStar ? "{{ asset('img/img/Estrella-Negra.svg') }}" : "{{ asset('img/img/Estrella-Amarilla.svg') }}";
            const starEmpty = isBlackStar ? "{{ asset('img/img/Estrella-Negra-Vacia.svg') }}" : "{{ asset('img/img/Estrella-Amarilla-Vacia.svg') }}";

            let starsHTML = '';
            for (let i = 0; i < 5; i++) {
                if (i < activeMovie.rating) {
                    starsHTML += `<img src="${starFilled}" alt="Star" class="star-icon">`;
                } else {
                    starsHTML += `<img src="${starEmpty}" alt="Empty Star" class="star-icon">`;
                }
            }
            document.getElementById('movie-stars').innerHTML = starsHTML;
            // -----------------------------------------

            const color = activeMovie.textColor;
            mainHero.style.color = color;
            document.querySelectorAll('header nav a').forEach(a => a.style.color = color);
            document.getElementById('movie-id').style.webkitTextStroke = `2px ${color}`;

            const logoEl = document.getElementById('main-logo');
            logoEl.src = color === "white" ? "{{ asset('img/img/Logo-Blanco.png') }}" : "{{ asset('img/img/Logo-Negro.png') }}";

            const btnPrimary = document.getElementById('btn-buy');
            if (color === 'white') {
                btnPrimary.style.background = '#ffffff';
                btnPrimary.style.color = '#000000';
            } else {
                btnPrimary.style.background = '#000000';
                btnPrimary.style.color = activeMovie.bg;
            }
        }

        function moveSlider(direction) {
            currentIndex = (currentIndex + direction + totalMovies) % totalMovies;
            updateCarousel();
            resetAutoPlay();
        }

        function resetAutoPlay() {
            clearInterval(autoPlayTimer);
            autoPlayTimer = setInterval(() => {
                moveSlider(1);
            }, AUTO_PLAY_DELAY);
        }

        document.getElementById('btn-prev').addEventListener('click', () => moveSlider(-1));
        document.getElementById('btn-next').addEventListener('click', () => moveSlider(1));

        updateCarousel();
        resetAutoPlay();
    </script>
</body>

</html>