<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cine Screenbites - Inicio</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <style>
        :root {
            --color-killbill-amarillo: #ffd000;
            --color-killbill-rojo: #e30613;
            --color-blanco: #ffffff;
            --color-negro: #000000;
        }

        body {
            margin: 0;
            font-family: 'Arial Black', 'Arial Bold', sans-serif;
            overflow: hidden; 
            background-color: var(--color-negro);
        }

        /* --- HEADER --- */
        header {
            position: fixed;
            top: 0;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 30px 60px;
            box-sizing: border-box;
            z-index: 1000;
        }

        header .logo img {
            height: 60px; 
        }

        header nav ul {
            list-style: none;
            display: flex;
            gap: 40px;
            margin: 0;
            padding: 0;
        }

        header nav a {
            text-decoration: none;
            color: var(--color-negro);
            text-transform: uppercase;
            font-size: 15px;
            font-weight: 900;
            letter-spacing: 1.5px;
        }

        /* --- HERO --- */
        .hero {
            background-color: var(--color-killbill-amarillo);
            height: 100vh;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 5%;
            position: relative;
            color: var(--color-negro);
        }

        /* =========================================================
           ¡LA SOLUCIÓN A LA IMAGEN CORTADA/APLASTADA!
           ========================================================= */
        .hero-character {
            position: absolute;
            bottom: 0;
            height: 100vh; /* Alto casi hasta el techo */
            transform: translateX(-20%); /* La movemos un pelín a la derecha */
            z-index: 1; /* Detrás de las letras y slider */
        }

        /* Contenedor principal */
        .hero-container {
            display: flex;
            width: 100%;
            justify-content: space-between;
            align-items: center;
            z-index: 2; 
        }

        /* --- INFO IZQUIERDA --- */
        .hero-info {
            width: 40%;
            padding-left: 20px;
        }

        .title-wrapper {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .number {
            font-size: 120px;
            font-weight: 300;
            color: transparent;
            -webkit-text-stroke: 2px var(--color-negro);
            line-height: 1;
        }

        .title-details h1 {
            font-size: 55px;
            margin: 0;
            font-weight: 900;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .age-rating {
            font-size: 18px;
            border: 2px solid var(--color-negro);
            padding: 4px 8px;
            border-radius: 4px;
        }

        .stars {
            font-size: 24px;
            margin-top: 5px;
            color: var(--color-negro);
        }

        .genre {
            font-size: 15px;
            margin-top: 8px;
            font-weight: bold;
        }

        .hero-buttons {
            margin-top: 40px;
            display: flex;
            gap: 20px;
        }

        .btn-primary, .btn-secondary {
            padding: 15px 30px;
            font-weight: 900;
            font-size: 14px;
            text-transform: uppercase;
            cursor: pointer;
            border-radius: 4px;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: var(--color-negro);
            color: var(--color-killbill-amarillo);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-secondary {
            background: transparent;
            color: var(--color-negro);
            border: 3px solid var(--color-negro);
        }

        /* --- SLIDER DERECHA --- */
        .hero-slider-section {
            width: 45%;
            position: relative;
        }

        .swiper {
            width: 100%;
            padding-bottom: 60px;
        }

        .swiper-slide {
            width: 220px !important; 
            transition: transform 0.3s ease, opacity 0.3s ease;
            opacity: 0.5; 
        }

        .swiper-slide img {
            width: 100%;
            border-radius: 4px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.4);
        }

        .swiper-slide-active {
            transform: scale(1.15) translateY(-20px); 
            opacity: 1; 
            z-index: 10;
        }
        
        .swiper-slide-active img {
            border: 5px solid var(--color-negro);
        }

        /* Flechas */
        .hero-navigation {
            position: absolute;
            bottom: 0px;
            right: 20px;
            display: flex;
            gap: 15px;
        }

        .swiper-button-next, .swiper-button-prev {
            position: static;
            width: 45px;
            height: 45px;
            border: 2px solid var(--color-negro);
            border-radius: 50%;
            color: var(--color-negro);
            margin: 0;
        }
        
        .swiper-button-next::after, .swiper-button-prev::after {
            font-size: 20px;
            font-weight: 900;
        }
    </style>
</head>
<body>

    <header>
        <div class="logo">
            <img src="{{ asset('img/img/Logo-Negro.png') }}" alt="Cine Logo">
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

    <main class="hero hero-kb">
        
        <img src="{{ asset('img/1-Kill-Bill/Portada.png') }}" alt="Beatrix Kiddo" class="hero-character">

        <div class="hero-container">
            
            <div class="hero-info">
                <div class="title-wrapper">
                    <span class="number">01</span>
                    <div class="title-details">
                        <h1>Kill Bill <span class="age-rating">+18</span></h1>
                        <div class="stars">★★★★☆</div>
                        <p class="genre">Genre: Action, Suspense, Drama</p>
                    </div>
                </div>
                
                <div class="hero-buttons">
                    <button class="btn-primary">
                        <img src="{{ asset('img/img/Ticket-amarillo.png') }}"> BUY TICKETS
                    </button>
                    <button class="btn-secondary">VIEW FILM</button>
                </div>
            </div>

            <div class="hero-slider-section">
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        
                        <div class="swiper-slide">
                            <img src="{{ asset('img/9-Barbie/Mini.png') }}" alt="Barbie">
                        </div>
                        
                        <div class="swiper-slide">
                            <img src="{{ asset('img/1-Kill-Bill/Mini.png') }}" alt="Kill Bill">
                        </div>
                        
                        <div class="swiper-slide">
                            <img src="{{ asset('img/2-Five-Nights/Mini.png') }}" alt="FNAF">
                        </div>
                        
                    </div>
                </div>
                
                <div class="hero-navigation">
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>

        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".mySwiper", {
          slidesPerView: "auto", 
          centeredSlides: true,  
          spaceBetween: 40,      
          loop: true,            
          navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
          },
        });
    </script>
</body>
</html>