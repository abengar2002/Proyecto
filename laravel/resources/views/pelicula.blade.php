<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cine Screenbites - {{ $movie['title'] }}</title>
    <style>
        :root {
            --color-negro: #000000;
            --color-gris-oscuro: #0a0a0a;
            --color-gris-claro: #333333;
            --color-blanco: #ffffff;
            --color-amarillo: #ffd000;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Arial Black', 'Arial Bold', sans-serif; background-color: var(--color-negro); color: var(--color-blanco); }

        /* HEADER IDENTICO AL INDEX */
        header { position: fixed; top: 0; left: 0; right: 0; display: flex; justify-content: space-between; align-items: center; padding: 0 5%; height: 100px; z-index: 1000; background-color: transparent; border-bottom: 1px solid transparent; transition: background-color 0.3s ease, border-bottom 0.3s ease; }
        header.scrolled { background-color: rgba(0, 0, 0, 0.95); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(255, 255, 255, 0.05); }
        header .logo img { height: 50px; }
        header nav ul { list-style: none; display: flex; align-items: center; gap: 30px; }
        header nav a, .logout-btn { text-decoration: none; color: var(--color-blanco); text-transform: uppercase; font-size: 13px; font-weight: 900; letter-spacing: 2px; transition: color 0.3s ease, transform 0.2s ease; background: none; border: none; cursor: pointer; padding: 0; display: flex; align-items: center; gap: 8px; }
        header nav a:hover, .logout-btn:hover { color: var(--color-amarillo) !important; transform: scale(1.05); }
        .user-nav { display: flex; align-items: center; gap: 20px; border-left: 2px solid rgba(255,255,255,0.2); padding-left: 20px; margin-left: 10px; }

        /* BACKDROP GIGANTE TIPO NETFLIX */
        .movie-hero {
            position: relative;
            width: 100%;
            min-height: 80vh;
            display: flex;
            align-items: center;
            padding: 120px 5% 50px;
        }

        .backdrop-img {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            object-fit: cover;
            object-position: top;
            z-index: 1;
            opacity: 0.3; /* Oscurecemos la foto de fondo */
            filter: blur(5px); /* Le damos un toque borroso */
        }

        .backdrop-gradient {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(to top, var(--color-negro) 0%, transparent 100%);
            z-index: 2;
        }

        /* CONTENIDO DE LA PELÍCULA */
        .movie-content {
            position: relative;
            z-index: 10;
            display: flex;
            gap: 50px;
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
            align-items: center;
        }

        .movie-poster {
            width: 300px;
            border-radius: 8px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.8);
            border: 2px solid var(--color-amarillo);
        }

        .movie-info { flex: 1; }
        .movie-id { color: var(--color-amarillo); font-size: 20px; letter-spacing: 5px; margin-bottom: 10px; display: block; }
        .movie-title { font-size: 60px; margin: 0 0 15px 0; text-transform: uppercase; line-height: 1; text-shadow: 2px 2px 10px rgba(0,0,0,0.8); }
        .movie-meta { display: flex; gap: 15px; align-items: center; font-family: Arial, sans-serif; font-size: 14px; margin-bottom: 30px; color: #ddd; }
        .age-badge { border: 1px solid currentColor; padding: 2px 6px; border-radius: 4px; font-weight: bold; }
        .movie-desc { font-family: Arial, sans-serif; line-height: 1.8; color: #ccc; margin-bottom: 40px; font-size: 18px; max-width: 700px; }

        .btn-buy { background: var(--color-amarillo); color: var(--color-negro); padding: 15px 40px; font-size: 14px; font-weight: 900; text-transform: uppercase; border: none; border-radius: 4px; cursor: pointer; letter-spacing: 1px; transition: background 0.2s; display: inline-flex; align-items: center; gap: 10px; }
        .btn-buy:hover { background: var(--color-blanco); }
        .btn-back { background: transparent; color: var(--color-blanco); padding: 15px 40px; font-size: 14px; font-weight: 900; text-transform: uppercase; border: 2px solid var(--color-blanco); border-radius: 4px; cursor: pointer; letter-spacing: 1px; transition: background 0.2s; text-decoration: none; margin-left: 15px; }
        .btn-back:hover { background: var(--color-blanco); color: var(--color-negro); }

        /* FOOTER IDENTICO */
        footer { background-color: var(--color-negro); padding: 60px 5% 40px; border-top: 1px solid var(--color-gris-claro); margin-top: 50px; }
        .footer-content { display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 40px; max-width: 1200px; margin: 0 auto; }
        .footer-col { flex: 1; min-width: 200px; }
        .footer-logo img { height: 45px; margin-bottom: 20px; }
        .footer-col p { font-family: Arial, sans-serif; color: #888; font-size: 13px; line-height: 1.6; }
        .footer-col h4 { font-size: 16px; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 20px; color: var(--color-amarillo); }
        .footer-links { list-style: none; }
        .footer-links li { margin-bottom: 10px; }
        .footer-links a { color: var(--color-blanco); text-decoration: none; font-family: Arial, sans-serif; font-size: 14px; transition: color 0.3s ease; }
        .footer-links a:hover { color: var(--color-amarillo); }
        .footer-bottom { max-width: 1200px; margin: 40px auto 0; padding-top: 20px; border-top: 1px solid var(--color-gris-claro); display: flex; justify-content: space-between; align-items: center; font-family: Arial, sans-serif; font-size: 12px; color: #666; }

    </style>
</head>

<body>

    <header id="main-header">
        <div class="logo">
            <a href="/"><img src="{{ asset('img/img/Logo-Blanco.png') }}" alt="Cine Logo"></a>
        </div>
        <nav>
            <ul>
                <li><a href="/">HOME</a></li>
                <li><a href="/#cartelera">FILMS</a></li>
                <li><a href="/#bar">MENUS</a></li>
                
                @auth
                    <div class="user-nav">
                        <li>
                            <a href="#" class="user-name" title="Mi Perfil">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                {{ strtoupper(Auth::user()->name) }}
                            </a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                @csrf
                                <button type="submit" class="logout-btn" title="Cerrar Sesión">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                </button>
                            </form>
                        </li>
                    </div>
                @else
                    <div class="user-nav">
                        <li>
                            <a href="{{ route('login') }}" title="Iniciar Sesión">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline><line x1="15" y1="12" x2="3" y2="12"></line></svg>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('register') }}" title="Crear Cuenta">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><line x1="19" y1="8" x2="19" y2="14"></line><line x1="22" y1="11" x2="16" y2="11"></line></svg>
                            </a>
                        </li>
                    </div>
                @endauth
            </ul>
        </nav>
    </header>

    <div class="movie-hero">
        <img src="{{ asset($movie['bgImg']) }}" class="backdrop-img" onerror="this.src='https://via.placeholder.com/1920x1080/111/ffd000?text=Fondo'">
        <div class="backdrop-gradient"></div>

        <div class="movie-content">
            <img src="{{ asset($movie['poster']) }}" class="movie-poster" onerror="this.src='https://via.placeholder.com/350x500/111/ffd000?text=Poster'">
            
            <div class="movie-info">
                <span class="movie-id">TICKET #{{ $id }}</span>
                <h1 class="movie-title">{{ $movie['title'] }}</h1>
                
                <div class="movie-meta">
                    <span class="age-badge">{{ $movie['age'] }}</span>
                    <span>{{ $movie['genre'] }}</span>
                    <span>2h 15m</span>
                </div>

                <p class="movie-desc">{{ $movie['desc'] }}</p>
                
                <div>
                    @auth
                        <button class="btn-buy" onclick="alert('Funcionalidad de Compra Directa en desarrollo')">
                            <img src="{{ asset('img/img/Ticket-amarillo.png') }}" style="width:20px; filter: invert(1);"> COMPRAR ENTRADAS - $8.50
                        </button>
                    @else
                        <button class="btn-buy" onclick="window.location.href='/login'">
                            <img src="{{ asset('img/img/Ticket-amarillo.png') }}" style="width:20px; filter: invert(1);"> INICIA SESIÓN PARA COMPRAR
                        </button>
                    @endauth

                    <a href="/" class="btn-back">VOLVER A CARTELERA</a>
                </div>
            </div>
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
            <p>&copy; 2024 Cine Screenbites. All rights reserved.</p>
            <p>Designed with ❤️ for the final project</p>
        </div>
    </footer>

    <script>
        // Script para que el menú se ponga negro al bajar (igual que en index)
        window.addEventListener('scroll', () => {
            const headerEl = document.getElementById('main-header');
            if (window.scrollY > 50) {
                headerEl.classList.add('scrolled');
            } else {
                headerEl.classList.remove('scrolled');
            }
        });
    </script>

</body>
</html>