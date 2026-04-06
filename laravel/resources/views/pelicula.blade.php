<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Screenbites Cinema - {{ $movie['title'] ?? 'Movie' }}</title>

    <style>
        :root {
            --color-negro: #000000;
            --color-gris-oscuro: #0a0a0a;
            --color-gris-tarjeta: #141414;
            --color-gris-claro: #333333;
            --color-blanco: #ffffff;
            
            /* COLOR DINÁMICO BASADO EN LA PELÍCULA (Cae a amarillo si no existe) */
            --color-principal: {{ $movie['bg'] ?? '#ffd000' }}; 
            /* COLOR TEXTO BOTON DINÁMICO */
            --color-texto-btn: {{ $movie['textColor'] ?? 'black' }};
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Arial Black', 'Arial Bold', sans-serif;
            overflow-x: hidden;
            background-color: var(--color-negro);
            color: var(--color-blanco);
            width: 100%;
        }

        /* --- HEADER --- */
        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 5% 0 3%;
            height: 100px;
            z-index: 1000;
            background-color: transparent;
            border-bottom: 1px solid transparent;
            transition: background-color 0.3s ease, box-shadow 0.3s ease, border-bottom 0.3s ease;

            &.scrolled {
                background-color: rgba(0, 0, 0, 0.95);
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.8);
                border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            }

            .logo img {
                height: 60px;
            }

            nav {
                ul {
                    list-style: none;
                    display: flex;
                    align-items: center;
                    gap: 30px;
                }

                a,
                .logout-btn {
                    text-decoration: none;
                    color: var(--header-text-color, var(--color-blanco));
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

                    &:hover {
                        color: var(--color-principal) !important;
                        transform: scale(1.05);
                    }
                }
            }
        }

        /* --- USER NAVIGATION --- */
        .user-nav {
            display: flex;
            align-items: center;
            gap: 20px;
            border-left: 2px solid rgba(255, 255, 255, 0.2);
            padding-left: 20px;
            margin-left: 10px;

            .user-profile {
                display: flex;
                align-items: center;
                gap: 10px;
                color: var(--header-text-color, var(--color-blanco));
                transition: color 0.3s ease;

                .user-avatar {
                    width: 35px;
                    height: 35px;
                    border-radius: 50%;
                    object-fit: cover;
                    border: none;
                    transition: transform 0.3s ease;
                }

                .user-name,
                .chevron-icon {
                    color: var(--header-text-color, var(--color-blanco));
                    transition: color 0.3s ease;
                }

                .chevron-icon {
                    width: 16px;
                    height: 16px;
                }

                &:hover {
                    .user-avatar {
                        transform: scale(1.1);
                    }
                    .user-name,
                    .chevron-icon {
                        color: var(--color-principal);
                    }
                }
            }

            .nav-cart {
                position: relative;
                background: none;
                border: none;
                cursor: pointer;
                display: flex;
                align-items: center;
                padding: 5px;
                color: var(--header-text-color, var(--color-blanco));
                transition: color 0.3s ease, transform 0.2s ease;

                svg {
                    width: 26px;
                    height: 26px;
                }

                .cart-badge {
                    position: absolute;
                    top: -5px;
                    right: -8px;
                    background-color: red;
                    color: white;
                    font-size: 11px;
                    font-weight: bold;
                    font-family: Arial, sans-serif;
                    width: 18px;
                    height: 18px;
                    border-radius: 50%;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
                    pointer-events: none;
                }

                &:hover {
                    color: var(--color-principal) !important;
                    transform: scale(1.1);
                }
            }
        }

        /* --- MOVIE HERO (NETFLIX STYLE) --- */
        .movie-hero {
            position: relative;
            width: 100%;
            min-height: 65vh;
            display: flex;
            align-items: center;
            padding: 120px 5% 40px;

            .backdrop-img {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                object-fit: cover;
                object-position: top;
                z-index: 1;
                opacity: 20%;
            }

            .backdrop-gradient {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: linear-gradient(to top, var(--color-negro) 0%, rgba(0, 0, 0, 0.8) 30%, transparent 100%);
                z-index: 2;
            }

            .movie-content {
                position: relative;
                z-index: 10;
                display: flex;
                gap: 50px;
                max-width: 1300px;
                margin: 0 auto;
                width: 100%;
                align-items: center;

                .movie-poster {
                    width: 280px;
                    border-radius: 8px;
                    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.9);
                    border: 2px solid var(--color-principal);
                    flex-shrink: 0;
                }

                .movie-info {
                    flex: 1;

                    .movie-id {
                        color: var(--color-principal);
                        font-size: 16px;
                        letter-spacing: 5px;
                        margin-bottom: 10px;
                        display: block;
                    }

                    .movie-title {
                        font-size: 60px;
                        margin: 0 0 15px 0;
                        text-transform: uppercase;
                        line-height: 1.1;
                        text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.8);
                    }

                    .movie-meta {
                        display: flex;
                        gap: 20px;
                        align-items: center;
                        font-family: Arial, sans-serif;
                        font-size: 14px;
                        margin-bottom: 25px;
                        color: #ddd;

                        .age-badge {
                            border: 2px solid currentColor;
                            padding: 4px 8px;
                            border-radius: 4px;
                            font-weight: bold;
                        }
                    }

                    .movie-desc {
                        font-family: Arial, sans-serif;
                        line-height: 1.6;
                        color: #ccc;
                        margin-bottom: 35px;
                        font-size: 16px;
                        max-width: 800px;
                    }

                    .action-buttons {
                        display: flex;
                        gap: 15px;
                        align-items: center;

                        .btn-buy {
                            background: var(--color-principal);
                            color: var(--color-texto-btn);
                            padding: 12px 30px;
                            font-size: 13px;
                            font-weight: 900;
                            text-transform: uppercase;
                            border: none;
                            border-radius: 4px;
                            cursor: pointer;
                            letter-spacing: 1px;
                            transition: all 0.3s ease;
                            display: inline-flex;
                            align-items: center;
                            gap: 10px;

                            img {
                                width: 18px;
                                filter: {{ ($movie['textColor'] ?? 'black') === 'white' ? 'invert(0)' : 'invert(1)' }}; 
                            }

                            &:hover:not(:disabled) {
                                background: var(--color-blanco);
                                color: var(--color-negro);
                                transform: scale(1.05);
                                
                                img {
                                    filter: invert(1);
                                }
                            }
                            
                            &:disabled {
                                opacity: 0.5;
                                cursor: not-allowed;
                                background-color: var(--color-principal);
                            }
                        }

                        .btn-back {
                            background: transparent;
                            color: var(--color-blanco);
                            padding: 12px 30px;
                            font-size: 13px;
                            font-weight: 900;
                            text-transform: uppercase;
                            border: 2px solid var(--color-blanco);
                            border-radius: 4px;
                            cursor: pointer;
                            letter-spacing: 1px;
                            transition: all 0.3s ease;
                            text-decoration: none;

                            &:hover {
                                background: var(--color-blanco);
                                color: var(--color-negro);
                                transform: scale(1.05);
                            }
                        }
                    }
                }
            }
        }

        /* --- TÍTULOS DE SECCIÓN --- */
        .section-title {
            font-size: 24px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: -1px;
            color: var(--color-blanco);
            border-left: 5px solid var(--color-principal);
            padding-left: 15px;
            margin-bottom: 30px;
            line-height: 1;
        }

        /* --- MEDIA CAROUSEL INFINITO --- */
        .media-carousel-section {
            padding: 20px 5% 60px;
            background-color: var(--color-negro);
            max-width: 1400px;
            margin: 0 auto;

            .carousel-container {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 20px;
                width: 100%;

                .media-nav-btn {
                    background: transparent;
                    border: none;
                    color: var(--color-blanco);
                    cursor: pointer;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    padding: 10px;
                    opacity: 0.6;
                    transition: all 0.3s ease;
                    flex-shrink: 0;

                    svg {
                        width: 36px;
                        height: 36px;
                        stroke-width: 3;
                        transition: transform 0.3s ease;
                    }

                    &:hover {
                        opacity: 1;
                        color: var(--color-principal);
                    }

                    &.prev:hover svg { transform: translateX(-5px); }
                    &.next:hover svg { transform: translateX(5px); }
                }

                .carousel-viewport {
                    flex: 1;
                    overflow: hidden; 
                    border-radius: 8px;
                }

                .carousel-track {
                    display: flex;
                    gap: 20px;
                }

                .media-item {
                    flex: 0 0 calc(33.333% - 14px); 
                    height: 300px;
                    border-radius: 8px;
                    background-color: #111;
                    border: 1px solid #222;
                    overflow: hidden;
                    position: relative;
                    cursor: pointer;
                    transition: border-color 0.3s ease;

                    &:hover {
                        border-color: var(--color-principal);
                    }

                    img, iframe {
                        width: 100%;
                        height: 100%;
                        object-fit: cover;
                        border: none;
                    }

                    .play-icon {
                        position: absolute;
                        top: 50%;
                        left: 50%;
                        transform: translate(-50%, -50%);
                        width: 60px;
                        height: 60px;
                        background: rgba(0, 0, 0, 0.6);
                        border-radius: 50%;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        color: var(--color-blanco);
                        border: 2px solid var(--color-blanco);
                        transition: all 0.3s ease;
                        pointer-events: none;

                        svg {
                            width: 24px;
                            height: 24px;
                            margin-left: 4px;
                            fill: currentColor;
                        }
                    }

                    &:hover .play-icon {
                        background: var(--color-principal);
                        border-color: var(--color-principal);
                        color: var(--color-texto-btn);
                        transform: translate(-50%, -50%) scale(1.1);
                    }
                }
            }
        }

        /* --- EXCLUSIVE MENU --- */
        .exclusive-movie-menu {
            padding: 20px 5% 80px;
            background-color: var(--color-negro);
            max-width: 1400px;
            margin: 0 auto;

            .exclusive-banner {
                background: linear-gradient(135deg, #1a1a1a 0%, #000000 100%);
                border: 1px solid #333;
                border-radius: 12px;
                padding: 40px;
                display: flex;
                align-items: center;
                gap: 40px;
                position: relative;
                overflow: hidden;

                &::before {
                    content: '';
                    position: absolute;
                    top: -50px;
                    right: -50px;
                    width: 200px;
                    height: 200px;
                    background: var(--color-principal);
                    filter: blur(120px);
                    opacity: 0.15;
                }

                .exclusive-img-container {
                    flex-shrink: 0;
                    width: 380px; 
                    height: 260px; 
                    border-radius: 8px;
                    overflow: hidden;
                    border: 2px solid var(--color-principal);
                    position: relative;
                    z-index: 2;
                    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5); 

                    img {
                        width: 100%;
                        height: 100%;
                        object-fit: cover;
                    }
                }

                .exclusive-info {
                    position: relative;
                    z-index: 2;
                    flex: 1;

                    .tag {
                        display: inline-block;
                        background-color: var(--color-principal);
                        color: var(--color-texto-btn);
                        font-size: 11px;
                        font-weight: 900;
                        padding: 4px 10px;
                        border-radius: 12px;
                        text-transform: uppercase;
                        margin-bottom: 15px;
                    }

                    h3 {
                        font-size: 32px;
                        color: var(--color-blanco);
                        text-transform: uppercase;
                        margin-bottom: 10px;
                        line-height: 1.1;
                    }

                    p {
                        font-family: Arial, sans-serif;
                        color: #aaa;
                        font-size: 15px;
                        line-height: 1.6;
                        margin-bottom: 25px;
                        max-width: 500px;
                    }

                    .btn-unlock {
                        background: transparent;
                        color: var(--color-principal);
                        padding: 12px 25px;
                        font-size: 13px;
                        font-weight: 900;
                        text-transform: uppercase;
                        border: 2px solid var(--color-principal);
                        border-radius: 4px;
                        cursor: pointer;
                        letter-spacing: 1px;
                        transition: all 0.3s ease;
                        display: inline-flex;
                        align-items: center;
                        gap: 10px;

                        svg {
                            width: 18px;
                            height: 18px;
                        }

                        &:hover {
                            background: var(--color-principal);
                            color: var(--color-texto-btn);
                            transform: scale(1.02);
                        }
                    }
                }
            }
        }

        /* --- REVIEWS SECTION --- */
        .reviews-section {
            padding: 20px 5% 80px;
            background-color: var(--color-negro);
            max-width: 1400px;
            margin: 0 auto;

            .reviews-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
                gap: 20px;

                .review-card {
                    background: #0a0a0a;
                    border: 1px solid #222;
                    border-radius: 8px;
                    padding: 25px;
                    transition: border-color 0.3s ease, transform 0.3s ease;

                    &:hover { 
                        border-color: var(--color-principal); 
                        transform: translateY(-5px);
                    }

                    .review-stars {
                        color: var(--color-principal);
                        margin-bottom: 10px;
                        font-size: 20px;
                        letter-spacing: 2px;
                    }

                    h4 {
                        font-size: 18px;
                        color: var(--color-blanco);
                        margin-bottom: 10px;
                        text-transform: uppercase;
                    }

                    p {
                        color: #aaa;
                        font-size: 14px;
                        line-height: 1.6;
                        font-family: Arial, sans-serif;
                    }
                }
            }

            .no-reviews {
                color: #666;
                font-family: Arial, sans-serif;
                font-style: italic;
                padding: 20px 0;
            }
        }

        /* --- FOOTER --- */
        footer {
            background-color: var(--color-negro);
            padding: 60px 5% 40px;
            border-top: 1px solid var(--color-gris-claro);

            .footer-content {
                display: flex;
                justify-content: space-between;
                flex-wrap: wrap;
                gap: 40px;
                max-width: 1200px;
                margin: 0 auto;

                .footer-col {
                    flex: 1;
                    min-width: 200px;

                    &:first-child {
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        text-align: center;
                        
                        .footer-logo img {
                            height: 60px;
                            margin-bottom: 20px;
                            display: block;
                        }

                        p {
                            max-width: 250px;
                        }
                    }

                    p {
                        font-family: Arial, sans-serif;
                        color: #888;
                        font-size: 13px;
                        line-height: 1.6;
                    }

                    h4 {
                        font-size: 16px;
                        text-transform: uppercase;
                        letter-spacing: 2px;
                        margin-bottom: 20px;
                        color: var(--color-principal);
                    }

                    .footer-links {
                        list-style: none;

                        li {
                            margin-bottom: 10px;

                            a {
                                color: var(--color-blanco);
                                text-decoration: none;
                                font-family: Arial, sans-serif;
                                font-size: 14px;
                                transition: color 0.3s ease;

                                &:hover {
                                    color: var(--color-principal);
                                }
                            }
                        }
                    }
                }
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

                .footer-credits {
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    color: #888;
                    font-family: Arial, sans-serif;

                    span {
                        color: var(--color-principal);
                        font-weight: bold;
                    }

                    .heart-icon {
                        width: 16px;
                        height: 16px;
                        color: #888;
                        transition: color 0.3s ease;
                    }

                    &:hover .heart-icon {
                        color: #ff4444;
                        filter: drop-shadow(0 0 3px #ff4444);
                    }
                }
            }
        }
    </style>
</head>

<body>

    <header id="main-header">
        <div class="logo">
            <a href="/"><img src="{{ asset('img/img/Logo-Blanco.png') }}" alt="Screenbites Logo"></a>
        </div>
        <nav>
            <ul>
                <li><a href="/">HOME</a></li>
                <li><a href="/#cartelera">FILMS</a></li>
                <li><a href="/#bar">MENUS</a></li>

                @auth
                <div class="user-nav">
                    <li>
                        <a href="/profile" class="user-profile" title="My Profile">
                            <img src="{{ asset('img/avatars/' . Auth::user()->avatar) }}" alt="Avatar"
                                class="user-avatar" onerror="this.src='https://via.placeholder.com/35/333/ffd000'">
                            <span class="user-name">{{ strtoupper(Auth::user()->name) }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="chevron-icon" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </a>
                    </li>

                    <li>
                        <button class="nav-cart" onclick="alert('Checkout functionality in development')">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="9" cy="21" r="1"></circle>
                                <circle cx="20" cy="21" r="1"></circle>
                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                            </svg>
                            <div class="cart-badge" id="nav-cart-counter">0</div>
                        </button>
                    </li>

                    <li>
                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="logout-btn" title="Sign Out">
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
                        <a href="{{ route('login') }}" title="Sign In">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                                <polyline points="10 17 15 12 10 7"></polyline>
                                <line x1="15" y1="12" x2="3" y2="12"></line>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('register') }}" title="Create Account">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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

    <div class="movie-hero">
        <img src="{{ $movie['bgImg'] ?? '' }}" class="backdrop-img" onerror="this.src='https://via.placeholder.com/1920x1080/111/ffd000?text=Backdrop'">
        <div class="backdrop-gradient"></div>

        <div class="movie-content">
            <img src="{{ $movie['poster'] ?? '' }}" class="movie-poster" onerror="this.src='https://via.placeholder.com/280x420/111/ffd000?text=Poster'">

            <div class="movie-info">
                <span class="movie-id">TICKET #{{ $id }}</span>
                <h1 class="movie-title">{{ $movie['title'] ?? 'Movie Title' }}</h1>

                <div class="movie-meta">
                    <span class="age-badge">{{ $movie['age'] ?? '+18' }}</span>
                    <span>{{ $movie['genre'] ?? 'Action' }}</span>
                    <span>2h 15m</span>
                    <span style="color: var(--color-principal); font-weight: bold;">
                        {{ isset($movie['isComingSoon']) && $movie['isComingSoon'] ? 'Coming Soon' : 'Available Now' }}
                    </span>
                </div>

                <p class="movie-desc">{{ $movie['desc'] ?? 'Overview of the movie...' }}</p>

                <div class="action-buttons">
                    @if(isset($movie['isComingSoon']) && $movie['isComingSoon'])
                        <button class="btn-buy" disabled>
                            AVAILABLE {{ $movie['releaseDate'] ?? 'SOON' }}
                        </button>
                    @else
                        <button class="btn-buy" onclick="window.location.href='/booking/{{ $id }}'">
                            <img src="{{ asset('img/img/Ticket-amarillo.png') }}" alt="Ticket"> BUY TICKETS
                        </button>
                    @endif
                    <a href="/#cartelera" class="btn-back">BACK TO FILMS</a>
                </div>
            </div>
        </div>
    </div>

    @if(isset($movie['mediaCarousel']) && count($movie['mediaCarousel']) > 0)
    <section class="media-carousel-section">
        <h2 class="section-title">Media & Trailers</h2>
        
        <div class="carousel-container">
            <button class="media-nav-btn prev" onclick="moveCarousel(-1)" title="Previous">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
            </button>

            <div class="carousel-viewport">
                <div class="carousel-track" id="media-track">
                    
                    @foreach($movie['mediaCarousel'] as $media)
                        @if($media['type'] == 'video')
                            <div class="media-item" onclick="window.open('{{ $media['url'] }}', '_blank')">
                                <img src="{{ $media['thumbnail'] }}" alt="Trailer Thumbnail" onerror="this.src='https://via.placeholder.com/400x225/111/ffd000?text=Video+Not+Found'">
                                <div class="play-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                                </div>
                            </div>
                        @else
                            <div class="media-item">
                                <img src="{{ $media['url'] }}" alt="Movie Image" onerror="this.src='https://via.placeholder.com/400x225/111/ffd000?text=Image+Not+Found'">
                            </div>
                        @endif
                    @endforeach

                </div>
            </div>

            <button class="media-nav-btn next" onclick="moveCarousel(1)" title="Next">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </button>
        </div>
    </section>
    @endif
    @if(isset($movie['menuSpecial']['enabled']) && $movie['menuSpecial']['enabled'])
        <section class="exclusive-movie-menu">
            <h2 class="section-title">Exclusive For This Movie</h2>
            
            <div class="exclusive-banner">
                <div class="exclusive-img-container">
                    @if(!empty($movie['menuSpecial']['image']))
                        <img src="{{ $movie['menuSpecial']['image'] }}" alt="Special Menu" style="object-fit: cover; width: 100%; height: 100%;">
                    @else
                        <div style="width: 100%; height: 100%; background: #333; display: flex; align-items: center; justify-content: center;">
                            <span style="color: #fff;">No Image</span>
                        </div>
                    @endif
                </div>
                
                <div class="exclusive-info">
                    <span class="tag">Limited Edition</span>
                    <h3>{{ $movie['menuSpecial']['title'] ?? 'Exclusive Menu' }}</h3>
                    <p>{{ $movie['menuSpecial']['text'] ?? 'Available for a limited time.' }}</p>
                    
                    <button class="btn-unlock" onclick="window.location.href='/booking/{{ $id }}'">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                        GET TICKET TO UNLOCK
                    </button>
                </div>
            </div>
        </section>
    @endif

    <section class="reviews-section" style="padding: 50px 10% 100px; background: #000; color: white;">
        @if(session('error'))
    <div style="background: #721c24; color: #f8d7da; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
        {{ session('error') }}
    </div>
