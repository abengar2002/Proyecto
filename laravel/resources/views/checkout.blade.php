<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Screenbites - Checkout</title>
    
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
            position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -2; 
            object-fit: cover; opacity: 0.15; filter: blur(8px); 
        }
        .page-bg-gradient { 
            position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; 
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

        /* --- CONTENEDOR PRINCIPAL CHECKOUT --- */
        .checkout-container { 
            display: flex; flex: 1; padding: 130px 5% 60px; gap: 60px; max-width: 1200px; margin: 0 auto; width: 100%; align-items: flex-start;

            /* ZONA IZQUIERDA: PAGO */
            .payment-section { 
                flex: 2; background-color: rgba(20,20,20,0.8); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 40px; position: relative;

                .back-btn { 
                    color: var(--color-blanco); text-decoration: none; display: inline-flex; align-items: center; gap: 8px; font-weight: bold; font-size: 14px; text-transform: uppercase; transition: color 0.3s ease; align-self: flex-start; margin-bottom: 20px;
                    &:hover { color: var(--color-principal); }
                }

                h1 { font-family: 'Arial Black', sans-serif; font-size: 28px; text-transform: uppercase; margin-bottom: 30px; border-bottom: 2px solid var(--color-principal); padding-bottom: 15px; }

                .payment-method-single {
                    display: flex; align-items: center; gap: 20px; background: rgba(255, 255, 255, 0.03); border: 1px solid var(--color-principal); border-radius: 8px; padding: 20px; margin-bottom: 30px; box-shadow: 0 0 15px rgba(var(--color-principal-rgb, 255, 208, 0), 0.05);

                    svg { width: 36px; height: 36px; color: var(--color-principal); flex-shrink: 0; }

                    .method-info {
                        flex: 1;
                        strong { display: block; font-size: 16px; margin-bottom: 4px; text-transform: uppercase; }
                        p { color: #888; font-size: 13px; }
                    }
                    
                    .card-icons {
                        display: flex; gap: 10px; opacity: 0.7;
                        svg { width: 30px; height: 20px; color: #fff; }
                    }
                }

                .secure-notice {
                    background: rgba(0,0,0,0.6); border: 1px dashed var(--color-principal); border-radius: 8px; padding: 30px; text-align: center; color: #ccc; line-height: 1.6;

                    svg { width: 40px; height: 40px; color: var(--color-principal); margin-bottom: 15px; }
                }
            }

            /* ZONA DERECHA: RESUMEN Y BOTÓN FINAL */
            .summary-section { 
                flex: 1; min-width: 350px; background-color: var(--color-principal); color: var(--color-texto-btn); border-radius: 12px; padding: 40px; box-shadow: 0 20px 50px rgba(0,0,0,0.5); position: sticky; top: 120px;

                h2 { font-family: 'Arial Black', sans-serif; font-size: 24px; text-transform: uppercase; margin-bottom: 5px; }

                .summary-movie { font-size: 14px; font-weight: bold; margin-bottom: 25px; opacity: 0.8; }

                .final-cart { 
                    margin-bottom: 30px; border-top: 1px solid rgba(0,0,0,0.1); border-bottom: 1px solid rgba(0,0,0,0.1); padding: 20px 0; 
                    
                    .final-item { 
                        display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 14px; font-weight: bold; 
                        span:first-child { opacity: 0.8; }
                    }
                }

                .total-box { 
                    display: flex; justify-content: space-between; align-items: center; 

                    span { font-size: 16px; font-weight: bold; text-transform: uppercase; }
                    strong { font-family: 'Arial Black', sans-serif; font-size: 36px; }
                }

                .btn-pay { 
                    width: 100%; background-color: var(--color-negro); color: var(--color-principal); border: none; padding: 20px; border-radius: 6px; font-family: 'Arial Black', sans-serif; font-size: 16px; text-transform: uppercase; cursor: pointer; transition: all 0.3s ease; margin-top: 30px; display: flex; justify-content: center; align-items: center; gap: 10px; 

                    &:hover { background-color: #222; transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.3); }

                    &:disabled { opacity: 0.7; cursor: wait; transform: none; }

                    /* Loader */
                    .loader { 
                        border: 3px solid rgba(255,255,255,0.1); border-top: 3px solid var(--color-principal); border-radius: 50%; width: 20px; height: 20px; animation: spin 1s linear infinite; display: none; 
                    }
                }

                .terms-text { text-align: center; font-size: 11px; margin-top: 15px; opacity: 0.7; font-weight: bold; }
            }
        }

        /* WIDGET TEMPORIZADOR */
        #countdown-widget { 
            position: fixed; top: 100px; right: 5%; background: var(--color-principal); color: var(--color-texto-btn); padding: 12px 20px; border-radius: 8px; font-family: 'Arial Black', sans-serif; font-size: 16px; z-index: 9999; box-shadow: 0 10px 25px rgba(0,0,0,0.5); display: flex; align-items: center; gap: 10px; border: 1px solid rgba(255,255,255,0.2); 
            
            svg { stroke: currentColor; }
        }

        @keyframes spin { 
            0% { transform: rotate(0deg); } 
            100% { transform: rotate(360deg); } 
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

    <div id="countdown-widget">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
        <span id="timer-display">10:00</span>
    </div>

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

    <div class="checkout-container">
        
        <div class="payment-section">
            <a href="/booking/{{ $id }}/food" class="back-btn" onclick="javascript:history.back(); return false;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Back to Menu
            </a>

            <h1>Payment Details</h1>

            <div class="payment-method-single">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                    <line x1="1" y1="10" x2="23" y2="10"></line>
                </svg>
                <div class="method-info">
                    <strong>Credit / Debit Card</strong>
                    <p>Secure payment processed by Stripe</p>
                </div>
                <div class="card-icons">
                    <svg viewBox="0 0 36 24" fill="none"><rect width="36" height="24" rx="4" fill="#1434CB"/><path d="M12.98 16.92l1.63-10.23h2.64l-1.63 10.23h-2.64zm11.39-10.05c-.8-.25-2.06-.52-3.48-.52-2.61 0-4.46 1.4-4.48 3.4-.03 1.48 1.34 2.22 2.36 2.73 1.04.5 1.4.83 1.4 1.28 0 .69-.83 1.02-1.61 1.02-1.35 0-2.07-.21-3.18-.7l-.44 2.1c.78.36 2.24.68 3.76.7 2.77 0 4.58-1.37 4.61-3.5.02-1.18-.7-2.07-2.28-2.55-1.02-.48-1.65-.8-1.65-1.28 0-.46.54-.95 1.55-.95 1.08-.02 1.88.24 2.25.43l.43-2.12zm-9.35 10.05l-2.67-10.23h-1.92c-.64 0-1.17.38-1.42.97l-4.04 9.26h2.78l.55-1.53h3.4l.32 1.53h2.66zm-3.6-4.32l1.38-3.78.8 3.78h-2.18z" fill="#fff"/></svg>
                    <svg viewBox="0 0 36 24" fill="none"><rect width="36" height="24" rx="4" fill="#FF5F00"/><circle cx="13" cy="12" r="7" fill="#EB001B"/><circle cx="23" cy="12" r="7" fill="#F79E1B"/><path d="M18 12c0-2.34 1.1-4.42 2.8-5.74A7 7 0 0013 5a7 7 0 000 14c1.86 0 3.53-1.04 4.54-2.6A6.98 6.98 0 0118 12z" fill="#FF5F00"/></svg>
                </div>
            </div>

            <form id="payment-form" action="{{ route('checkout.process') }}" method="POST">
                @csrf
                <input type="hidden" name="total" id="hidden-total" value="0">
                <input type="hidden" name="movie_title" value="{{ $movie['title'] }}">
                <input type="hidden" name="seats" id="hidden-seats" value="">
                <input type="hidden" name="items_json" id="hidden-items" value="">
                
                <div class="secure-notice">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                    <h3>Secure Payment Gateway</h3>
                    <p style="margin-top: 10px; font-size: 14px;">To ensure your security, you will be redirected to our PCI-compliant payment partner (Stripe) to enter your card details safely.</p>
                </div>
            </form>
        </div>

        <div class="summary-section">
            <h2>Your Order</h2>
            <div class="summary-movie">{{ $movie['title'] ?? 'Movie' }} • Today, 20:30</div>

            <div class="final-cart" id="final-cart-list">
                </div>

            <div class="total-box">
                <span>Total to Pay</span>
                <strong id="final-total">$0.00</strong>
            </div>

            <button type="submit" form="payment-form" class="btn-pay" id="btn-pay">
                <span id="btn-text">Confirm Payment</span>
                <div class="loader" id="pay-loader"></div>
            </button>
            <p class="terms-text">By confirming, you agree to our Terms & Conditions.</p>
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

        const cartData = sessionStorage.getItem('screenbites_cart');
        const cartContainer = document.getElementById('final-cart-list');
        const totalDisplay = document.getElementById('final-total');
        
        // Inputs ocultos para enviar al backend
        const hiddenTotalInput = document.getElementById('hidden-total');
        const hiddenSeatsInput = document.getElementById('hidden-seats');
        const hiddenItemsInput = document.getElementById('hidden-items');
        
        let grandTotal = 0;

        if (cartData) {
            const cart = JSON.parse(cartData);
            const items = Object.values(cart);

            items.forEach(item => {
                const itemTotal = item.isFixed ? item.price : item.price * item.qty;
                grandTotal += itemTotal;

                const qtyText = item.isFixed ? '' : `${item.qty}x `;
                
                cartContainer.innerHTML += `
                    <div class="final-item">
                        <span>${qtyText}${item.name}</span>
                        <span>$${itemTotal.toFixed(2)}</span>
                    </div>
                `;
            });

            totalDisplay.innerText = `$${grandTotal.toFixed(2)}`;
            
            // Inyectamos el total en el input oculto
            hiddenTotalInput.value = grandTotal.toFixed(2);
            // Guardamos todo el carrito en formato texto por si nos sirve
            hiddenItemsInput.value = cartData;
            
            // Extraer las butacas del nombre (ej: "Tickets (A1,A2)" -> "A1,A2")
            if (cart['Tickets']) {
                let seatsRaw = cart['Tickets'].name;
                seatsRaw = seatsRaw.replace('Tickets (', '').replace(')', '');
                hiddenSeatsInput.value = seatsRaw;
            }

        } else {
            cartContainer.innerHTML = '<div style="text-align:center; font-style:italic;">No items found.</div>';
            document.getElementById('btn-pay').disabled = true;
        }

        // Efecto visual al enviar el formulario a Stripe
        document.getElementById('payment-form').addEventListener('submit', function() {
            const btn = document.getElementById('btn-pay');
            const btnText = document.getElementById('btn-text');
            const loader = document.getElementById('pay-loader');

            btn.disabled = true;
            btnText.innerText = 'Redirecting...';
            loader.style.display = 'block';
        });

        // 10 minutos en milisegundos
        const TIME_LIMIT = 10 * 60 * 1000; 

        // Revisamos si ya hay un tiempo guardado en la sesión
        let endTime = sessionStorage.getItem('booking_end_time');

        // Si no lo hay (es la primera vez que entra a la página de comida), lo creamos
        if (!endTime) {
            endTime = Date.now() + TIME_LIMIT;
            sessionStorage.setItem('booking_end_time', endTime);
        }

        function updateTimer() {
            const now = Date.now();
            const timeLeft = Math.max(0, endTime - now);
            
            // Calculamos minutos y segundos
            const minutes = Math.floor((timeLeft / 1000) / 60);
            const seconds = Math.floor((timeLeft / 1000) % 60);
            
            // Lo mostramos en formato MM:SS
            document.getElementById('timer-display').innerText = 
                String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');

            // Efecto visual: Si quedan menos de 2 minutos, se pone en rojo
            if (timeLeft <= 120000) {
                document.getElementById('countdown-widget').style.backgroundColor = '#ff4444';
                document.getElementById('countdown-widget').style.color = 'white';
            }

            // Si el tiempo se acaba
            if (timeLeft <= 0) {
                clearInterval(timerInterval);
                sessionStorage.removeItem('booking_end_time'); // Limpiamos la sesión
                
                // Avisamos al usuario y lo mandamos de vuelta a la cartelera
                Swal.fire({
                    title: 'TIME EXPIRED',
                    text: 'Your reservation time has ended. The seats have been released.',
                    icon: 'error',
                    background: '#141414',
                    color: '#ffffff',
                    confirmButtonColor: 'var(--color-principal)',
                    confirmButtonText: '<span style="color: var(--color-texto-btn); font-weight: bold;">START AGAIN</span>',
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "/";
                    }
                });
            }
        }

        // Actualizamos cada segundo
        const timerInterval = setInterval(updateTimer, 1000);
        updateTimer(); // Llamada inicial para que no tarde 1 segundo en aparecer
    </script>
</body>
</html>