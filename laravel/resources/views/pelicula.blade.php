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
            padding: 0 5%;
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
                height: 50px;
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
                opacity: 0.3;
                filter: blur(5px);
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

                            &:hover {
                                background: var(--color-blanco);
                                color: var(--color-negro);
                                transform: scale(1.05);
                                
                                img {
                                    filter: invert(1);
                                }
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
                    width: 380px; /* <--- FOTO MÁS GRANDE AQUÍ ---> */
                    height: 260px; /* <--- ALTURA AJUSTADA ---> */
                    border-radius: 8px;
                    overflow: hidden;
                    border: 2px solid var(--color-principal);
                    position: relative;
                    z-index: 2;
                    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5); /* Pequeña sombra para destacar */

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
                        <a href="#" class="user-profile" title="My Profile">
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
        <img src="{{ asset($movie['bgImg'] ?? '') }}" class="backdrop-img" onerror="this.src='https://via.placeholder.com/1920x1080/111/ffd000?text=Backdrop'">
        <div class="backdrop-gradient"></div>

        <div class="movie-content">
            <img src="{{ asset($movie['poster'] ?? '') }}" class="movie-poster" onerror="this.src='https://via.placeholder.com/280x420/111/ffd000?text=Poster'">

            <div class="movie-info">
                <span class="movie-id">TICKET #{{ $id }}</span>
                <h1 class="movie-title">{{ $movie['title'] ?? 'Movie Title' }}</h1>

                <div class="movie-meta">
                    <span class="age-badge">{{ $movie['age'] ?? '+18' }}</span>
                    <span>{{ $movie['genre'] ?? 'Action' }}</span>
                    <span>2h 15m</span>
                    <span>Available Now</span>
                </div>

                <p class="movie-desc">{{ $movie['desc'] ?? 'Overview of the movie...' }}</p>

                <div class="action-buttons">
                    <button class="btn-buy" onclick="window.location.href='/booking/{{ $id }}'">
                        <img src="{{ asset('img/img/Ticket-amarillo.png') }}" alt="Ticket"> BUY TICKETS - $8.50
                    </button>
                    <a href="/" class="btn-back">BACK TO FILMS</a>
                </div>
            </div>
        </div>
    </div>

    <section class="media-carousel-section">
        <h2 class="section-title">Media & Trailers</h2>
        
        <div class="carousel-container">
            <button class="media-nav-btn prev" onclick="moveCarousel(-1)" title="Previous">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
            </button>

            <div class="carousel-viewport">
                <div class="carousel-track" id="media-track">
                    
                    <div class="media-item">
                        </div>
                    
                    <div class="media-item">
                        </div>

                    <div class="media-item">
                        </div>

                    <div class="media-item">
                        </div>

                </div>
            </div>

            <button class="media-nav-btn next" onclick="moveCarousel(1)" title="Next">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </button>
        </div>
    </section>

    @if(in_array((int)$id, [1, 4, 9]) || in_array((string)$id, ['01', '04', '09']))
        @php
            $comboName = '';
            $comboDesc = '';
            $comboImg = '';

            if ($id == '01' || $id == 1) {
                $comboName = 'Vengeance Combo';
                $comboDesc = 'Enhance your experience with the exclusive Kill Bill themed popcorn bucket styled after the iconic yellow suit, plus an XL drink cup featuring a realistic Katana hilt grip.';
                $comboImg = 'img/1-Kill-Bill/kill-bill.jpeg';
            } elseif ($id == '04' || $id == 4) {
                $comboName = 'Atomic Combo';
                $comboDesc = 'Experience the intensity with our Extra Spicy Popcorn and a Limited Edition Black Soda to cool down the heat.';
                $comboImg = 'img/4-Oppenheimer/oppenheimer.png';
            } elseif ($id == '09' || $id == 9) {
                $comboName = 'Dreamhouse Snack';
                $comboDesc = 'Step into the Dreamhouse with our sparkly pink bucket filled with sweet popcorn, paired with a refreshing Cotton Candy Drink.';
                $comboImg = 'img/9-Barbie/barbie.png';
            }
        @endphp

        <section class="exclusive-movie-menu">
            <h2 class="section-title">Exclusive For This Movie</h2>
            
            <div class="exclusive-banner">
                <div class="exclusive-img-container">
                    <img src="{{ asset($comboImg) }}" alt="{{ $comboName }}" onerror="this.src='https://via.placeholder.com/380x260/111/{{ str_replace('#', '', $movie['bg'] ?? 'ffd000') }}?text=Combo'">
                </div>
                
                <div class="exclusive-info">
                    <span class="tag">Limited Edition</span>
                    <h3>The {{ $comboName }}</h3>
                    <p>{{ $comboDesc }}</p>
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
                const itemWidth = itemElement.getBoundingClientRect().width + 20;
                
                currentIndex += direction;
                track.style.transition = 'transform 0.5s ease-in-out';
                track.style.transform = `translateX(-${currentIndex * itemWidth}px)`;

                resetAutoPlay();
            };

            track.addEventListener('transitionend', () => {
                isTransitioning = false;
                const itemElement = track.querySelector('.media-item');
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