@endif

@if(session('status'))
    <div style="background: #155724; color: #d4edda; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
        {{ session('status') }}
    </div>
@endif
    <h2 style="color: var(--color-principal); margin-bottom: 30px; font-size: 2rem;">Audience Reviews</h2>

    @auth
        <div style="background: #111; padding: 25px; border-radius: 12px; margin-bottom: 40px; border: 1px solid #333;">
            <h4 style="margin-bottom: 15px; color: #fff;">Hi {{ Auth::user()->name }}, share your thoughts!</h4>
            
            <form action="{{ route('pelicula.review', ['id' => $id]) }}" method="POST">
                @csrf
                <div style="margin-bottom: 15px;">
                    <label style="color: #888; display: block; margin-bottom: 5px;">Score:</label>
                    <select name="score" required style="background: #222; color: #fff; border: 1px solid #444; padding: 10px; border-radius: 5px; width: 100px;">
                        <option value="5">5 ★★★★★</option>
                        <option value="4">4 ★★★★</option>
                        <option value="3">3 ★★★</option>
                        <option value="2">2 ★★</option>
                        <option value="1">1 ★</option>
                    </select>
                </div>

                <div style="margin-bottom: 15px;">
                    <textarea name="content" required placeholder="Write your review here..." rows="4" style="width: 100%; background: #222; color: #fff; border: 1px solid #444; padding: 15px; border-radius: 8px; resize: none;"></textarea>
                </div>

                <button type="submit" style="background: var(--color-principal); color: #000; padding: 12px 30px; border: none; border-radius: 5px; font-weight: bold; cursor: pointer; text-transform: uppercase;">
                    Submit Review
                </button>
            </form>
        </div>
    @else
        <div style="background: #111; padding: 20px; border-radius: 10px; border: 1px dashed #444; text-align: center; margin-bottom: 40px;">
            <p style="color: #aaa;">You must be <a href="{{ route('login') }}" style="color: var(--color-principal); text-decoration: none; font-weight: bold;">logged in</a> to write a review.</p>
        </div>
    @endauth

    <div class="reviews-list" style="display: grid; gap: 20px;">
    @forelse($reviews as $review)
        <div style="background: #111; padding: 20px; border-radius: 12px; display: flex; gap: 20px; align-items: flex-start; border: 1px solid #222;">
            
            @php
                // Generamos un hash del nombre o email para tener una imagen única
                $userHash = md5(strtolower(trim($review['title']))); 
                $avatarUrl = "https://www.gravatar.com/avatar/{$userHash}?d=identicon&s=100";
            @endphp
            <img src="{{ $avatarUrl }}" alt="User" style="width: 50px; height: 50px; border-radius: 50%; border: 2px solid var(--color-principal);">

            <div style="flex: 1;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <strong style="color: #fff;">{{ str_replace('Review by ', '', $review['title']) }}</strong>
                    <span style="color: var(--color-principal);">
                        {{ str_repeat('★', $review['score']) }}{{ str_repeat('☆', 5 - $review['score']) }}
                    </span>
                </div>
                <p style="color: #aaa; font-size: 0.95rem; line-height: 1.4; margin: 0;">
                    "{{ $review['content'] }}"
                </p>
            </div>
        </div>
    @empty
        <p style="color: #666; font-style: italic;">No reviews yet. Be the first one!</p>
    @endforelse
