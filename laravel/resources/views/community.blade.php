<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community - Screenbites</title>
    <style>
        :root {
            --color-negro: #000000;
            --color-gris-oscuro: #0a0a0a;
            --color-gris-tarjeta: #141414;
            --color-gris-claro: #333333;
            --color-blanco: #ffffff;
            --color-amarillo: #ffd000;
            --color-corazon: #ff4444; 
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body { 
            font-family: 'Arial Black', 'Arial Bold', sans-serif; 
            background-color: var(--color-negro); 
            color: var(--color-blanco); 
            min-height: 100vh; 
            overflow-x: hidden;
        }

        /* --- HEADER (TUS ESTILOS COMPILADOS CORRECTAMENTE) --- */
        header {
            position: fixed; top: 0; left: 0; right: 0; display: flex; justify-content: space-between; align-items: center;
            padding: 0 5% 0 3%; height: 100px; z-index: 1000; background-color: transparent;
            border-bottom: 1px solid transparent; transition: background-color 0.3s ease, box-shadow 0.3s ease, border-bottom 0.3s ease;
        }
        header.scrolled {
            background-color: rgba(0, 0, 0, 0.95); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.8); border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        header.scrolled nav a:not(.active), header.scrolled nav .logout-btn, header.scrolled .user-profile .user-name, header.scrolled .user-profile .chevron-icon {
            color: var(--color-blanco) !important; text-shadow: none !important; 
        }
        .logo img { height: 60px; }
        nav ul { list-style: none; display: flex; align-items: center; gap: 30px; }
        nav a, .logout-btn {
            text-decoration: none; color: var(--header-text-color, var(--color-blanco)); text-transform: uppercase;
            font-size: 13px; font-weight: 900; letter-spacing: 2px; text-shadow: 0 2px 4px rgba(0, 0, 0, 0.6);
            transition: color 0.3s ease, transform 0.2s ease, text-shadow 0.3s ease; background: none; border: none;
            cursor: pointer; padding: 0; display: flex; align-items: center; gap: 8px;
        }
        nav a:hover, .logout-btn:hover {
            color: var(--color-amarillo) !important; transform: scale(1.05);
            text-shadow: 0px 2px 10px rgba(0, 0, 0, 1), 0px 0px 4px rgba(0, 0, 0, 1) !important;
        }
        
        /* CLASE ACTIVA PARA MANTENER EL AMARILLO SIEMPRE */
        nav a.active {
            color: var(--color-amarillo) !important;
        }

        .user-nav { display: flex; align-items: center; gap: 20px; border-left: 2px solid rgba(255, 255, 255, 0.4); padding-left: 20px; margin-left: 10px; }
        .user-profile { display: flex; align-items: center; gap: 10px; color: var(--header-text-color, var(--color-blanco)); transition: color 0.3s ease; }
        .user-profile .user-avatar {
            width: 35px; height: 35px; border-radius: 50%; object-fit: cover; border: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        }
        .user-profile .user-name, .user-profile .chevron-icon { color: var(--header-text-color, var(--color-blanco)); transition: color 0.3s ease, text-shadow 0.3s ease; }
        .user-profile .chevron-icon { width: 16px; height: 16px; }
        .user-profile:hover .user-avatar { transform: scale(1.1); box-shadow: 0 4px 12px rgba(0, 0, 0, 0.9); }
        .user-profile:hover .user-name, .user-profile:hover .chevron-icon {
            color: var(--color-amarillo) !important; text-shadow: 0px 2px 10px rgba(0, 0, 0, 1), 0px 0px 4px rgba(0, 0, 0, 1) !important;
        }

        /* --- COMMUNITY HERO --- */
        .community-hero { padding: 150px 5% 40px; background: linear-gradient(180deg, #111 0%, var(--color-negro) 100%); border-bottom: 1px solid var(--color-gris-claro); text-align: center; }
        .community-hero h1 { font-size: 45px; text-transform: uppercase; letter-spacing: -1px; margin-bottom: 10px; text-shadow: 2px 2px 10px rgba(0,0,0,0.8); }
        .community-hero h1 span { color: var(--color-amarillo); }
        .community-hero p { font-family: Arial, sans-serif; color: #aaa; font-size: 16px; max-width: 600px; margin: 0 auto; }

        /* --- LAYOUT DEL FORO --- */
        .forum-wrapper { display: grid; grid-template-columns: 1fr 350px; gap: 40px; max-width: 1300px; margin: 40px auto; padding: 0 5%; }
        @media (max-width: 900px) { .forum-wrapper { grid-template-columns: 1fr; } .trending-sidebar { display: none; } }

        .feed { min-width: 0; } /* FIX para que el carrusel no estalle la pantalla */

        /* --- CAJA DE PUBLICAR --- */
        .compose-box { background-color: var(--color-gris-tarjeta); border: 1px solid var(--color-gris-claro); border-radius: 8px; padding: 20px; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
        .compose-top { display: flex; gap: 15px; margin-bottom: 15px; }
        .compose-avatar { width: 50px; height: 50px; border-radius: 50%; object-fit: cover; border: 1px solid var(--color-gris-claro); }
        .compose-form { flex: 1; min-width: 0; }
        .compose-title { width: 100%; background: transparent; border: none; color: #fff; font-size: 22px; font-weight: 900; outline: none; margin-bottom: 5px; font-family: 'Arial Black', sans-serif; text-transform: uppercase; }
        .compose-title::placeholder { color: #555; }
        .compose-input { width: 100%; background: transparent; border: none; color: #fff; font-family: Arial, sans-serif; font-size: 16px; resize: none; outline: none; min-height: 40px; }
        .compose-input::placeholder { color: #555; font-weight: bold; }
        
        .movie-chips-container { display: flex; gap: 10px; overflow-x: auto; padding: 10px 0; margin-top: 5px; max-width: 100%; scrollbar-width: thin; scrollbar-color: #444 transparent; }
        .movie-chips-container::-webkit-scrollbar { height: 6px; }
        .movie-chips-container::-webkit-scrollbar-thumb { background: #444; border-radius: 10px; }
        .movie-chip { cursor: pointer; flex-shrink: 0; }
        .movie-chip input { display: none; }
        .movie-chip .chip-content { display: flex; align-items: center; gap: 8px; padding: 4px 12px 4px 4px; background: #000; border: 1px solid var(--color-gris-claro); border-radius: 30px; transition: 0.2s; font-size: 12px; font-weight: bold; color: #aaa; font-family: Arial, sans-serif; }
        .movie-chip .chip-content img { width: 26px; height: 26px; border-radius: 50%; object-fit: cover; }
        
        /* AQUÍ ESTÁ LA MODIFICACIÓN DE COLOR DINÁMICA DEL CHIP */
        .movie-chip input:checked + .chip-content { background: rgba(255,255,255,0.05); border-color: var(--chip-color, var(--color-amarillo)); color: var(--color-blanco); }

        .compose-tools { display: flex; justify-content: flex-end; align-items: center; border-top: 1px dashed var(--color-gris-claro); padding-top: 15px; margin-top: 10px; }
        .btn-submit { background: var(--color-amarillo); color: var(--color-negro); padding: 10px 25px; border: none; border-radius: 30px; font-weight: 900; font-size: 13px; text-transform: uppercase; cursor: pointer; transition: transform 0.2s, background 0.2s; letter-spacing: 1px; }
        .btn-submit:hover { background: #fff; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(255,255,255,0.2); }

        /* --- POSTS (TARJETAS) --- */
        .post-card { background-color: var(--color-gris-oscuro); border: 1px solid var(--color-gris-claro); border-radius: 8px; margin-bottom: 20px; padding: 20px; transition: border-color 0.3s; }
        .post-card:hover { border-color: #444; }

        .post-header { display: flex; align-items: center; gap: 10px; margin-bottom: 12px; }
        .post-avatar-img { width: 35px; height: 35px; border-radius: 50%; object-fit: cover; border: 1px solid var(--color-gris-claro); }
        .post-author { font-size: 15px; color: var(--color-amarillo); letter-spacing: 0.5px; text-transform: lowercase; }
        .post-time { font-family: Arial, sans-serif; color: #666; font-size: 13px; margin-left: auto; }

        .post-title { font-family: 'Arial Black', sans-serif; font-size: 18px; color: #fff; line-height: 1.2; margin-bottom: 8px; text-transform: uppercase; }
        .post-text { font-family: Arial, sans-serif; font-size: 16px; line-height: 1.6; color: #ddd; margin-bottom: 20px; }

        .movie-embed { display: flex; align-items: center; gap: 15px; background: var(--color-negro); border: 1px solid var(--color-gris-claro); border-radius: 6px; padding: 12px; margin-bottom: 20px; text-decoration: none; transition: 0.2s; cursor: pointer; width: fit-content; padding-right: 20px; border-left-width: 3px; }
        
        /* AQUÍ ESTÁ LA MODIFICACIÓN DE COLOR DINÁMICO AL HACER HOVER EN EL EMBED */
        .movie-embed:hover { border-color: var(--movie-color, var(--color-amarillo)); background: rgba(255,255,255,0.02); }
        
        .movie-embed-poster { width: 40px; height: 60px; border-radius: 4px; object-fit: cover; box-shadow: 0 4px 10px rgba(0,0,0,0.5); }
        .movie-embed-info { display: flex; flex-direction: column; }
        .movie-embed-label { font-family: Arial, sans-serif; font-size: 11px; color: #888; text-transform: uppercase; font-weight: bold; margin-bottom: 4px; display: flex; align-items: center; gap: 5px; }
        
        /* AQUÍ QUITAMOS EL AMARILLO POR DEFECTO PARA QUE COJA EL QUE LE PASAMOS DESDE HTML */
        .movie-embed-label svg { width: 14px; height: 14px; }
        
        .movie-embed-title { font-size: 15px; text-transform: uppercase; color: #fff; letter-spacing: 0.5px; }

        /* ACTION BAR (CORAZÓN Y RESPUESTA ALINEADOS) */
        .action-bar { display: flex; gap: 25px; align-items: center; margin-top: 5px; }
        .action-btn { background: transparent; border: none; color: #888; font-size: 13px; font-weight: 900; display: flex; align-items: center; gap: 8px; cursor: pointer; transition: color 0.2s; text-transform: uppercase; }
        .action-btn svg { width: 22px; height: 22px; stroke-width: 2.5; transition: transform 0.2s; }
        .action-btn:hover { color: var(--color-blanco); }
        .action-btn.like:hover { color: var(--color-corazon); }
        .action-btn.like:hover svg { transform: scale(1.1); }
        .action-btn.like.active { color: var(--color-corazon); }
        .action-btn.like.active svg { fill: var(--color-corazon); stroke: var(--color-corazon); }

        /* --- RESPUESTAS ESTILO CAJITAS --- */
        .replies-wrapper { display: flex; flex-direction: column; gap: 12px; margin-top: 20px; }
        .reply-item { background: #111; padding: 15px; border-radius: 8px; border: 1px solid var(--color-gris-claro); border-left: 4px solid var(--color-amarillo); display: flex; flex-direction: column; }
        .reply-header { display: flex; align-items: center; gap: 10px; margin-bottom: 8px; }
        .reply-avatar { width: 28px; height: 28px; border-radius: 50%; object-fit: cover; }
        .reply-author { font-size: 13px; color: var(--color-amarillo); font-weight: bold; }
        .reply-time { font-family: Arial, sans-serif; font-size: 12px; color: #666; margin-left: auto; }
        .reply-text { font-family: Arial, sans-serif; font-size: 15px; color: #ccc; line-height: 1.5; padding-left: 38px; margin-bottom: 10px; }
        
        /* Corazones en las respuestas */
        .reply-actions { padding-left: 38px; display: flex; }
        .reply-actions .action-btn svg { width: 18px; height: 18px; }

        /* Input de respuesta */
        .reply-input-box { display: none; margin-top: 15px; }
        .reply-input-wrapper { display: flex; gap: 10px; align-items: center; }
        .reply-input { flex: 1; background: #000; border: 1px solid var(--color-gris-claro); color: #fff; padding: 12px 15px; border-radius: 30px; font-family: Arial, sans-serif; outline: none; font-size: 14px; transition: 0.2s; }
        .reply-input:focus { border-color: var(--color-amarillo); }
        .btn-reply { background: var(--color-blanco); color: var(--color-negro); border: none; padding: 10px 25px; border-radius: 30px; font-weight: 900; text-transform: uppercase; cursor: pointer; transition: 0.2s; font-size: 12px; }
        .btn-reply:hover { background: var(--color-amarillo); }

        /* --- SIDEBAR TRENDING --- */
        .trending-sidebar { display: flex; flex-direction: column; gap: 20px; position: sticky; top: 130px; height: fit-content; }
        .widget-box { background: var(--color-gris-oscuro); border: 1px solid var(--color-gris-claro); border-radius: 8px; overflow: hidden; }
        .widget-title { padding: 15px 20px; font-size: 16px; text-transform: uppercase; border-bottom: 1px solid var(--color-gris-claro); color: var(--color-amarillo); display: flex; align-items: center; gap: 10px; letter-spacing: 1px; }
        .widget-title svg { width: 22px; height: 22px; }
        
        .trending-movie { display: flex; align-items: center; gap: 15px; padding: 15px 20px; border-bottom: 1px solid #1a1a1a; text-decoration: none; transition: background 0.2s; }
        .trending-movie:hover { background: var(--color-negro); }
        .trending-movie:last-child { border-bottom: none; }
        .trending-movie img { width: 50px; height: 75px; border-radius: 4px; object-fit: cover; box-shadow: 0 4px 10px rgba(0,0,0,0.5); }
        .trending-movie-info { display: flex; flex-direction: column; }
        .trending-movie-name { font-size: 15px; color: #fff; text-transform: uppercase; margin-bottom: 6px; letter-spacing: 0.5px; }
        .trending-movie-stats { font-family: Arial, sans-serif; font-size: 13px; color: #888; display: flex; align-items: center; gap: 5px; }
        .trending-movie-stats svg { width: 14px; height: 14px; color: var(--color-amarillo); }

        /* ALERTAS */
        .alert { padding: 15px 20px; border-radius: 6px; margin-bottom: 20px; font-size: 14px; display: flex; align-items: center; gap: 12px; border: 1px solid transparent; font-family: Arial, sans-serif; font-weight: bold; }
        .alert-success { background: rgba(255,208,0,0.1); color: var(--color-amarillo); border-color: var(--color-amarillo); }
        .alert-error { background: rgba(255,0,0,0.1); color: #ff4444; border-color: #ff4444; }

        /* FOOTER ORIGINAL */
        footer { background-color: var(--color-negro); padding: 60px 5% 40px; border-top: 1px solid var(--color-gris-claro); margin-top: 50px; }
        .footer-content { display: flex; justify-content: space-between; flex-wrap: wrap; gap: 40px; max-width: 1200px; margin: 0 auto; }
        .footer-col { flex: 1; min-width: 200px; }
        .footer-col:first-child { display: flex; flex-direction: column; align-items: center; text-align: center; }
        .footer-logo img { height: 60px; margin-bottom: 20px; display: block; }
        .footer-col p { font-family: Arial, sans-serif; color: #888; font-size: 13px; line-height: 1.6; max-width: 250px; }
        .footer-col h4 { font-size: 16px; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 20px; color: var(--color-amarillo); }
        .footer-links { list-style: none; }
        .footer-links li { margin-bottom: 10px; }
        .footer-links a { color: var(--color-blanco); text-decoration: none; font-family: Arial, sans-serif; font-size: 14px; transition: color 0.3s ease; }
        .footer-links a:hover { color: var(--color-amarillo); }
        .footer-bottom { max-width: 1200px; margin: 40px auto 0; padding-top: 20px; border-top: 1px solid var(--color-gris-claro); display: flex; justify-content: space-between; align-items: center; font-family: Arial, sans-serif; font-size: 12px; color: #666; }
        .footer-credits { display: flex; align-items: center; gap: 8px; color: #888; }
        .footer-credits span { color: var(--color-amarillo); font-weight: bold; }
        .heart-icon { width: 16px; height: 16px; color: #888; transition: color 0.3s ease; }
        .footer-credits:hover .heart-icon { color: #ff4444; filter: drop-shadow(0 0 3px #ff4444); }
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
                <li><a href="/community" class="active">COMMUNITY</a></li>

                @auth
                <div class="user-nav">
                    <li>
                        <a href="/profile" class="user-profile" title="My Profile">
                            <img src="{{ asset('img/avatars/' . Auth::user()->avatar) }}" alt="Avatar" class="user-avatar" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=222&color=ffd000&bold=true'">
                            <span class="user-name">{{ strtoupper(Auth::user()->name) }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="chevron-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="logout-btn" title="Sign Out">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                                <polyline points="10 17 15 12 10 7"></polyline>
                                <line x1="15" y1="12" x2="3" y2="12"></line>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('register') }}" title="Create Account">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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

    <div class="community-hero">
        <h1>Screenbites <span>Community</span></h1>
        <p>The stage is yours. Share your theories, review the latest releases, and connect with other cinephiles.</p>
    </div>

    <div class="forum-wrapper">
        
        <div class="feed">
            @if(session('status'))
                <div class="alert alert-success">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    {{ session('status') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                    {{ session('error') }}
                </div>
            @endif

            <div class="compose-box">
                @auth
                    <div class="compose-top">
                        <img src="{{ asset('img/avatars/' . Auth::user()->avatar) }}" class="compose-avatar" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=222&color=ffd000&bold=true'">
                        <form class="compose-form" action="{{ route('community.post') }}" method="POST">
                            @csrf
                            
                            <input type="text" name="post_title" class="compose-title" placeholder="Give your post a catchy title..." required autocomplete="off">
                            <textarea name="content" class="compose-input" required placeholder="What's your verdict on the latest movie?" oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px'"></textarea>
                            
                            <div class="movie-chips-container">
                                @foreach($movies as $id => $movie)
                                    <label class="movie-chip" style="--chip-color: {{ $movie['color'] ?? '#ffd000' }};">
                                        <input type="radio" name="movie_id" value="{{ $id }}" required>
                                        <div class="chip-content">
                                            <img src="{{ $movie['poster'] }}" onerror="this.src='https://via.placeholder.com/24x24/111/333?text=+'">
                                            {{ $movie['title'] }}
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            
                            <div class="compose-tools">
                                <button type="submit" class="btn-submit">Publish</button>
                            </div>
                        </form>
                    </div>
                @else
                    <div style="text-align: center; padding: 20px; font-family: Arial, sans-serif; color: #888;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 10px; opacity: 0.5;"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                        <br>
                        You must <a href="{{ route('login') }}" style="color: var(--color-amarillo); font-weight: bold; text-decoration: none;">log in</a> to join the conversation.
                    </div>
                @endauth
            </div>

            @forelse($posts as $post)
                @php
                    $handle = '@' . strtolower(str_replace(' ', '', $post['author']));
                @endphp
                <div class="post-card">
                    <div class="post-header">
                        <img src="{{ $post['avatar'] }}" class="post-avatar-img" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($post['author']) }}&background=222&color=ffd000&bold=true'">
                        <span class="post-author">{{ $handle }}</span>
                        <span class="post-time">{{ $post['date'] }}</span>
                    </div>

                    @if(!empty($post['post_title']))
                        <h3 class="post-title">{{ $post['post_title'] }}</h3>
                    @endif
                    <p class="post-text">{{ $post['content'] }}</p>

                    @if($post['movie_info'])
                        <div class="movie-embed" onclick="window.location.href='/pelicula/{{ $post['movie_info']['id'] }}'" style="border-left-color: {{ $post['movie_info']['color'] }}; --movie-color: {{ $post['movie_info']['color'] }};">
                            <img src="{{ $post['movie_info']['poster'] ?? 'https://via.placeholder.com/40x60/111/333?text=Film' }}" class="movie-embed-poster" onerror="this.src='https://via.placeholder.com/40x60/111/333?text=Film'">
                            <div class="movie-embed-info">
                                <span class="movie-embed-label">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="color: {{ $post['movie_info']['color'] ?? '#ffd000' }};"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                                    Talking about
                                </span>
                                <span class="movie-embed-title" style="color: {{ $post['movie_info']['color'] }};">{{ $post['movie_info']['title'] }}</span>
                            </div>
                        </div>
                    @endif

                    <div class="action-bar">
                        <button class="action-btn like {{ $post['has_liked'] ? 'active' : '' }}" onclick="likePost(this, {{ $post['id'] ?? 0 }})">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                            <span class="vote-count">{{ $post['likes'] }}</span>
                        </button>

                        <button class="action-btn reply" onclick="toggleReplyBox({{ $post['id'] }})">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                            {{ count($post['replies']) }} Replies
                        </button>
                    </div>

                    @auth
                    <div id="reply-box-{{ $post['id'] }}" class="reply-input-box">
                        <form action="{{ route('community.post') }}" method="POST" class="reply-input-wrapper">
                            @csrf
                            <input type="hidden" name="parent_id" value="{{ $post['id'] }}">
                            <input type="hidden" name="movie_id" value="{{ $post['movie_id'] }}">
                            <input type="text" name="content" required placeholder="Add to the discussion..." class="reply-input" autocomplete="off">
                            <button type="submit" class="btn-reply">Reply</button>
                        </form>
                    </div>
                    @endauth

                    @if(count($post['replies']) > 0)
                    <div class="replies-wrapper">
                        @foreach($post['replies'] as $reply)
                            @php $rHandle = '@' . strtolower(str_replace(' ', '', $reply['author'])); @endphp
                            <div class="reply-item">
                                <div class="reply-header">
                                    <img src="{{ $reply['avatar'] }}" class="reply-avatar" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($reply['author']) }}&background=222&color=ffd000&bold=true'">
                                    <span class="reply-author">{{ $rHandle }}</span>
                                    <span class="reply-time">{{ $reply['date'] }}</span>
                                </div>
                                <p class="reply-text">{{ $reply['content'] }}</p>
                                
                                <div class="reply-actions">
                                    <button class="action-btn like {{ $reply['has_liked'] ? 'active' : '' }}" onclick="likePost(this, {{ $reply['id'] ?? 0 }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                                        <span class="vote-count" style="margin-left: 5px;">{{ $reply['likes'] > 0 ? $reply['likes'] : '' }}</span>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @endif

                </div>
            @empty
                <div style="padding: 80px 20px; text-align: center; color: #555;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 15px; opacity: 0.5;"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                    <h2>It's quiet in here...</h2>
                    <p style="font-family: Arial, sans-serif;">Be the first to drop a review.</p>
                </div>
            @endforelse

        </div>

        <aside class="trending-sidebar">
            <div class="widget-box">
                <div class="widget-title">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                    Trending Topics
                </div>
                
                @forelse($trendingMovies as $trending)
                    <a href="/pelicula/{{ $trending['id'] }}" class="trending-movie">
                        <img src="{{ $trending['poster'] ?? 'https://via.placeholder.com/45x65/111/333?text=Film' }}" onerror="this.src='https://via.placeholder.com/45x65/111/333?text=Film'">
                        <div class="trending-movie-info">
                            <span class="trending-movie-name" style="color: {{ $trending['color'] ?? '#fff' }}">{{ $trending['title'] }}</span>
                            <span class="trending-movie-stats">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                {{ $trending['post_count'] }} discussions
                            </span>
                        </div>
                    </a>
                @empty
                    <div style="padding: 20px; font-family: Arial, sans-serif; font-size: 13px; color: #666; text-align: center;">
                        No trends right now. Start posting!
                    </div>
                @endforelse
            </div>
        </aside>

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
        document.addEventListener('scroll', function() {
            const header = document.getElementById('main-header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        function toggleReplyBox(id) {
            const box = document.getElementById('reply-box-' + id);
            if (box) {
                if (box.style.display === 'none' || box.style.display === '') {
                    box.style.display = 'block';
                    box.querySelector('input').focus();
                } else {
                    box.style.display = 'none';
                }
            }
        }

        function likePost(buttonElement, postId) {
            if (postId === 0) return; 
            
            let countSpan = buttonElement.querySelector('.vote-count');
            let currentLikes = parseInt(countSpan.innerText) || 0;
            let isCurrentlyLiked = buttonElement.classList.contains('active');

            if (isCurrentlyLiked) {
                buttonElement.classList.remove('active');
                countSpan.innerText = (currentLikes - 1) > 0 ? (currentLikes - 1) : '0';
            } else {
                buttonElement.classList.add('active');
                countSpan.innerText = currentLikes + 1;
            }

            fetch(`/api/community/like/${postId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    countSpan.innerText = data.likes;
                    if (data.is_liked) buttonElement.classList.add('active');
                    else buttonElement.classList.remove('active');
                } else {
                    if (isCurrentlyLiked) buttonElement.classList.add('active');
                    else buttonElement.classList.remove('active');
                    countSpan.innerText = currentLikes;
                }
            })
            .catch(error => { console.error(error); });
        }
    </script>
</body>
</html>