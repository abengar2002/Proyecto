<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Screenbites - Seat Selection</title>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <link rel="stylesheet" href="{{ asset('css/webbar.css') }}">

    <style>
        :root {
            --color-negro: #000000;
            --color-gris-oscuro: #0a0a0a;
            --color-gris-tarjeta: #141414;
            --color-gris-claro: #333333;
            --color-blanco: #ffffff;
            
            /* COLOR DINÁMICO DE LA PELÍCULA */
            --color-principal: {{ $movie['bg'] ?? '#ffd000' }}; 
            --color-texto-btn: {{ $movie['textColor'] ?? 'black' }};

            --color-asiento-libre: #222222;
            --color-asiento-ocupado: #0f0f0f;
            --color-asiento-vip: #5a3e90;
        }

        /* SOBREESCRIBIMOS LA BARRA DE SCROLL GLOBAL CON EL COLOR DE LA PELÍCULA */
        ::-webkit-scrollbar-thumb {
            background-color: var(--color-principal) !important;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background-color: var(--color-principal) !important;
            filter: brightness(0.85); /* La oscurece un pelín al pasar el ratón */
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
            font-family: 'Arial', sans-serif; 
            background-color: var(--color-negro); 
            color: var(--color-blanco); 
            min-height: 100vh; 
            display: flex; 
            flex-direction: column; 
            position: relative;
            overflow-x: hidden;
        }

        /* --- FONDO INMERSIVO DE LA PELI --- */
        .page-bg {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            z-index: -2;
            object-fit: cover;
            opacity: 0.15;
            filter: blur(8px);
        }

        .page-bg-gradient {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            z-index: -1;
            background: radial-gradient(circle at center, transparent 0%, var(--color-negro) 80%);
        }

        /* --- HEADER --- */
        header {
            position: fixed; top: 0; left: 0; right: 0; display: flex; justify-content: space-between; align-items: center;
            padding: 0 5% 0 3%; height: 100px; z-index: 1000; background-color: transparent;
            border-bottom: 1px solid transparent; transition: background-color 0.3s ease, box-shadow 0.3s ease, border-bottom 0.3s ease;
            font-family: 'Arial Black', 'Arial Bold', sans-serif;

            &.scrolled {
                background-color: rgba(0, 0, 0, 0.95); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.8); border-bottom: 1px solid rgba(255, 255, 255, 0.05);

                nav a:not(.active), nav .logout-btn, .user-profile .user-name, .user-profile .chevron-icon {
                    color: var(--color-blanco) !important; text-shadow: none !important; 
                }
            }

            .logo img { height: 60px; }

            nav {
                ul { list-style: none; display: flex; align-items: center; gap: 30px; }

                a, .logout-btn {
                    text-decoration: none; color: var(--header-text-color, var(--color-blanco)); text-transform: uppercase;
                    font-size: 13px; font-weight: 900; letter-spacing: 2px; text-shadow: 0 2px 4px rgba(0, 0, 0, 0.6);
                    transition: color 0.3s ease, transform 0.2s ease, text-shadow 0.3s ease; background: none; border: none;
                    cursor: pointer; padding: 0; display: flex; align-items: center; gap: 8px;

                    &:hover {
                        color: var(--color-principal) !important; transform: scale(1.05);
                        text-shadow: 0px 2px 10px rgba(0, 0, 0, 1), 0px 0px 4px rgba(0, 0, 0, 1) !important;
                    }
                }
            }
        }

        .user-nav { 
            display: flex; align-items: center; gap: 20px; border-left: 2px solid rgba(255, 255, 255, 0.4); 
            padding-left: 20px; margin-left: 10px; 

            .user-profile { 
                display: flex; align-items: center; gap: 10px; color: var(--header-text-color, var(--color-blanco)); transition: color 0.3s ease; 

                .user-avatar {
                    width: 35px; height: 35px; border-radius: 50%; object-fit: cover; border: none;
                    transition: transform 0.3s ease, box-shadow 0.3s ease; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
                }

                .user-name, .chevron-icon { 
                    color: var(--header-text-color, var(--color-blanco)); transition: color 0.3s ease, text-shadow 0.3s ease; 
                }
                .chevron-icon { width: 16px; height: 16px; }

                &:hover {
                    .user-avatar { transform: scale(1.1); box-shadow: 0 4px 12px rgba(0, 0, 0, 0.9); }
                    .user-name, .chevron-icon {
                        color: var(--color-principal) !important; text-shadow: 0px 2px 10px rgba(0, 0, 0, 1), 0px 0px 4px rgba(0, 0, 0, 1) !important;
                    }
                }
            }
        }

        /* --- CONTENEDOR PRINCIPAL --- */
        .booking-container { 
            display: flex; flex: 1; padding: 130px 5% 60px; gap: 50px; max-width: 1400px; margin: 0 auto; width: 100%; 

            .seating-section { 
                flex: 3; display: flex; flex-direction: column; align-items: center; position: relative;

                .back-btn { 
                    color: var(--color-blanco); text-decoration: none; display: inline-flex; align-items: center; gap: 8px; font-weight: bold; font-size: 14px; text-transform: uppercase; transition: color 0.3s ease; align-self: flex-start; margin-bottom: 20px;
                    &:hover { color: var(--color-principal); }
                }

                .movie-info { 
                    text-align: center; margin-bottom: 50px; 
                    
                    h1 { 
                        font-family: 'Arial Black', sans-serif; font-size: 42px; color: var(--color-blanco); text-transform: uppercase; letter-spacing: 2px; margin-bottom: 10px; text-shadow: 0 5px 15px rgba(0,0,0,0.5);
                    }
                    p { 
                        color: var(--color-principal); font-size: 16px; font-weight: bold; letter-spacing: 1px;
                    }
                }

                .screen-container { 
                    width: 100%; max-width: 600px; margin-bottom: 60px; perspective: 400px; 

                    .screen { 
                        height: 70px; width: 100%; background: linear-gradient(to bottom, rgba(255, 255, 255, 0.8), transparent); transform: rotateX(-45deg); box-shadow: 0 15px 50px rgba(255, 255, 255, 0.15); border-top: 4px solid var(--color-blanco); border-radius: 5px 5px 0 0; display: flex; justify-content: center; align-items: center; color: var(--color-blanco); font-weight: 900; letter-spacing: 8px; text-transform: uppercase; font-size: 12px; opacity: 0.8;
                    }
                }

                .seats-grid { 
                    display: flex; flex-direction: column; gap: 15px; margin-bottom: 50px; 

                    .seat-row { 
                        display: flex; gap: 12px; justify-content: center; align-items: center; 

                        .row-label { color: #666; font-size: 12px; width: 20px; text-align: center; font-weight: bold; }
                        
                        .seat { 
                            width: 38px; height: 38px; background-color: var(--color-asiento-libre); border-radius: 8px 8px 4px 4px; cursor: pointer; transition: all 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275); position: relative; border: 1px solid #333;
                            
                            &::after { content: ''; position: absolute; bottom: -5px; left: 10%; width: 80%; height: 5px; background-color: rgba(0,0,0,0.5); border-radius: 0 0 4px 4px; }
                            
                            &:hover:not(.occupied) { transform: translateY(-5px) scale(1.1); background-color: #555; border-color: #777; }
                            
                            &.selected { background-color: var(--color-principal); border-color: var(--color-principal); box-shadow: 0 0 15px rgba(var(--color-principal-rgb, 255, 208, 0), 0.4); transform: scale(1.1); }
                            
                            &.occupied { background-color: var(--color-asiento-ocupado); border-color: #111; cursor: not-allowed; opacity: 0.4; }
                            
                            &.vip { background-color: var(--color-asiento-vip); border-color: #724db8; }
                            &.vip.selected { background-color: var(--color-principal); border-color: var(--color-principal); }
                            
                            /* Pasillo central */
                            &:nth-child(6) { margin-right: 30px; } 
                        }
                    }
                }

                .legend { 
                    display: flex; justify-content: center; gap: 30px; margin-top: 20px; padding: 20px 40px; background-color: rgba(20,20,20,0.8); border-radius: 50px; border: 1px solid #333; backdrop-filter: blur(5px);
                    
                    .legend-item { 
                        display: flex; align-items: center; gap: 10px; font-size: 13px; color: #aaa; font-weight: bold; 
                        .legend-seat { width: 20px; height: 20px; border-radius: 4px 4px 2px 2px; }
                    }
                }
            }

            .summary-section { 
                flex: 1; min-width: 350px; background-color: rgba(20, 20, 20, 0.85); backdrop-filter: blur(15px); border-radius: 12px; padding: 35px; border: 1px solid rgba(255,255,255,0.1); height: fit-content; position: sticky; top: 120px; box-shadow: 0 20px 50px rgba(0,0,0,0.5);

                .summary-title { font-family: 'Arial Black', sans-serif; font-size: 20px; color: var(--color-blanco); text-transform: uppercase; border-bottom: 2px solid var(--color-principal); padding-bottom: 15px; margin-bottom: 25px; }
                
                .summary-details { 
                    margin-bottom: 30px; 

                    .summary-row { 
                        display: flex; justify-content: space-between; margin-bottom: 18px; font-size: 14px; color: #ccc; 
                        span.val { color: var(--color-blanco); font-weight: bold; text-align: right; }
                    }
                    
                    .selected-seats-list { 
                        display: flex; flex-wrap: wrap; gap: 8px; margin-top: 10px; 
                        .seat-badge { background-color: transparent; color: var(--color-principal); border: 1px solid var(--color-principal); padding: 4px 10px; border-radius: 4px; font-size: 12px; font-weight: bold; }
                    }
                }

                .total-row { 
                    display: flex; justify-content: space-between; align-items: center; border-top: 1px dashed #555; padding-top: 25px; margin-top: 15px; 
                    
                    .total-label { font-size: 16px; color: #888; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; }
                    .total-price { font-size: 32px; color: var(--color-principal); font-family: 'Arial Black', sans-serif; }
                }

                .btn-checkout { 
                    width: 100%; background-color: var(--color-principal); color: var(--color-texto-btn) !important; border: none; padding: 18px; border-radius: 6px; font-family: 'Arial Black', sans-serif; font-size: 14px; text-transform: uppercase; cursor: pointer; transition: all 0.3s ease; margin-top: 35px; display: flex; justify-content: center; align-items: center; gap: 10px; 

                    svg { width: 18px; height: 18px; stroke: currentColor; transition: stroke 0.3s ease; }

                    &:hover:not(:disabled) { 
                        background-color: var(--color-blanco); color: var(--color-negro) !important; transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.3); 
                    }

                    &:disabled { opacity: 0.5; cursor: not-allowed; background-color: var(--color-principal); }
                }
            }
        }

        /* --- FOOTER --- */
        footer {
            background-color: var(--color-negro); padding: 60px 5% 40px; border-top: 1px solid var(--color-gris-claro); font-family: 'Arial Black', 'Arial Bold', sans-serif;

            .footer-content {
                display: flex; justify-content: space-between; flex-wrap: wrap; gap: 40px; max-width: 1200px; margin: 0 auto;

                .footer-col {
                    flex: 1; min-width: 200px;

                    &:first-child {
                        display: flex; flex-direction: column; align-items: center; text-align: center;
                        .footer-logo img { height: 60px; margin-bottom: 20px; display: block; }
                        p { max-width: 250px; }
                    }

                    p { font-family: Arial, sans-serif; color: #888; font-size: 13px; line-height: 1.6; }

                    h4 { font-size: 16px; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 20px; color: var(--color-principal); }

                    .footer-links {
                        list-style: none;
                        li {
                            margin-bottom: 10px;
                            a {
                                color: var(--color-blanco); text-decoration: none; font-family: Arial, sans-serif; font-size: 14px; transition: color 0.3s ease;
                                &:hover { color: var(--color-principal); }
                            }
                        }
                    }
                }
            }

            .footer-bottom {
                max-width: 1200px; margin: 40px auto 0; padding-top: 20px; border-top: 1px solid var(--color-gris-claro); display: flex; justify-content: space-between; align-items: center; font-family: Arial, sans-serif; font-size: 12px; color: #666;

                .footer-credits {
                    display: flex; align-items: center; gap: 8px; color: #888; font-family: Arial, sans-serif;
                    span { color: var(--color-principal); font-weight: bold; }
                    .heart-icon { width: 16px; height: 16px; color: #888; transition: color 0.3s ease; }
                    &:hover .heart-icon { color: #ff4444; filter: drop-shadow(0 0 3px #ff4444); }
                }
            }
        }
    </style>
</head>
<body>

    <img src="{{ $movie['bgImg'] ?? '' }}" class="page-bg" onerror="this.src='https://via.placeholder.com/1920x1080/111/333'">
    <div class="page-bg-gradient"></div>

    <header id="main-header">
        <div class="logo">
            <a href="/"><img src="{{ asset('img/img/Logo-Blanco.png') }}" alt="Screenbites Logo"></a>
        </div>
        <nav>
            <ul>
                <li><a href="/">HOME</a></li>
                <li><a href="/#cartelera">FILMS</a></li>
                <li><a href="/#bar">MENUS</a></li>
                <li><a href="/community">COMMUNITY</a></li>

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

    <div class="booking-container">
        
        <div class="seating-section">
            <a href="/pelicula/{{ $id }}" class="back-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Back to Movie
            </a>

            <div class="movie-info">
                <h1>{{ $movie['title'] ?? 'Movie' }}</h1>
                <p>Today, 20:30 &nbsp;•&nbsp; Room 4 &nbsp;•&nbsp; {{ $movie['age'] ?? '+18' }}</p>
            </div>

            <div class="screen-container">
                <div class="screen">Screen</div>
            </div>

            <div class="seats-grid" id="seats-container">
                </div>

            <div class="legend">
                <div class="legend-item"><div class="legend-seat" style="background-color: var(--color-asiento-libre);"></div> Standard ($8.50)</div>
                <div class="legend-item"><div class="legend-seat" style="background-color: var(--color-asiento-vip);"></div> VIP ($12.00)</div>
                <div class="legend-item"><div class="legend-seat" style="background-color: var(--color-principal);"></div> Selected</div>
                <div class="legend-item"><div class="legend-seat" style="background-color: var(--color-asiento-ocupado);"></div> Occupied</div>
            </div>
        </div>

        <div class="summary-section">
            <h2 class="summary-title">Booking Summary</h2>
            
            <div class="summary-details">
                <div class="summary-row">
                    <span>Movie</span>
                    <span class="val">{{ $movie['title'] ?? 'Movie' }}</span>
                </div>
                <div class="summary-row">
                    <span>Session</span>
                    <span class="val">Today, 20:30</span>
                </div>
                <div class="summary-row" style="flex-direction: column; gap: 10px; margin-top: 25px;">
                    <span style="border-bottom: 1px solid #333; padding-bottom: 8px;">Selected Seats:</span>
                    <div class="selected-seats-list" id="selected-seats-display">
                        <span style="color: #666; font-size: 13px; font-style: italic;">No seats selected yet.</span>
                    </div>
                </div>
                <div class="summary-row" style="margin-top: 25px;">
                    <span>Tickets Total</span>
                    <span class="val" id="tickets-price" style="font-size: 18px;">$0.00</span>
                </div>
            </div>

            <div class="total-row">
                <span class="total-label">Total</span>
                <span class="total-price" id="total-price">$0.00</span>
            </div>

            <button class="btn-checkout" id="btn-continue" disabled>
                Continue to Food
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </button>
        </div>
    </div>

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

        const STANDARD_PRICE = 8.50;
        const VIP_PRICE = 12.00;
        
        const rows = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
        const seatsPerRow = 10;
        const vipRows = ['D', 'E']; 
        
        // Forzamos a que siempre sea un array limpio para que JS no explote
        const occupiedSeats = Object.values({!! json_encode($realOccupied ?? []) !!});

        let selectedSeats = [];
        let currentTotal = 0;

        const seatsContainer = document.getElementById('seats-container');
        const selectedSeatsDisplay = document.getElementById('selected-seats-display');
        const ticketsPriceDisplay = document.getElementById('tickets-price');
        const totalPriceDisplay = document.getElementById('total-price');
        const btnContinue = document.getElementById('btn-continue');

        // --- FUNCIÓN TOASTIFY PERSONALIZADA ---
        function showToast(message, type = 'info') {
            let iconSvg = '';
            
            if (type === 'warning') {
                iconSvg = `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--color-principal)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>`;
            } else if (type === 'ticket') {
                iconSvg = `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--color-principal)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 7h14a2 2 0 0 1 2 2v1.5a1.5 1.5 0 0 0 0 3V15a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-1.5a1.5 1.5 0 0 0 0-3V9a2 2 0 0 1 2-2z"></path><line x1="8" y1="7" x2="8" y2="17" stroke-dasharray="2 2"></line></svg>`;
            } else {
                iconSvg = `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--color-principal)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>`;
            }

            Toastify({
                text: `<div style="display: flex; align-items: center; gap: 12px;">${iconSvg} <span>${message}</span></div>`,
                escapeMarkup: false, 
                duration: 3000,
                gravity: "top",
                position: "right",
                style: {
                    background: "#141414",
                    color: "#ffffff",
                    borderLeft: "4px solid var(--color-principal)",
                    fontFamily: "'Arial Black', sans-serif",
                    fontSize: "13px",
                    borderRadius: "4px",
                    boxShadow: "0 5px 15px rgba(0,0,0,0.5)",
                    display: "flex",
                    alignItems: "center"
                }
            }).showToast();
        }

        function generateSeats() {
            rows.forEach(row => {
                const rowDiv = document.createElement('div');
                rowDiv.className = 'seat-row';
                
                const labelDiv = document.createElement('div');
                labelDiv.className = 'row-label';
                labelDiv.innerText = row;
                rowDiv.appendChild(labelDiv);

                for (let i = 1; i <= seatsPerRow; i++) {
                    const seatId = `${row}${i}`;
                    const seatDiv = document.createElement('div');
                    seatDiv.className = 'seat';
                    seatDiv.dataset.seatId = seatId;

                    if (occupiedSeats.includes(seatId)) {
                        seatDiv.classList.add('occupied');
                    } else {
                        if (vipRows.includes(row)) {
                            seatDiv.classList.add('vip');
                            seatDiv.dataset.price = VIP_PRICE;
                        } else {
                            seatDiv.dataset.price = STANDARD_PRICE;
                        }

                        seatDiv.addEventListener('click', () => toggleSeat(seatDiv));
                    }

                    rowDiv.appendChild(seatDiv);
                }
                
                const labelDivRight = document.createElement('div');
                labelDivRight.className = 'row-label';
                labelDivRight.innerText = row;
                rowDiv.appendChild(labelDivRight);

                seatsContainer.appendChild(rowDiv);
            });
        }

        function toggleSeat(seatElement) {
            const seatId = seatElement.dataset.seatId;
            const price = parseFloat(seatElement.dataset.price);

            if (seatElement.classList.contains('selected')) {
                seatElement.classList.remove('selected');
                selectedSeats = selectedSeats.filter(s => s.id !== seatId);
            } else {
                if(selectedSeats.length >= 4) {
                    showToast("You can only select up to 4 seats per transaction.", "ticket");
                    return;
                }
                seatElement.classList.add('selected');
                selectedSeats.push({ id: seatId, price: price });
            }

            updateSummary();
        }

        function updateSummary() {
            if (selectedSeats.length === 0) {
                selectedSeatsDisplay.innerHTML = '<span style="color: #666; font-size: 13px; font-style: italic;">No seats selected yet.</span>';
                ticketsPriceDisplay.innerText = '$0.00';
                totalPriceDisplay.innerText = '$0.00';
                btnContinue.disabled = true;
                currentTotal = 0;
                return;
            }

            selectedSeatsDisplay.innerHTML = '';
            currentTotal = 0;

            selectedSeats.sort((a, b) => a.id.localeCompare(b.id));

            selectedSeats.forEach(seat => {
                currentTotal += seat.price;
                const badge = document.createElement('span');
                badge.className = 'seat-badge';
                badge.innerText = seat.id;
                selectedSeatsDisplay.appendChild(badge);
            });

            const formattedTotal = `$${currentTotal.toFixed(2)}`;
            ticketsPriceDisplay.innerText = formattedTotal;
            totalPriceDisplay.innerText = formattedTotal;
            
            btnContinue.disabled = false;
        }

        btnContinue.addEventListener('click', () => {
            const seatsParam = selectedSeats.map(s => s.id).join(',');
            const totalParam = currentTotal.toFixed(2);
            window.location.href = `/booking/{{ $id }}/food?seats=${seatsParam}&ticketsTotal=${totalParam}`;
        });

        generateSeats();

    </script>
</body>
</html>