</div>
</section>

    <footer>
        <div class="footer-content">
            <div class="footer-col">
                <div class="footer-logo"><img src="{{ asset('img/img/Logo-Blanco.png') }}" alt="Cine Screenbites"></div>
                <p>Experience cinema like never before. Grab your popcorn, find your seat, and let the magic begin.</p>
            </div>
            <div class="footer-col">
                <h4>Explore</h4>
                <ul class="footer-links">
                    <li><a href="/#cartelera">Now Playing</a></li>
                    <li><a href="/#cartelera">Coming Soon</a></li>
                    <li><a href="/#bar">Food & Drinks</a></li>
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
            <p>&copy; 2026 Screenbites Cinema. All rights reserved.</p>
            <p class="footer-credits">
                Design with
                <svg class="heart-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                </svg>
                for <span>Beni</span>
            </p>
        </div>
    </footer>

    <script>
        // Header scroll effect
        window.addEventListener('scroll', () => {
            const headerEl = document.getElementById('main-header');
            if (window.scrollY > 50) {
                headerEl.classList.add('scrolled');
            } else {
                headerEl.classList.remove('scrolled');
            }
        });

        // Lógica de Carrusel Infinito y Auto-Play
        document.addEventListener('DOMContentLoaded', () => {
            const track = document.getElementById('media-track');
            
            // Verificación por si la sección del carrusel no existe
            if(!track) return; 

            const items = Array.from(track.children);
            const totalOriginals = items.length;
            
            // Si no hay items, no hacemos nada
            if (totalOriginals === 0) return;
            
            // Clonar items para el loop infinito (Añadir al final y al principio)
            items.forEach(item => {
                let clone = item.cloneNode(true);
                track.appendChild(clone);
            });
            
            items.slice().reverse().forEach(item => {
                let clone = item.cloneNode(true);
                track.insertBefore(clone, track.firstChild);
            });

            // Iniciar en el primer set original
            let currentIndex = totalOriginals;
            let isTransitioning = false;

            function updatePosition() {
                const itemElement = track.querySelector('.media-item');
                if(!itemElement) return;

                const gap = 20; // Igual que en el CSS
                const itemWidth = itemElement.getBoundingClientRect().width + gap;
                track.style.transition = 'none';
                track.style.transform = `translateX(-${currentIndex * itemWidth}px)`;
            }

            // Reposicionar al cargar o cambiar el tamaño de ventana
            setTimeout(updatePosition, 100);
            window.addEventListener('resize', updatePosition);

            window.moveCarousel = function(direction) {
                if (isTransitioning) return;
                isTransitioning = true;
                
                const itemElement = track.querySelector('.media-item');
                if(!itemElement) return;

                const itemWidth = itemElement.getBoundingClientRect().width + 20;
                
                currentIndex += direction;
                track.style.transition = 'transform 0.5s ease-in-out';
                track.style.transform = `translateX(-${currentIndex * itemWidth}px)`;

                resetAutoPlay();
            };

            track.addEventListener('transitionend', () => {
                isTransitioning = false;
                const itemElement = track.querySelector('.media-item');
                if(!itemElement) return;

                const itemWidth = itemElement.getBoundingClientRect().width + 20;

                // Salto infinito de los clones al set real
                if (currentIndex >= totalOriginals * 2) {
                    track.style.transition = 'none';
                    currentIndex = totalOriginals; 
                    track.style.transform = `translateX(-${currentIndex * itemWidth}px)`;
                }
                
                if (currentIndex <= 0) {
                    track.style.transition = 'none';
                    currentIndex = totalOriginals;
                    track.style.transform = `translateX(-${currentIndex * itemWidth}px)`;
                }
            });

            let autoPlayInterval;
            function resetAutoPlay() {
                clearInterval(autoPlayInterval);
                autoPlayInterval = setInterval(() => {
                    moveCarousel(1);
                }, 3500); // Se mueve cada 3.5 segundos
            }

            resetAutoPlay();
        });
    </script>

</body>
</html>