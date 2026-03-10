<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cine Screenbites - Inicio</title>

    <style>
        :root {
            --color-negro: #000000;
            --color-gris-oscuro: #0a0a0a;
            --color-gris-tarjeta: #141414;
            --color-gris-claro: #333333;
            --color-blanco: #ffffff;
            --color-amarillo: #ffd000;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Arial Black', 'Arial Bold', sans-serif;
            overflow-x: hidden;
            background-color: var(--color-negro);
            color: var(--color-blanco);
            width: 100%;
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
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 5%;
            height: 100px;
            z-index: 1000;
            background-color: transparent;
            border-bottom: 1px solid transparent;
            transition: background-color 0.3s ease, box-shadow 0.3s ease, border-bottom 0.3s ease;
        }

        header.scrolled {
            background-color: rgba(0, 0, 0, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.8);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        header .logo img {
            height: 50px;
        }

        header nav ul {
            list-style: none;
            display: flex;
            align-items: center;
            gap: 30px;
        }

        header nav a,
        .logout-btn {
            text-decoration: none;
            color: var(--header-text-color, var(--color-negro));
            text-transform: uppercase;
            font-size: 13px;
            font-weight: 900;
            letter-spacing: 2px;
            transition: color 0.3s ease, transform 0.2s ease;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        header nav a:hover,
        .logout-btn:hover {
            color: var(--color-amarillo) !important;
            transform: scale(1.05);
        }

        .user-nav {
            display: flex;
            align-items: center;
            gap: 20px;
            border-left: 2px solid rgba(255, 255, 255, 0.2);
            padding-left: 20px;
            margin-left: 10px;
        }

        .user-name {
            color: var(--color-amarillo) !important;
        }

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

        .btn-primary:hover,
        .btn-secondary:hover {
            transform: scale(1.05);
        }

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
            background-color: #111;
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

        .movies-section {
            padding: 80px 5%;
            background-color: var(--color-gris-oscuro);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .movies-container {
            width: 100%;
            max-width: 1300px;
            margin-bottom: 60px;
        }

        .row-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 30px;
            border-bottom: 1px solid var(--color-gris-claro);
            padding-bottom: 15px;
        }

        .row-title {
            font-size: 30px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: -1px;
            color: var(--color-blanco);
            border-left: 5px solid var(--color-amarillo);
            padding-left: 15px;
            line-height: 1;
        }

        .movies-grid-full {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 20px;
            width: 100%;
        }

        .movie-card {
            position: relative;
            border-radius: 6px;
            overflow: hidden;
            background-color: var(--color-negro);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .movie-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.9);
            z-index: 2;
        }

        .movie-card img {
            width: 100%;
            aspect-ratio: 2 / 3;
            object-fit: cover;
            display: block;
            background-color: #111;
            cursor: pointer;
        }

        .date-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: var(--color-amarillo);
            color: var(--color-negro);
            font-size: 11px;
            font-weight: 900;
            padding: 4px 8px;
            border-radius: 4px;
            text-transform: uppercase;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
            z-index: 5;
        }

        .movie-card-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.95) 0%, rgba(0, 0, 0, 0.4) 60%, transparent 100%);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            padding: 20px;
            text-align: center;
            z-index: 4;
            pointer-events: none;
        }

        .movie-card:hover .movie-card-overlay {
            opacity: 1;
            pointer-events: auto;
        }

        .movie-card-title {
            font-size: 18px;
            margin-bottom: 5px;
            color: var(--color-blanco);
            line-height: 1.1;
            cursor: pointer;
        }

        .movie-card-genre {
            font-size: 11px;
            color: var(--color-amarillo);
            font-family: Arial, sans-serif;
            margin-bottom: 15px;
        }

        .btn-card {
            background: var(--color-amarillo);
            color: var(--color-negro);
            padding: 10px;
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            letter-spacing: 1px;
            transition: background 0.2s;
            width: 100%;
        }

        .btn-outline {
            background: transparent;
            color: var(--color-blanco);
            border: 2px solid var(--color-blanco);
            margin-top: 5px;
        }

        .btn-card:hover {
            background: #ffffff;
            color: black;
            border-color: transparent;
        }

        .food-section {
            padding: 80px 5%;
            background-color: var(--color-negro);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .food-container {
            width: 100%;
            max-width: 1200px;
        }

        .food-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .food-header h2 {
            font-size: 40px;
            color: var(--color-blanco);
            text-transform: uppercase;
            letter-spacing: -1px;
            margin-bottom: 10px;
        }

        .food-header h2 span {
            color: var(--color-amarillo);
        }

        .food-header p {
            font-family: Arial, sans-serif;
            color: #888888;
            font-size: 16px;
        }

        .food-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .food-card {
            background-color: var(--color-gris-tarjeta);
            border-top: 4px solid var(--color-amarillo);
            padding: 40px 30px;
            border-radius: 6px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .food-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(255, 208, 0, 0.1);
        }

        .food-card-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 30px;
        }

        .food-icon {
            font-size: 35px;
        }

        .food-card h3 {
            color: var(--color-blanco);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 20px;
        }

        .food-card ul {
            list-style: none;
        }

        .food-card li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            font-family: Arial, sans-serif;
            font-size: 14px;
            border-bottom: 1px solid #222;
            padding-bottom: 10px;
            color: #cccccc;
        }

        .item-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .price-tag {
            background-color: var(--color-amarillo);
            color: var(--color-negro);
            font-weight: bold;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
        }

        .qty-selector {
            display: flex;
            align-items: center;
            background: #000;
            border: 1px solid var(--color-amarillo);
            border-radius: 4px;
            overflow: hidden;
        }

        .qty-btn {
            background: transparent;
            color: var(--color-amarillo);
            border: none;
            padding: 2px 10px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s, color 0.2s;
        }

        .qty-btn:hover {
            background: var(--color-amarillo);
            color: var(--color-negro);
        }

        .qty-number {
            color: var(--color-blanco);
            font-size: 13px;
            font-weight: bold;
            min-width: 20px;
            text-align: center;
        }

        footer {
            background-color: var(--color-negro);
            padding: 60px 5% 40px;
            border-top: 1px solid var(--color-gris-claro);
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 40px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-col {
            flex: 1;
            min-width: 200px;
        }

        .footer-logo img {
            height: 45px;
            margin-bottom: 20px;
        }

        .footer-col p {
            font-family: Arial, sans-serif;
            color: #888;
            font-size: 13px;
            line-height: 1.6;
        }

        .footer-col h4 {
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 20px;
            color: var(--color-amarillo);
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: var(--color-blanco);
            text-decoration: none;
            font-family: Arial, sans-serif;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: var(--color-amarillo);
        }

        .footer-bottom {
            max-width: 1200px;
            margin: 40px auto 0;
            padding-top: 20px;
            border-top: 1px solid var(--color-gris-claro);
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #666;
        }

        .cart-floating {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background-color: var(--color-amarillo);
            color: var(--color-negro);
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
            cursor: pointer;
            z-index: 9999;
            transition: transform 0.3s ease;
        }

        .cart-floating:hover {
            transform: scale(1.1);
        }

        .cart-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: red;
            color: white;
            font-size: 12px;
            font-weight: bold;
            font-family: Arial, sans-serif;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>

<body>

    <main class="hero" id="main-hero">
        <img src="{{ asset('img/1-Kill-Bill/Portada.png') }}" alt="Fondo Pantalla" class="hero-bg" id="hero-bg">

        <header id="main-header">
            <div class="logo"><img src="{{ asset('img/img/Logo-Negro.png') }}" alt="Cine Logo" id="main-logo"></div>
            <nav>
                <ul>
                    <li><a href="/">HOME</a></li>
                    <li><a href="#cartelera">FILMS</a></li>
                    <li><a href="#bar">MENUS</a></li>

                    @auth
                    <div class="user-nav">
                        <li>
                            <a href="#" class="user-name" title="Mi Perfil">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                {{ strtoupper(Auth::user()->name) }}
                            </a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                @csrf
                                <button type="submit" class="logout-btn" title="Cerrar Sesión">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                        <polyline points="16 17 21 12 16 7"></polyline>
                                        <line x1="21" y1="12" x2="9" y2="12"></line>
                                    </svg>
                                </button>
                            </form>
                        </li>
                    </div>
                    @else
                    <div class="user-nav">
                        <li>
                            <a href="{{ route('login') }}" title="Iniciar Sesión">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                                    <polyline points="10 17 15 12 10 7"></polyline>
                                    <line x1="15" y1="12" x2="3" y2="12"></line>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('register') }}" title="Crear Cuenta">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <line x1="19" y1="8" x2="19" y2="14"></line>
                                    <line x1="22" y1="11" x2="16" y2="11"></line>
                                </svg>
                            </a>
                        </li>
                    </div>
                    @endauth
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
                        <p class="genre" id="movie-genre">Genre: Action, Suspense</p>
                    </div>
                </div>
                <div class="hero-buttons">
                    <button class="btn-primary" id="btn-buy" onclick="addToCartMovie('Kill Bill Ticket', 8.50)">
                        <img src="{{ asset('img/img/Ticket-amarillo.png') }}" id="ticket-icon"> BUY TICKETS
                    </button>
                    <button class="btn-secondary" id="btn-view-film">VIEW FILM</button>
                </div>
            </div>
            <div class="hero-slider-section">
                <div class="custom-slider" id="slider-track"></div>
                <div class="hero-navigation">
                    <button class="nav-btn" id="btn-prev">❮</button>
                    <button class="nav-btn" id="btn-next">❯</button>
                </div>
            </div>
        </div>
    </main>

    <section class="movies-section" id="cartelera">
        <div class="movies-container">
            <div class="row-header">
                <h2 class="row-title">Now Playing</h2>
            </div>
            <div class="movies-grid-full" id="now-playing-grid"></div>
        </div>

        <div class="movies-container" style="margin-top: 40px;">
            <div class="row-header">
                <h2 class="row-title">Coming Soon</h2>
            </div>
            <div class="movies-grid-full" id="coming-soon-grid"></div>
        </div>
    </section>

    <section class="food-section" id="bar">
        <div class="food-container">
            <div class="food-header">
                <h2>Screenbites <span>Menu</span></h2>
                <p>Order your favorite cinema snacks and skip the line.</p>
            </div>
            <div class="food-grid">

                <div class="food-card">
                    <div class="food-card-header"><span class="food-icon">🍿</span>
                        <h3>Popcorn & Combos</h3>
                    </div>
                    <ul>
                        <li>Classic Salted (S)
                            <div class="item-actions"><span class="price-tag">$4.50</span>
                                <div class="qty-selector"><button class="qty-btn"
                                        onclick="updateQty('pop-s', 4.50, -1)">-</button>
                                    <div class="qty-number" id="qty-pop-s">0</div><button class="qty-btn"
                                        onclick="updateQty('pop-s', 4.50, 1)">+</button>
                                </div>
                            </div>
                        </li>
                        <li>Classic Salted (M)
                            <div class="item-actions"><span class="price-tag">$5.50</span>
                                <div class="qty-selector"><button class="qty-btn"
                                        onclick="updateQty('pop-m', 5.50, -1)">-</button>
                                    <div class="qty-number" id="qty-pop-m">0</div><button class="qty-btn"
                                        onclick="updateQty('pop-m', 5.50, 1)">+</button>
                                </div>
                            </div>
                        </li>
                        <li>Classic Salted (L)
                            <div class="item-actions"><span class="price-tag">$7.00</span>
                                <div class="qty-selector"><button class="qty-btn"
                                        onclick="updateQty('pop-l', 7.00, -1)">-</button>
                                    <div class="qty-number" id="qty-pop-l">0</div><button class="qty-btn"
                                        onclick="updateQty('pop-l', 7.00, 1)">+</button>
                                </div>
                            </div>
                        </li>
                        <li>Extra Butter (L)
                            <div class="item-actions"><span class="price-tag">$8.00</span>
                                <div class="qty-selector"><button class="qty-btn"
                                        onclick="updateQty('pop-butter', 8.00, -1)">-</button>
                                    <div class="qty-number" id="qty-pop-butter">0</div><button class="qty-btn"
                                        onclick="updateQty('pop-butter', 8.00, 1)">+</button>
                                </div>
                            </div>
                        </li>
                        <li>Caramel Crunch (M)
                            <div class="item-actions"><span class="price-tag">$6.50</span>
                                <div class="qty-selector"><button class="qty-btn"
                                        onclick="updateQty('pop-caramel', 6.50, -1)">-</button>
                                    <div class="qty-number" id="qty-pop-caramel">0</div><button class="qty-btn"
                                        onclick="updateQty('pop-caramel', 6.50, 1)">+</button>
                                </div>
                            </div>
                        </li>
                        <li>Mixed (Sweet/Salty)
                            <div class="item-actions"><span class="price-tag">$6.50</span>
                                <div class="qty-selector"><button class="qty-btn"
                                        onclick="updateQty('pop-mixed', 6.50, -1)">-</button>
                                    <div class="qty-number" id="qty-pop-mixed">0</div><button class="qty-btn"
                                        onclick="updateQty('pop-mixed', 6.50, 1)">+</button>
                                </div>
                            </div>
                        </li>
                        <li>Truffle (Premium)
                            <div class="item-actions"><span class="price-tag">$8.50</span>
                                <div class="qty-selector"><button class="qty-btn"
                                        onclick="updateQty('pop-truffle', 8.50, -1)">-</button>
                                    <div class="qty-number" id="qty-pop-truffle">0</div><button class="qty-btn"
                                        onclick="updateQty('pop-truffle', 8.50, 1)">+</button>
                                </div>
                            </div>
                        </li>
                        <li>Mega Bucket
                            <div class="item-actions"><span class="price-tag">$9.50</span>
                                <div class="qty-selector"><button class="qty-btn"
                                        onclick="updateQty('pop-mega', 9.50, -1)">-</button>
                                    <div class="qty-number" id="qty-pop-mega">0</div><button class="qty-btn"
                                        onclick="updateQty('pop-mega', 9.50, 1)">+</button>
                                </div>
                            </div>
                        </li>
                        <li
                            style="margin-top: 20px; border-top: 1px dashed var(--color-amarillo); padding-top: 15px; color: var(--color-amarillo);">
                            <strong>★ Combo 1: Popcorn L + 2 Sodas</strong>
                            <div class="item-actions"><span class="price-tag" style="background:#fff;">$14.00</span>
                                <div class="qty-selector"><button class="qty-btn"
                                        onclick="updateQty('combo-1', 14.00, -1)">-</button>
                                    <div class="qty-number" id="qty-combo-1">0</div><button class="qty-btn"
                                        onclick="updateQty('combo-1', 14.00, 1)">+</button>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="food-card">
                    <div class="food-card-header"><span class="food-icon">🥤</span>
                        <h3>Drinks & Slushies</h3>
                    </div>
                    <ul>
                        <li>Coca-Cola / Zero (M)
                            <div class="item-actions"><span class="price-tag">$4.00</span>
                                <div class="qty-selector"><button class="qty-btn"
                                        onclick="updateQty('drink-coca-m', 4.00, -1)">-</button>
                                    <div class="qty-number" id="qty-drink-coca-m">0</div><button class="qty-btn"
                                        onclick="updateQty('drink-coca-m', 4.00, 1)">+</button>
                                </div>
                            </div>
                        </li>
                        <li>Coca-Cola / Zero (L)
                            <div class="item-actions"><span class="price-tag">$5.50</span>
                                <div class="qty-selector"><button class="qty-btn"
                                        onclick="updateQty('drink-coca-l', 5.50, -1)">-</button>
                                    <div class="qty-number" id="qty-drink-coca-l">0</div><button class="qty-btn"
                                        onclick="updateQty('drink-coca-l', 5.50, 1)">+</button>
                                </div>
                            </div>
                        </li>
                        <li>Fanta Orange (M)
                            <div class="item-actions"><span class="price-tag">$4.00</span>
                                <div class="qty-selector"><button class="qty-btn"
                                        onclick="updateQty('drink-fanta', 4.00, -1)">-</button>
                                    <div class="qty-number" id="qty-drink-fanta">0</div><button class="qty-btn"
                                        onclick="updateQty('drink-fanta', 4.00, 1)">+</button>
                                </div>
                            </div>
                        </li>
                        <li>Sprite (L)
                            <div class="item-actions"><span class="price-tag">$5.50</span>
                                <div class="qty-selector"><button class="qty-btn"
                                        onclick="updateQty('drink-sprite', 5.50, -1)">-</button>
                                    <div class="qty-number" id="qty-drink-sprite">0</div><button class="qty-btn"
                                        onclick="updateQty('drink-sprite', 5.50, 1)">+</button>
                                </div>
                            </div>
                        </li>
                        <li>Icee Slush (Blue)
                            <div class="item-actions"><span class="price-tag">$5.00</span>
                                <div class="qty-selector"><button class="qty-btn"
                                        onclick="updateQty('drink-icee-blue', 5.00, -1)">-</button>
                                    <div class="qty-number" id="qty-drink-icee-blue">0</div><button class="qty-btn"
                                        onclick="updateQty('drink-icee-blue', 5.00, 1)">+</button>
                                </div>
                            </div>
                        </li>
                        <li>Icee Slush (Cherry)
                            <div class="item-actions"><span class="price-tag">$5.00</span>
                                <div class="qty-selector"><button class="qty-btn"
                                        onclick="updateQty('drink-icee-red', 5.00, -1)">-</button>
                                    <div class="qty-number" id="qty-drink-icee-red">0</div><button class="qty-btn"
                                        onclick="updateQty('drink-icee-red', 5.00, 1)">+</button>
                                </div>
                            </div>
                        </li>
                        <li>Bottled Water
                            <div class="item-actions"><span class="price-tag">$3.00</span>
                                <div class="qty-selector"><button class="qty-btn"
                                        onclick="updateQty('drink-water', 3.00, -1)">-</button>
                                    <div class="qty-number" id="qty-drink-water">0</div><button class="qty-btn"
                                        onclick="updateQty('drink-water', 3.00, 1)">+</button>
                                </div>
                            </div>
                        </li>
                        <li>Craft Beer (IPA)
                            <div class="item-actions"><span class="price-tag">$6.50</span>
                                <div class="qty-selector"><button class="qty-btn"
                                        onclick="updateQty('drink-beer', 6.50, -1)">-</button>
                                    <div class="qty-number" id="qty-drink-beer">0</div><button class="qty-btn"
                                        onclick="updateQty('drink-beer', 6.50, 1)">+</button>
                                </div>
                            </div>
                        </li>
                        <li>Hot Coffee
                            <div class="item-actions"><span class="price-tag">$3.50</span>
                                <div class="qty-selector"><button class="qty-btn"
                                        onclick="updateQty('drink-coffee', 3.50, -1)">-</button>
                                    <div class="qty-number" id="qty-drink-coffee">0</div><button class="qty-btn"
                                        onclick="updateQty('drink-coffee', 3.50, 1)">+</button>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="food-card">
                    <div class="food-card-header"><span class="food-icon">🌭</span>
                        <h3>Hot Snacks & Candies</h3>
                    </div>
                    <ul>
                        <li>Classic Hot Dog
                            <div class="item-actions"><span class="price-tag">$5.00</span>
                                <div class="qty-selector"><button class="qty-btn"
                                        onclick="updateQty('snack-hotdog', 5.00, -1)">-</button>
                                    <div class="qty-number" id="qty-snack-hotdog">0</div><button class="qty-btn"
                                        onclick="updateQty('snack-hotdog', 5.00, 1)">+</button>
                                </div>
                            </div>
                        </li>
                        <li>XXL Cheese Hot Dog
                            <div class="item-actions"><span class="price-tag">$6.50</span>
                                <div class="qty-selector"><button class="qty-btn"
                                        onclick="updateQty('snack-hotdog-xxl', 6.50, -1)">-</button>
                                    <div class="qty-number" id="qty-snack-hotdog-xxl">0</div><button class="qty-btn"
                                        onclick="updateQty('snack-hotdog-xxl', 6.50, 1)">+</button>
                                </div>
                            </div>
                        </li>
                        <li>Cheesy Nachos
                            <div class="item-actions"><span class="price-tag">$6.50</span>
                                <div class="qty-selector"><button class="qty-btn"
                                        onclick="updateQty('snack-nachos', 6.50, -1)">-</button>
                                    <div class="qty-number" id="qty-snack-nachos">0</div><button class="qty-btn"
                                        onclick="updateQty('snack-nachos', 6.50, 1)">+</button>
                                </div>
                            </div>
                        </li>
                        <li>Pretzel Bites
                            <div class="item-actions"><span class="price-tag">$4.50</span>
                                <div class="qty-selector"><button class="qty-btn"
                                        onclick="updateQty('snack-pretzel', 4.50, -1)">-</button>
                                    <div class="qty-number" id="qty-snack-pretzel">0</div><button class="qty-btn"
                                        onclick="updateQty('snack-pretzel', 4.50, 1)">+</button>
                                </div>
                            </div>
                        </li>
                        <li>Pizza Slice
                            <div class="item-actions"><span class="price-tag">$4.00</span>
                                <div class="qty-selector"><button class="qty-btn"
                                        onclick="updateQty('snack-pizza', 4.00, -1)">-</button>
                                    <div class="qty-number" id="qty-snack-pizza">0</div><button class="qty-btn"
                                        onclick="updateQty('snack-pizza', 4.00, 1)">+</button>
                                </div>
                            </div>
                        </li>
                        <li>M&M's
                            <div class="item-actions"><span class="price-tag">$3.50</span>
                                <div class="qty-selector"><button class="qty-btn"
                                        onclick="updateQty('candy-mms', 3.50, -1)">-</button>
                                    <div class="qty-number" id="qty-candy-mms">0</div><button class="qty-btn"
                                        onclick="updateQty('candy-mms', 3.50, 1)">+</button>
                                </div>
                            </div>
                        </li>
                        <li>Skittles
                            <div class="item-actions"><span class="price-tag">$3.50</span>
                                <div class="qty-selector"><button class="qty-btn"
                                        onclick="updateQty('candy-skittles', 3.50, -1)">-</button>
                                    <div class="qty-number" id="qty-candy-skittles">0</div><button class="qty-btn"
                                        onclick="updateQty('candy-skittles', 3.50, 1)">+</button>
                                </div>
                            </div>
                        </li>
                        <li>Gummy Bears
                            <div class="item-actions"><span class="price-tag">$3.00</span>
                                <div class="qty-selector"><button class="qty-btn"
                                        onclick="updateQty('candy-gummy', 3.00, -1)">-</button>
                                    <div class="qty-number" id="qty-candy-gummy">0</div><button class="qty-btn"
                                        onclick="updateQty('candy-gummy', 3.00, 1)">+</button>
                                </div>
                            </div>
                        </li>
                        <li>Maltesers
                            <div class="item-actions"><span class="price-tag">$3.50</span>
                                <div class="qty-selector"><button class="qty-btn"
                                        onclick="updateQty('candy-malts', 3.50, -1)">-</button>
                                    <div class="qty-number" id="qty-candy-malts">0</div><button class="qty-btn"
                                        onclick="updateQty('candy-malts', 3.50, 1)">+</button>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    @auth
    <div class="cart-floating" onclick="alert('Ir a la página del checkout!')">
        🛒
        <div class="cart-badge" id="cart-counter">0</div>
    </div>
    @endauth

    <footer>
        <div class="footer-content">
            <div class="footer-col">
                <div class="footer-logo"><img src="{{ asset('img/img/Logo-Blanco.png') }}" alt="Cine Screenbites"></div>
                <p>Experience cinema like never before. Grab your popcorn, find your seat, and let the magic begin.</p>
            </div>
            <div class="footer-col">
                <h4>Explore</h4>
                <ul class="footer-links">
                    <li><a href="#cartelera">Now Playing</a></li>
                    <li><a href="#cartelera">Coming Soon</a></li>
                    <li><a href="#bar">Food & Drinks</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Legal</h4>
                <ul class="footer-links">
                    <li><a href="#">Terms & Conditions</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Follow Us</h4>
                <ul class="footer-links">
                    <li><a href="#">Instagram</a></li>
                    <li><a href="#">Twitter / X</a></li>
                    <li><a href="#">TikTok</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 Cine Screenbites. All rights reserved.</p>
        </div>
    </footer>

    <script>
        const movies = [
            { id: "01", title: "Kill Bill", age: "+18", rating: 4, genre: "Action, Suspense", bg: "#ffd000", textColor: "black", bgImg: "{{ asset('img/1-Kill-Bill/Portada.png') }}", poster: "{{ asset('img/1-Kill-Bill/Mini.png') }}" },
            { id: "02", title: "Five Nights", age: "+16", rating: 3, genre: "Horror, Thriller", bg: "#1a0429", textColor: "white", bgImg: "{{ asset('img/2-Five-Nights/Portada.png') }}", poster: "{{ asset('img/2-Five-Nights/Mini.png') }}" },
            { id: "03", title: "Godzilla", age: "+12", rating: 4, genre: "Action, Sci-Fi", bg: "#0a2233", textColor: "white", bgImg: "{{ asset('img/3-Godzilla/Portada.png') }}", poster: "{{ asset('img/3-Godzilla/Mini.png') }}" },
            { id: "04", title: "Oppenheimer", age: "+16", rating: 5, genre: "Biography, History", bg: "#2e1409", textColor: "white", bgImg: "{{ asset('img/4-Oppenheimer/Portada.png') }}", poster: "{{ asset('img/4-Oppenheimer/Mini.png') }}" },
            { id: "05", title: "Up", age: "TP", rating: 5, genre: "Animation, Adventure", bg: "#a1cce0", textColor: "black", bgImg: "{{ asset('img/5-Up/Portada.png') }}", poster: "{{ asset('img/5-Up/Mini.png') }}" },
            { id: "06", title: "The Joker", age: "+18", rating: 5, genre: "Crime, Drama", bg: "#120908", textColor: "white", bgImg: "{{ asset('img/6-The-Joker/Portada.png') }}", poster: "{{ asset('img/6-The-Joker/Mini.png') }}" },
            { id: "07", title: "Alien", age: "+18", rating: 4, genre: "Horror, Sci-Fi", bg: "#051417", textColor: "white", bgImg: "{{ asset('img/7-Alien/Portada.png') }}", poster: "{{ asset('img/7-Alien/Mini.png') }}" },
            { id: "08", title: "Interstellar", age: "+12", rating: 5, genre: "Adventure, Sci-Fi", bg: "#090a0a", textColor: "white", bgImg: "{{ asset('img/8-Interstellar/Portada.png') }}", poster: "{{ asset('img/8-Interstellar/Mini.png') }}" },
            { id: "09", title: "Barbie", age: "TP", rating: 4, genre: "Comedy, Fantasy", bg: "#51caf5", textColor: "white", bgImg: "{{ asset('img/9-Barbie/Portada.png') }}", poster: "{{ asset('img/9-Barbie/Mini.png') }}" },
            { id: "10", title: "Mamma Mia", age: "TP", rating: 5, genre: "Comedy, Musical", bg: "#444444", textColor: "black", bgImg: "{{ asset('img/10-MammaMia/Portada.jpg') }}", poster: "{{ asset('img/10-MammaMia/Mini.jpg') }}" }
        ];

        const comingSoonMovies = [
            { id: "11", title: "Deadpool & Wolverine", date: "25 JULY", genre: "Action, Comedy", poster: "{{ asset('img/11-Deadpool/Mini.jpg') }}" },
            { id: "12", title: "Gladiator II", date: "15 NOVEMBER", genre: "Action, Drama", poster: "{{ asset('img/12-Gladiator/Mini.jpg') }}" },
            { id: "13", title: "Venom 3", date: "24 OCTOBER", genre: "Sci-Fi, Action", poster: "{{ asset('img/13-Venom/Mini.png') }}" },
            { id: "14", title: "Mufasa", date: "13 DECEMBER", genre: "Adventure, Family", poster: "{{ asset('img/14-Mufasa/Mini.jpg') }}" },
            { id: "15", title: "Kraven", date: "20 DECEMBER", genre: "Action, Thriller", poster: "{{ asset('img/15-Kraven/Mini.png') }}" }
        ];

        let currentIndex = 0;
        const totalMovies = movies.length;
        let autoPlayTimer;
        const AUTO_PLAY_DELAY = 6000;

        const sliderTrack = document.getElementById('slider-track');
        const mainHero = document.getElementById('main-hero');
        const heroBg = document.getElementById('hero-bg');
        const nowPlayingGrid = document.getElementById('now-playing-grid');
        const comingSoonGrid = document.getElementById('coming-soon-grid');
        const headerEl = document.getElementById('main-header');
        const logoEl = document.getElementById('main-logo');

        window.addEventListener('scroll', () => {
            const activeMovie = movies[currentIndex];
            if (window.scrollY >= window.innerHeight - 100) {
                headerEl.classList.add('scrolled');
                logoEl.src = "{{ asset('img/img/Logo-Blanco.png') }}";
                headerEl.style.setProperty('--header-text-color', 'white');
            } else {
                headerEl.classList.remove('scrolled');
                logoEl.src = activeMovie.textColor === "white" ? "{{ asset('img/img/Logo-Blanco.png') }}" : "{{ asset('img/img/Logo-Negro.png') }}";
                headerEl.style.setProperty('--header-text-color', activeMovie.textColor);
            }
        });

        // INYECTAR "NOW PLAYING" 
        movies.forEach((movie, index) => {
            const slideDiv = document.createElement('div');
            slideDiv.classList.add('slide-item');
            slideDiv.innerHTML = `<img src="${movie.poster}" alt="${movie.title}" class="poster-img"><div class="progress-track"><div class="progress-fill"></div></div>`;
            slideDiv.addEventListener('click', () => {
                if (slideDiv.classList.contains('prev')) moveSlider(-1);
                if (slideDiv.classList.contains('next')) moveSlider(1);
            });
            sliderTrack.appendChild(slideDiv);

            const npCard = document.createElement('div');
            npCard.classList.add('movie-card');
            npCard.innerHTML = `
                <img src="${movie.poster}" alt="${movie.title}" onclick="window.location.href='/pelicula/${movie.id}'">
                <div class="movie-card-overlay">
                    <h4 class="movie-card-title" onclick="window.location.href='/pelicula/${movie.id}'">${movie.title}</h4>
                    <p class="movie-card-genre">${movie.genre}</p>
                    <button class="btn-card" onclick="addToCartMovie('Entrada: ${movie.title}', 8.50)">Buy Tickets</button>
                    <button class="btn-card btn-outline" style="margin-top:8px;" onclick="window.location.href='/pelicula/${movie.id}'">Ver Info</button>
                </div>
            `;
            nowPlayingGrid.appendChild(npCard);
        });

        // INYECTAR "COMING SOON"
        comingSoonMovies.forEach((movie) => {
            const csCard = document.createElement('div');
            csCard.classList.add('movie-card');
            csCard.innerHTML = `
                <div class="date-badge">${movie.date}</div>
                <img src="${movie.poster}" alt="${movie.title}" onclick="window.location.href='/pelicula/${movie.id}'">
                <div class="movie-card-overlay">
                    <h4 class="movie-card-title" onclick="window.location.href='/pelicula/${movie.id}'">${movie.title}</h4>
                    <p class="movie-card-genre">${movie.genre}</p>
                    <button class="btn-card btn-outline" onclick="window.location.href='/pelicula/${movie.id}'">Ver Info</button>
                </div>
            `;
            comingSoonGrid.appendChild(csCard);
        });

        const slides = document.querySelectorAll('.slide-item');

        function updateCarousel() {
            slides.forEach((slide, index) => {
                slide.className = 'slide-item';
                let diff = (index - currentIndex + totalMovies) % totalMovies;
                if (diff === 0) slide.classList.add('active');
                else if (diff === 1) slide.classList.add('next');
                else if (diff === totalMovies - 1) slide.classList.add('prev');
                else if (diff > 1 && diff <= totalMovies / 2) slide.classList.add('hidden-right');
                else slide.classList.add('hidden-left');
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

            const isBlackStar = activeMovie.id === "01";
            const starFilled = isBlackStar ? "{{ asset('img/img/Estrella-Negra.svg') }}" : "{{ asset('img/img/Estrella-Amarilla.svg') }}";
            const starEmpty = isBlackStar ? "{{ asset('img/img/Estrella-Negra-Vacia.svg') }}" : "{{ asset('img/img/Estrella-Amarilla-Vacia.svg') }}";

            let starsHTML = '';
            for (let i = 0; i < 5; i++) {
                if (i < activeMovie.rating) starsHTML += `<img src="${starFilled}" alt="Star" class="star-icon">`;
                else starsHTML += `<img src="${starEmpty}" alt="Empty Star" class="star-icon">`;
            }
            document.getElementById('movie-stars').innerHTML = starsHTML;

            const color = activeMovie.textColor;
            mainHero.style.color = color;
            document.getElementById('movie-id').style.webkitTextStroke = `2px ${color}`;

            // LÓGICA DE BOTONES DEL HERO
            const btnBuyHero = document.getElementById('btn-buy');
            btnBuyHero.setAttribute('onclick', `addToCartMovie('Entrada VIP: ${activeMovie.title}', 12.00)`);

            // NUEVO BOTÓN VIEW FILM DEL HERO 
            const btnViewHero = document.getElementById('btn-view-film');
            btnViewHero.onclick = function () {
                window.location.href = '/pelicula/' + activeMovie.id;
            };

            if (!headerEl.classList.contains('scrolled')) {
                headerEl.style.setProperty('--header-text-color', color);
                logoEl.src = color === "white" ? "{{ asset('img/img/Logo-Blanco.png') }}" : "{{ asset('img/img/Logo-Negro.png') }}";
            }

            if (color === 'white') {
                btnBuyHero.style.background = '#ffffff';
                btnBuyHero.style.color = '#000000';
            } else {
                btnBuyHero.style.background = '#000000';
                btnBuyHero.style.color = activeMovie.bg;
            }
        }

        function moveSlider(direction) {
            currentIndex = (currentIndex + direction + totalMovies) % totalMovies;
            updateCarousel();
            resetAutoPlay();
        }

        function resetAutoPlay() {
            clearInterval(autoPlayTimer);
            autoPlayTimer = setInterval(() => { moveSlider(1); }, AUTO_PLAY_DELAY);
        }

        document.getElementById('btn-prev').addEventListener('click', () => moveSlider(-1));
        document.getElementById('btn-next').addEventListener('click', () => moveSlider(1));

        updateCarousel();
        resetAutoPlay();

        // LÓGICA DE CARRITO
        let cartTotalItems = 0;
        let cartItems = {};

        function updateQty(itemId, price, change) {
            const counterElement = document.getElementById('cart-counter');
            if (!counterElement) {
                alert("Debes iniciar sesión para comprar entradas o comida.");
                window.location.href = "/login";
                return;
            }
            if (!cartItems[itemId]) { cartItems[itemId] = 0; }

            let oldQty = cartItems[itemId];
            let newQty = oldQty + change;
            if (newQty < 0) newQty = 0;
            let diff = newQty - oldQty;

            if (diff !== 0) {
                cartItems[itemId] = newQty;
                cartTotalItems += diff;
                document.getElementById('qty-' + itemId).textContent = newQty;
                counterElement.textContent = cartTotalItems;

                if (change > 0) {
                    const cartBtn = document.querySelector('.cart-floating');
                    cartBtn.style.transform = 'scale(1.3)';
                    setTimeout(() => cartBtn.style.transform = 'scale(1)', 200);
                }
            }
        }

        function addToCartMovie(itemName, price) {
            const counterElement = document.getElementById('cart-counter');
            if (counterElement) {
                cartTotalItems++;
                counterElement.textContent = cartTotalItems;
                const cartBtn = document.querySelector('.cart-floating');
                cartBtn.style.transform = 'scale(1.3)';
                setTimeout(() => cartBtn.style.transform = 'scale(1)', 200);
            } else {
                alert("Debes iniciar sesión para comprar entradas o comida.");
                window.location.href = "/login";
            }
        }
    </script>
</body>

</html>