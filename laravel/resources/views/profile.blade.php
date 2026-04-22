<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Screenbites Cinema - My Profile</title>
    <link rel="stylesheet" href="{{ asset('css/webbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">

    <style>
        :root {
            --color-negro: #000000;
            --color-gris-oscuro: #0a0a0a;
            --color-gris-tarjeta: #141414;
            --color-gris-claro: #333333;
            --color-blanco: #ffffff;
            --color-amarillo: #ffd000;
        }

        html {
            scroll-behavior: smooth;
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

            &.menu-open {
                overflow: hidden;
            }
        }

        /* Ocultar el icono hamburguesa y el menú móvil en escritorio por defecto */
        #nav-icon, .menu_mobile {
            display: none;
        }

        /* --- HEADER (CON NESTING Y CLAMPS) --- */
        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 clamp(3%, 5vw, 5%);
            height: clamp(70px, 8vw, 100px);
            z-index: 1000;
            background-color: rgba(0, 0, 0, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            transition: background-color 0.3s ease, box-shadow 0.3s ease, border-bottom 0.3s ease;

            &.scrolled {
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.8);
            }

            .logo {
                img {
                    height: clamp(40px, 5vw, 60px);
                    transition: height 0.3s ease;
                }
            }

            nav.desktop-nav {
                ul {
                    list-style: none;
                    display: flex;
                    align-items: center;
                    gap: clamp(15px, 2vw, 30px);
                }

                a, .logout-btn {
                    text-decoration: none;
                    color: var(--header-text-color, var(--color-blanco));
                    text-transform: uppercase;
                    font-size: clamp(11px, 1vw, 13px);
                    font-weight: 900;
                    letter-spacing: 2px;
                    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.6);
                    transition: color 0.3s ease, transform 0.2s ease, text-shadow 0.3s ease;
                    background: none;
                    border: none;
                    cursor: pointer;
                    padding: 0;
                    display: flex;
                    align-items: center;
                    gap: 8px;

                    &:hover {
                        color: var(--color-amarillo) !important;
                        transform: scale(1.05);
                        text-shadow: 0px 2px 10px rgba(0, 0, 0, 1), 0px 0px 4px rgba(0, 0, 0, 1) !important;
                    }
                }
            }

            .user-nav {
                display: flex;
                align-items: center;
                gap: 20px;
                border-left: 2px solid rgba(255, 255, 255, 0.4);
                padding-left: clamp(10px, 1.5vw, 20px);
                margin-left: clamp(5px, 1vw, 10px);

                .user-profile {
                    display: flex;
                    align-items: center;
                    gap: 10px;
                    color: var(--header-text-color, var(--color-blanco));
                    transition: color 0.3s ease;

                    .user-avatar {
                        width: clamp(28px, 3vw, 35px);
                        height: clamp(28px, 3vw, 35px);
                        border-radius: 50%;
                        object-fit: cover;
                        border: none;
                        transition: transform 0.3s ease, box-shadow 0.3s ease;
                        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
                    }

                    .user-name,
                    .chevron-icon {
                        color: var(--color-amarillo);
                        transition: color 0.3s ease, text-shadow 0.3s ease;
                    }

                    .chevron-icon {
                        width: clamp(14px, 1.5vw, 16px);
                        height: clamp(14px, 1.5vw, 16px);
                    }

                    &:hover {
                        .user-avatar {
                            transform: scale(1.1);
                            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.9);
                        }
                        .user-name,
                        .chevron-icon {
                            text-shadow: 0px 2px 10px rgba(0, 0, 0, 1), 0px 0px 4px rgba(0, 0, 0, 1) !important;
                        }
                    }
                }
            }
        }

        /* --- PROFILE DASHBOARD (CON CLAMPS Y NESTING) --- */
        .profile-container {
            max-width: 1200px;
            margin: clamp(100px, 15vw, 150px) auto clamp(60px, 10vw, 100px);
            padding: 0 clamp(3%, 5vw, 5%);
            display: flex;
            gap: clamp(20px, 4vw, 40px);

            .profile-sidebar {
                width: clamp(200px, 25vw, 250px);
                flex-shrink: 0;

                .user-header {
                    display: flex; 
                    align-items: center; 
                    gap: clamp(10px, 1.5vw, 15px);
                    margin-bottom: clamp(20px, 4vw, 40px); 
                    padding-bottom: clamp(10px, 2vw, 20px);
                    border-bottom: 1px solid var(--color-gris-claro);

                    .main-avatar { 
                        width: clamp(50px, 8vw, 60px); 
                        height: clamp(50px, 8vw, 60px); 
                        border-radius: 50%; 
                        object-fit: cover; 
                        border: 2px solid var(--color-amarillo); 
                    }
                    h2 { font-size: clamp(16px, 2vw, 18px); text-transform: uppercase; }
                    p { font-family: Arial, sans-serif; font-size: clamp(11px, 1.2vw, 12px); color: #888; }
                }

                .sidebar-menu {
                    list-style: none;

                    li { margin-bottom: 10px; }

                    button {
                        width: 100%; 
                        background: transparent; 
                        border: none; 
                        color: #888;
                        text-align: left; 
                        padding: clamp(10px, 1.5vw, 12px) clamp(10px, 2vw, 15px); 
                        font-size: clamp(12px, 1.5vw, 14px);
                        font-family: 'Arial Black', sans-serif; 
                        text-transform: uppercase;
                        cursor: pointer; 
                        border-radius: 6px; 
                        transition: all 0.3s;
                        display: flex; 
                        align-items: center; 
                        gap: 10px;

                        &:hover { background: var(--color-gris-tarjeta); color: var(--color-blanco); }
                        &.active { background: var(--color-amarillo); color: var(--color-negro); }
                    }
                }
            }

            .profile-content {
                flex: 1;
                background: var(--color-gris-tarjeta);
                border: 1px solid var(--color-gris-claro);
                border-radius: 12px;
                padding: clamp(20px, 4vw, 40px);
                min-height: 500px;

                .tab-content { 
                    display: none; animation: fadeIn 0.4s ease; 
                    &.active { display: block; }
                }

                .content-title { 
                    font-size: clamp(20px, 3vw, 24px); 
                    text-transform: uppercase; 
                    color: var(--color-amarillo); 
                    border-bottom: 1px solid #333; 
                    padding-bottom: 15px; 
                    margin-bottom: clamp(20px, 3vw, 30px); 
                }

                /* FORMS */
                .alert-success { 
                    background: rgba(255, 208, 0, 0.1); border-left: 4px solid var(--color-amarillo); 
                    padding: clamp(10px, 1.5vw, 15px); margin-bottom: clamp(20px, 3vw, 30px); 
                    border-radius: 4px; font-family: Arial, sans-serif; font-size: clamp(12px, 1.2vw, 14px);
                }

                .form-group { 
                    margin-bottom: clamp(15px, 2.5vw, 25px); 
                    label { 
                        display: block; color: #888; margin-bottom: 8px; 
                        font-size: clamp(11px, 1.2vw, 12px); text-transform: uppercase; font-weight: bold; 
                    }
                    input { 
                        width: 100%; background: var(--color-negro); border: 1px solid #333; 
                        color: white; padding: clamp(12px, 1.5vw, 15px); border-radius: 6px; 
                        font-size: clamp(14px, 1.5vw, 16px);
                    }
                }

                .btn-save { 
                    background: var(--color-amarillo); color: var(--color-negro); 
                    padding: clamp(12px, 1.5vw, 15px) clamp(20px, 3vw, 40px); 
                    font-size: clamp(12px, 1.2vw, 14px);
                    font-weight: 900; text-transform: uppercase; border: none; border-radius: 4px; 
                    cursor: pointer; transition: 0.3s; 
                    &:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(255, 208, 0, 0.3); }
                }
                
                .avatar-grid { 
                    display: flex; gap: clamp(10px, 1.5vw, 15px); flex-wrap: wrap; margin-bottom: 20px; 

                    .avatar-option { 
                        width: clamp(50px, 6vw, 65px); height: clamp(50px, 6vw, 65px); 
                        border-radius: 50%; cursor: pointer; border: 3px solid transparent; 
                        opacity: 0.5; transition: 0.3s; object-fit: cover;
                        
                        &.selected { border-color: var(--color-amarillo); opacity: 1; transform: scale(1.1); box-shadow: 0 0 15px rgba(255, 208, 0, 0.5); }
                        &:hover { opacity: 1; }
                    }
                }

                /* LISTA DE BOOKINGS */
                .bookings-list { 
                    display: flex; flex-direction: column; gap: clamp(10px, 1.5vw, 15px); 
                    
                    .booking-item {
                        display: flex; align-items: center; padding: clamp(10px, 1.5vw, 15px); 
                        border-radius: 15px; gap: clamp(10px, 2vw, 20px); 
                        transition: 0.3s; border: 1px solid rgba(255,255,255,0.05); position: relative;

                        &:hover { transform: scale(1.01); border-color: rgba(255,255,255,0.2); }
                        
                        .booking-img-wrapper {
                            width: clamp(50px, 7vw, 70px); height: clamp(75px, 10vw, 100px); 
                            flex-shrink: 0; overflow: hidden; border-radius: 8px; box-shadow: 0 5px 15px rgba(0,0,0,0.5);
                            img { width: 100%; height: 100%; object-fit: cover; }
                        }

                        .booking-info { 
                            flex: 1; 
                            h3 { font-size: clamp(16px, 2vw, 20px); text-transform: uppercase; margin: 0; letter-spacing: 1px; }
                            p { font-size: clamp(11px, 1.2vw, 13px); opacity: 0.7; margin-top: 5px; font-family: Arial, sans-serif; }
                        }

                        .view-ticket-btn {
                            text-decoration: none; padding: clamp(8px, 1vw, 12px) clamp(15px, 2vw, 25px); 
                            border-radius: 10px; font-size: clamp(10px, 1.1vw, 12px); 
                            font-weight: 900; text-transform: uppercase; transition: 0.3s; text-align: center;
                            &:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(255,255,255,0.1); }
                        }
                    }
                }
            }
        }

        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        /* --- FOOTER (CON CLAMPS Y NESTING) --- */
        footer {
            background-color: var(--color-negro);
            padding: clamp(40px, 6vw, 60px) 5% 40px;
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
                        align-items: flex-start;

                        .footer-logo img {
                            height: clamp(40px, 5vw, 60px);
                            margin-bottom: 20px;
                            display: block;
                        }

                        p { max-width: 250px; }
                    }

                    p {
                        font-family: Arial, sans-serif;
                        color: #888;
                        font-size: clamp(12px, 1vw, 13px);
                        line-height: 1.6;
                    }

                    h4 {
                        font-size: clamp(14px, 1.5vw, 16px);
                        text-transform: uppercase;
                        letter-spacing: 2px;
                        margin-bottom: 20px;
                        color: var(--color-amarillo);
                    }

                    .footer-links {
                        list-style: none;

                        li {
                            margin-bottom: 10px;

                            a {
                                color: var(--color-blanco);
                                text-decoration: none;
                                font-family: Arial, sans-serif;
                                font-size: clamp(12px, 1vw, 14px);
                                transition: color 0.3s ease;

                                &:hover { color: var(--color-amarillo); }
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
                font-size: clamp(10px, 1vw, 12px);
                color: #666;

                .footer-credits {
                    display: flex; align-items: center; gap: 8px; color: #888; font-family: Arial, sans-serif;

                    span { color: var(--color-amarillo); font-weight: bold; }

                    .heart-icon {
                        width: 16px; height: 16px; color: #888; transition: color 0.3s ease;
                    }

                    &:hover .heart-icon {
                        color: #ff4444; filter: drop-shadow(0 0 3px #ff4444);
                    }
                }
            }
        }

        /* --- MEDIA QUERIES --- */
        @media (max-width: 900px) {
            .profile-container {
                flex-direction: column;
                .profile-sidebar { width: 100%; }
                
                .bookings-list .booking-item {
                    flex-direction: column; text-align: center; align-items: center;
                }
            }
            
            footer {
                .footer-content {
                    flex-direction: column; text-align: center;
                    .footer-col:first-child { align-items: center; }
                }
                .footer-bottom { flex-direction: column; gap: 15px; }
            }
        }

        @media (max-width: 768px) {
            .desktop-nav { display: none; }

            #nav-icon {
                display: block; width: 30px; height: 22px; position: relative; cursor: pointer; z-index: 1001; 
                
                span {
                    display: block; position: absolute; height: 3px; width: 100%; background: var(--header-text-color, var(--color-blanco)); border-radius: 3px; opacity: 1; left: 0; transition: 0.25s ease-in-out, background-color 0.3s ease;
                    
                    &:nth-child(1) { top: 0px; }
                    &:nth-child(2) { top: 9px; }
                    &:nth-child(3) { top: 18px; }
                }

                &.open {
                    span:nth-child(1) { top: 9px; transform: rotate(135deg); }
                    span:nth-child(2) { opacity: 0; left: -60px; }
                    span:nth-child(3) { top: 9px; transform: rotate(-135deg); }
                }
            }

            .menu_mobile {
                display: flex; position: fixed; top: 0; left: 0; width: 100%; height: 100vh; background-color: var(--color-negro); z-index: 1000; flex-direction: column; align-items: center; justify-content: center; opacity: 0; pointer-events: none; transition: opacity 0.4s ease;

                &.grow { opacity: 1; pointer-events: auto; }

                .menu-mobile-close {
                    position: absolute; top: clamp(20px, 4vw, 30px); right: clamp(20px, 5vw, 30px); background: none; border: none; color: var(--color-blanco); font-size: clamp(45px, 8vw, 60px); cursor: pointer; z-index: 1002; line-height: 1; transition: color 0.3s ease, transform 0.3s ease;

                    &:hover { color: var(--color-amarillo); transform: scale(1.1); }
                }

                .mobile-logo-container {
                    margin-bottom: 40px; opacity: 0; transform: translateY(-20px);
                    img { height: 60px; }
                }

                .menu_mobile_nav {
                    list-style: none; text-align: center; padding: 0;

                    li {
                        margin: 20px 0; opacity: 0; transform: translateY(20px);

                        a, .logout-btn-mobile {
                            color: var(--color-blanco); text-decoration: none; font-size: clamp(20px, 5vw, 24px); font-weight: 900; text-transform: uppercase; letter-spacing: 2px; transition: color 0.3s ease;

                            &:hover { color: var(--color-amarillo); }
                        }
                    }
                }
            }
        }
    </style>
</head>

<body>

    <header id="main-header" class="scrolled">
        <div class="logo"><a href="/"><img src="{{ asset('img/img/Logo-Blanco.png') }}" alt="Cinema Logo" id="main-logo"></a></div>
        
        <nav class="desktop-nav">
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
                            <svg xmlns="http://www.w3.org/2000/svg" class="chevron-icon" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
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
                        <a href="{{ route('register') }}" title="Create Account">
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

        <div id="nav-icon">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </header>

    <div class="menu_mobile">
        <button id="close-menu-btn" class="menu-mobile-close">&times;</button>

        <div class="mobile-logo-container">
            <a href="/"><img src="{{ asset('img/img/Logo-Blanco.png') }}" alt="Cinema Logo"></a>
        </div>
        <ul class="menu_mobile_nav">
            <li><a href="/">HOME</a></li>
            <li><a href="/#cartelera">FILMS</a></li>
            <li><a href="/#bar">MENUS</a></li>
            <li><a href="/community">COMMUNITY</a></li>
            
            @auth
                <li><a href="/profile">MY PROFILE</a></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="logout-btn-mobile" style="background:none; border:none; color:inherit; font:inherit; cursor:pointer; padding:0;">SIGN OUT</button>
                    </form>
                </li>
            @else
                <li><a href="{{ route('login') }}">SIGN IN</a></li>
                <li><a href="{{ route('register') }}">CREATE ACCOUNT</a></li>
            @endauth
        </ul>
    </div>

    <div class="profile-container">
        <aside class="profile-sidebar">
            <div class="user-header">
                <img src="{{ asset('img/avatars/' . (Auth::user()->avatar ?? 'avatar1.png')) }}" id="sidebar-avatar" class="main-avatar" onerror="this.src='https://via.placeholder.com/60/333/ffd000'">
                <div>
                    <h2>{{ Auth::user()->name ?? 'User' }}</h2>
                    <p>VIP Member</p>
                </div>
            </div>
            <ul class="sidebar-menu">
                <li><button class="tab-btn active" data-target="tab-profile">Profile Settings</button></li>
                <li><button class="tab-btn" data-target="tab-security">Security</button></li>
                <li><button class="tab-btn" data-target="tab-bookings">My Bookings</button></li>
            </ul>
        </aside>

        <main class="profile-content">
            @if (session('status'))
                <div class="alert-success">{{ session('status') }}</div>
            @endif

            <div id="tab-profile" class="tab-content active">
                <h2 class="content-title">Profile Settings</h2>
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf @method('PATCH')
                    <div class="avatar-grid">
                        <input type="hidden" name="avatar" id="avatar-input" value="{{ Auth::user()->avatar ?? 'avatar1.png' }}">
                        @for ($i = 1; $i <= 16; $i++)
                            <img src="{{ asset('img/avatars/avatar'.$i.'.png') }}" class="avatar-option {{ (Auth::user()->avatar == 'avatar'.$i.'.png') ? 'selected' : '' }}" onclick="selectAvatar(this, 'avatar{{$i}}.png')" onerror="this.src='https://via.placeholder.com/65/111/ffd000?text=A{{$i}}'">
                        @endfor
                    </div>
                    <div class="form-group">
                        <label>Display Name</label>
                        <input type="text" name="name" value="{{ Auth::user()->name }}" required>
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" value="{{ Auth::user()->email }}" required>
                    </div>
                    <button type="submit" class="btn-save">Save Changes</button>
                </form>
            </div>

            <div id="tab-security" class="tab-content">
                <h2 class="content-title">Security</h2>
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf @method('PUT')
                    <div class="form-group">
                        <label>Current Password</label>
                        <input type="password" name="current_password" required>
                    </div>
                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" name="password" required>
                    </div>
                    <button type="submit" class="btn-save">Update Password</button>
                </form>
            </div>

            <div id="tab-bookings" class="tab-content">
                <h2 class="content-title">My Bookings</h2>
                <div class="bookings-list">
                    
                    @forelse($myBookings ?? [] as $b)
                        <div class="booking-item" style="background: {{ $b['bg'] ?? '#141414' }};">
                            <div class="booking-img-wrapper">
                                <img src="{{ $b['poster'] ?? '' }}" onerror="this.src='https://via.placeholder.com/70x100/333/white?text=FILM'">
                            </div>
                            
                            <div class="booking-info">
                                <h3 style="color: {{ $b['color'] ?? 'white' }};">{{ $b['movie'] }}</h3>
                                <p style="color: {{ $b['color'] ?? 'white' }}; opacity: 0.8;">
                                    {{ date('d M Y', strtotime($b['date'])) }} • Seats: <strong>{{ $b['seats'] }}</strong>
                                </p>
                            </div>

                            <a href="{{ route('ticket.show', $b['id'] ?? 0) }}" class="view-ticket-btn" 
                               style="background: {{ $b['color'] ?? 'white' }}; color: {{ $b['bg'] ?? 'black' }};">
                                VIEW TICKET
                            </a>
                        </div>
                    @empty
                        <div style="text-align:center; padding: 40px; border: 1px dashed #333; border-radius: 12px;">
                            <p style="color:#666;">You don't have any bookings yet.</p>
                            <a href="/#cartelera" style="color:var(--color-amarillo); text-decoration:none; font-size:12px; margin-top:10px; display:block;">EXPLORE MOVIES</a>
                        </div>
                    @endforelse

                </div>
            </div>
        </main>
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
                    <path
                        d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                </svg>
                for <span>Beni</span>
            </p>
        </div>
    </footer>

    <script>
        const tabBtns = document.querySelectorAll('.tab-btn');
        const tabContents = document.querySelectorAll('.tab-content');
        tabBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                tabBtns.forEach(b => b.classList.remove('active'));
                tabContents.forEach(c => c.classList.remove('active'));
                btn.classList.add('active');
                document.getElementById(btn.dataset.target).classList.add('active');
            });
        });

        function selectAvatar(img, filename) {
            document.querySelectorAll('.avatar-option').forEach(i => i.classList.remove('selected'));
            img.classList.add('selected');
            document.getElementById('avatar-input').value = filename;
            document.getElementById('sidebar-avatar').src = img.src;
        }

        window.onload = () => {
            const urlParams = new URLSearchParams(window.location.search);
            if(urlParams.get('success') === '1' || window.location.hash === '#tab-bookings') {
                const btn = document.querySelector('[data-target="tab-bookings"]');
                if(btn) btn.click();
            }
        };

        // Si venimos de un pago exitoso, borramos el temporizador
        const urlParams = new URLSearchParams(window.location.search);
        if(urlParams.get('success') === '1') {
            sessionStorage.removeItem('booking_end_time');
        }
    </script>
    
    <script src="{{ asset('js/hamburguer.js') }}"></script>
</body>
</html>