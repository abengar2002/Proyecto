<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Screenbites Cinema - My Profile</title>

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
            background-color: rgba(0, 0, 0, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);

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
                    color: var(--color-blanco);
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
                        color: var(--color-amarillo) !important;
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
                color: var(--color-amarillo);

                .user-avatar {
                    width: 35px;
                    height: 35px;
                    border-radius: 50%;
                    object-fit: cover;
                    border: 2px solid var(--color-amarillo);
                }

                .user-name,
                .chevron-icon {
                    color: var(--color-amarillo);
                }

                .chevron-icon {
                    width: 16px;
                    height: 16px;
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
                color: var(--color-blanco);
                transition: color 0.3s ease, transform 0.2s ease;

                svg { width: 26px; height: 26px; }

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
                }

                &:hover {
                    color: var(--color-amarillo) !important;
                    transform: scale(1.1);
                }
            }
        }

        /* --- PROFILE DASHBOARD --- */
        .profile-container {
            max-width: 1200px;
            margin: 150px auto 100px;
            padding: 0 5%;
            display: flex;
            gap: 40px;

            /* MENU LATERAL */
            .profile-sidebar {
                width: 250px;
                flex-shrink: 0;

                .user-header {
                    display: flex;
                    align-items: center;
                    gap: 15px;
                    margin-bottom: 40px;
                    padding-bottom: 20px;
                    border-bottom: 1px solid var(--color-gris-claro);

                    .main-avatar {
                        width: 60px;
                        height: 60px;
                        border-radius: 50%;
                        object-fit: cover;
                        border: 2px solid var(--color-amarillo);
                    }

                    h2 {
                        font-size: 18px;
                        text-transform: uppercase;
                        line-height: 1.2;
                    }
                    p {
                        font-family: Arial, sans-serif;
                        font-size: 12px;
                        color: #888;
                    }
                }

                .sidebar-menu {
                    list-style: none;

                    li {
                        margin-bottom: 10px;

                        button {
                            width: 100%;
                            background: transparent;
                            border: none;
                            color: #888;
                            text-align: left;
                            padding: 12px 15px;
                            font-size: 14px;
                            font-family: 'Arial Black', sans-serif;
                            text-transform: uppercase;
                            cursor: pointer;
                            border-radius: 6px;
                            transition: all 0.3s ease;
                            display: flex;
                            align-items: center;
                            gap: 10px;

                            svg { width: 18px; height: 18px; }

                            &:hover {
                                background: var(--color-gris-tarjeta);
                                color: var(--color-blanco);
                            }

                            &.active {
                                background: var(--color-amarillo);
                                color: var(--color-negro);
                            }
                        }
                    }
                }
            }

            /* CONTENIDO CENTRAL */
            .profile-content {
                flex: 1;
                background: var(--color-gris-tarjeta);
                border: 1px solid var(--color-gris-claro);
                border-radius: 12px;
                padding: 40px;
                min-height: 500px;

                .tab-content {
                    display: none;
                    animation: fadeIn 0.4s ease;

                    &.active {
                        display: block;
                    }
                }

                .content-title {
                    font-size: 24px;
                    text-transform: uppercase;
                    color: var(--color-amarillo);
                    margin-bottom: 10px;
                    border-bottom: 1px solid #333;
                    padding-bottom: 15px;
                }

                .content-desc {
                    font-family: Arial, sans-serif;
                    color: #aaa;
                    font-size: 14px;
                    margin-bottom: 30px;
                }

                /* ALERTAS */
                .alert-success {
                    background-color: rgba(255, 208, 0, 0.1);
                    border-left: 4px solid var(--color-amarillo);
                    color: var(--color-blanco);
                    padding: 15px;
                    margin-bottom: 30px;
                    border-radius: 4px;
                    font-family: Arial, sans-serif;
                    font-size: 14px;
                }

                .alert-error {
                    background-color: rgba(255, 0, 0, 0.1);
                    border-left: 4px solid #ff4444;
                    color: var(--color-blanco);
                    padding: 15px;
                    margin-bottom: 30px;
                    border-radius: 4px;
                    font-family: Arial, sans-serif;
                    font-size: 14px;

                    ul { margin-left: 20px; margin-top: 5px;}
                }

                /* SELECTOR DE AVATARES */
                .avatar-selection-wrapper {
                    margin-bottom: 40px;

                    .avatar-label {
                        font-family: Arial, sans-serif;
                        font-size: 13px;
                        color: #888;
                        text-transform: uppercase;
                        margin-bottom: 15px;
                        display: block;
                        font-weight: bold;
                    }

                    .avatar-grid {
                        display: flex;
                        gap: 15px;
                        flex-wrap: wrap;

                        .avatar-option {
                            width: 65px;
                            height: 65px;
                            border-radius: 50%;
                            cursor: pointer;
                            border: 3px solid transparent;
                            opacity: 0.5;
                            transition: all 0.3s ease;
                            object-fit: cover;

                            &:hover {
                                opacity: 0.8;
                                transform: scale(1.1);
                            }

                            &.selected {
                                border-color: var(--color-amarillo);
                                opacity: 1;
                                transform: scale(1.1);
                                box-shadow: 0 0 15px rgba(255, 208, 0, 0.4);
                            }
                        }
                    }
                }

                /* FORMULARIOS */
                .form-group {
                    margin-bottom: 25px;

                    label {
                        display: block;
                        color: #888;
                        margin-bottom: 8px;
                        font-family: Arial, sans-serif;
                        font-size: 12px;
                        text-transform: uppercase;
                        font-weight: bold;
                        letter-spacing: 1px;
                    }

                    input {
                        width: 100%;
                        background: var(--color-negro);
                        border: 1px solid #333;
                        color: var(--color-blanco);
                        padding: 15px;
                        border-radius: 6px;
                        font-size: 15px;
                        transition: border-color 0.3s, box-shadow 0.3s;
                        font-family: Arial, sans-serif;

                        &:focus {
                            outline: none;
                            border-color: var(--color-amarillo);
                            box-shadow: 0 0 10px rgba(255, 208, 0, 0.2);
                        }
                    }
                }

                .btn-save {
                    background: var(--color-amarillo);
                    color: var(--color-negro);
                    padding: 15px 40px;
                    font-size: 14px;
                    font-weight: 900;
                    text-transform: uppercase;
                    border: none;
                    border-radius: 4px;
                    cursor: pointer;
                    letter-spacing: 1px;
                    transition: all 0.3s ease;
                    margin-top: 10px;

                    &:hover {
                        background: var(--color-blanco);
                        transform: scale(1.05);
                    }
                }

                /* --- BOOKINGS DESIGN (MIS RESERVAS) --- */
                .bookings-list {
                    display: flex;
                    flex-direction: column;
                    gap: 25px;
                    margin-top: 10px;

                    .booking-card {
                        display: flex;
                        background: #0d0d0d;
                        border: 1px solid #333;
                        border-radius: 12px;
                        overflow: hidden;
                        position: relative;
                        transition: transform 0.3s ease, border-color 0.3s;

                        &:hover {
                            border-color: var(--color-amarillo);
                            transform: translateY(-3px);
                            box-shadow: 0 10px 25px rgba(0,0,0,0.5);
                        }

                        /* Estado de la reserva (Etiqueta arriba) */
                        .booking-status {
                            position: absolute;
                            top: 15px;
                            right: 180px; /* Para que no pise el QR */
                            background: var(--color-amarillo);
                            color: var(--color-negro);
                            font-size: 10px;
                            font-weight: bold;
                            padding: 3px 8px;
                            border-radius: 4px;
                            text-transform: uppercase;
                            z-index: 5;
                            
                            &.past {
                                background: #444;
                                color: #aaa;
                            }
                        }

                        .booking-poster {
                            width: 150px;
                            flex-shrink: 0;

                            img {
                                width: 100%;
                                height: 100%;
                                object-fit: cover;
                            }
                        }

                        .booking-details {
                            flex: 1;
                            padding: 25px 30px;
                            display: flex;
                            flex-direction: column;
                            justify-content: center;

                            .movie-header {
                                margin-bottom: 15px;
                                
                                h3 {
                                    font-size: 24px;
                                    color: var(--color-blanco);
                                    text-transform: uppercase;
                                    margin-bottom: 5px;
                                    line-height: 1.1;
                                }

                                .booking-meta {
                                    color: #aaa;
                                    font-family: Arial, sans-serif;
                                    font-size: 13px;
                                    
                                    span { color: var(--color-blanco); font-weight: bold; }
                                }
                            }

                            /* EL TICKET DE COMPRA (RECIBO) */
                            .booking-receipt {
                                background: rgba(255, 255, 255, 0.03);
                                border: 1px dashed #333;
                                border-radius: 6px;
                                padding: 15px;
                                
                                h4 {
                                    font-size: 11px;
                                    color: #888;
                                    text-transform: uppercase;
                                    margin-bottom: 10px;
                                    letter-spacing: 1px;
                                }

                                ul {
                                    list-style: none;
                                    margin-bottom: 10px;

                                    li {
                                        display: flex;
                                        justify-content: space-between;
                                        font-family: Arial, sans-serif;
                                        font-size: 13px;
                                        color: #ccc;
                                        margin-bottom: 5px;
                                    }
                                }

                                .receipt-total {
                                    display: flex;
                                    justify-content: space-between;
                                    border-top: 1px solid #444;
                                    padding-top: 10px;
                                    margin-top: 5px;
                                    font-weight: 900;
                                    color: var(--color-amarillo);
                                    font-size: 16px;
                                }
                            }
                        }

                        /* Efecto de troquelado del ticket */
                        .booking-divider {
                            width: 2px;
                            background: repeating-linear-gradient(to bottom, #444 0, #444 8px, transparent 8px, transparent 16px);
                            position: relative;

                            &::before, &::after {
                                content: '';
                                position: absolute;
                                width: 30px;
                                height: 30px;
                                background: var(--color-gris-tarjeta); 
                                border-radius: 50%;
                                left: -14px;
                                border: 1px solid #333;
                            }

                            &::before { top: -16px; border-top-color: transparent; border-left-color: transparent; border-right-color: transparent; }
                            &::after { bottom: -16px; border-bottom-color: transparent; border-left-color: transparent; border-right-color: transparent; }
                        }

                        .booking-qr {
                            width: 170px;
                            padding: 20px;
                            display: flex;
                            flex-direction: column;
                            align-items: center;
                            justify-content: center;
                            background: #050505;
                            flex-shrink: 0;

                            img {
                                width: 100px;
                                height: 100px;
                                margin-bottom: 15px;
                                border-radius: 6px;
                                padding: 5px;
                                background: white;
                            }

                            span {
                                color: #666;
                                font-size: 12px;
                                font-family: monospace;
                                letter-spacing: 2px;
                            }
                        }
                    }
                }
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
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
                        
                        .footer-logo img { height: 60px; margin-bottom: 20px; display: block; }
                        p { max-width: 250px; }
                    }

                    p { font-family: Arial, sans-serif; color: #888; font-size: 13px; line-height: 1.6; }
                    h4 { font-size: 16px; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 20px; color: var(--color-amarillo); }
                    .footer-links { list-style: none; li { margin-bottom: 10px; a { color: var(--color-blanco); text-decoration: none; font-family: Arial, sans-serif; font-size: 14px; transition: color 0.3s ease; &:hover { color: var(--color-amarillo); } } } }
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
                    display: flex; align-items: center; gap: 8px; color: #888; font-family: Arial, sans-serif;
                    span { color: var(--color-amarillo); font-weight: bold; }
                    .heart-icon { width: 16px; height: 16px; color: #888; transition: color 0.3s ease; }
                    &:hover .heart-icon { color: #ff4444; filter: drop-shadow(0 0 3px #ff4444); }
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

                <div class="user-nav">
                    <li>
                        <a href="/profile" class="user-profile" title="My Profile">
                            <img src="{{ asset('img/avatars/' . Auth::user()->avatar ?? 'default.png') }}" alt="Avatar" class="user-avatar" onerror="this.src='https://via.placeholder.com/35/333/ffd000'">
                            <span class="user-name">{{ strtoupper(Auth::user()->name ?? 'User') }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="chevron-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </a>
                    </li>

                    <li>
                        <button class="nav-cart" onclick="alert('Checkout functionality in development')">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                            <div class="cart-badge" id="nav-cart-counter">0</div>
                        </button>
                    </li>

                    <li>
                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="logout-btn" title="Sign Out">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                            </button>
                        </form>
                    </li>
                </div>
            </ul>
        </nav>
    </header>

    <div class="profile-container">
        
        <aside class="profile-sidebar">
            <div class="user-header">
                <img src="{{ asset('img/avatars/' . Auth::user()->avatar ?? 'default.png') }}" id="sidebar-avatar" class="main-avatar" onerror="this.src='https://via.placeholder.com/60/333/ffd000'">
                <div>
                    <h2>{{ Auth::user()->name ?? 'User' }}</h2>
                    <p>VIP Member</p>
                </div>
            </div>

            <ul class="sidebar-menu">
                <li>
                    <button class="tab-btn active" data-target="tab-profile">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        Profile Settings
                    </button>
                </li>
                <li>
                    <button class="tab-btn" data-target="tab-security">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                        Security & Password
                    </button>
                </li>
                <li>
                    <button class="tab-btn" data-target="tab-bookings">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        My Bookings
                    </button>
                </li>
            </ul>
        </aside>

        <main class="profile-content">

            @if (session('status') && session('status') !== 'profile-updated')
                <div class="alert-success">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert-error">
                    <strong>Please check the following errors:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <div id="tab-profile" class="tab-content active">
                <h2 class="content-title">Profile Settings</h2>
                <p class="content-desc">Manage your public information and choose a custom avatar to represent you in Screenbites.</p>

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="avatar-selection-wrapper">
                        <span class="avatar-label">Choose your Character</span>
                        <div class="avatar-grid">
                            <input type="hidden" name="avatar" id="avatar-input" value="{{ Auth::user()->avatar ?? 'avatar1.png' }}">
                            
                            <img src="{{ asset('img/avatars/avatar1.png') }}" class="avatar-option selected" onclick="selectAvatar(this, 'avatar1.png')" onerror="this.src='https://via.placeholder.com/65/111/ffd000?text=A1'">
                            <img src="{{ asset('img/avatars/avatar2.png') }}" class="avatar-option" onclick="selectAvatar(this, 'avatar2.png')" onerror="this.src='https://via.placeholder.com/65/111/ffd000?text=A2'">
                            <img src="{{ asset('img/avatars/avatar3.png') }}" class="avatar-option" onclick="selectAvatar(this, 'avatar3.png')" onerror="this.src='https://via.placeholder.com/65/111/ffd000?text=A3'">
                            <img src="{{ asset('img/avatars/avatar4.png') }}" class="avatar-option" onclick="selectAvatar(this, 'avatar4.png')" onerror="this.src='https://via.placeholder.com/65/111/ffd000?text=A4'">
                            <img src="{{ asset('img/avatars/avatar5.png') }}" class="avatar-option" onclick="selectAvatar(this, 'avatar5.png')" onerror="this.src='https://via.placeholder.com/65/111/ffd000?text=A5'">
                            <img src="{{ asset('img/avatars/avatar6.png') }}" class="avatar-option" onclick="selectAvatar(this, 'avatar6.png')" onerror="this.src='https://via.placeholder.com/65/111/ffd000?text=A6'">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name">Display Name</label>
                        <input type="text" id="name" name="name" value="{{ Auth::user()->name ?? '' }}" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ Auth::user()->email ?? '' }}" required>
                    </div>

                    <button type="submit" class="btn-save">Save Changes</button>
                </form>
            </div>

            <div id="tab-security" class="tab-content">
                <h2 class="content-title">Security & Password</h2>
                <p class="content-desc">Ensure your account is using a long, random password to stay secure.</p>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <input type="password" id="current_password" name="current_password" required>
                    </div>

                    <div class="form-group">
                        <label for="password">New Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirm New Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required>
                    </div>

                    <button type="submit" class="btn-save">Update Password</button>
                </form>
            </div>

            <div id="tab-bookings" class="tab-content">
                <h2 class="content-title">My Bookings</h2>
                <p class="content-desc">Review your upcoming movie tickets and pre-ordered food. Present the QR code at the cinema entrance.</p>

                <div class="bookings-list">
                    
                    <div class="booking-card">
                        <div class="booking-status">Upcoming</div>
                        <div class="booking-poster">
                            <img src="{{ asset('img/1-Kill-Bill/Mini.png') }}" onerror="this.src='https://via.placeholder.com/150x300/111/ffd000?text=Poster'">
                        </div>
                        
                        <div class="booking-details">
                            <div class="movie-header">
                                <h3>Kill Bill</h3>
                                <div class="booking-meta">Friday, Oct 24 • 20:30 • <span>Room 4</span></div>
                            </div>

                            <div class="booking-receipt">
                                <h4>Order Summary</h4>
                                <ul>
                                    <li><span>2x VIP Tickets (Row D, Seats 8-9)</span> <span>$24.00</span></li>
                                    <li><span>1x The Vengeance Combo</span> <span>$14.99</span></li>
                                    <li><span>1x Extra Cheese Nachos</span> <span>$6.50</span></li>
                                </ul>
                                <div class="receipt-total">
                                    <span>Total Paid</span>
                                    <span>$45.49</span>
                                </div>
                            </div>
                        </div>

                        <div class="booking-divider"></div>

                        <div class="booking-qr">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=BOOKING-01-KB-D89" alt="QR Code">
                            <span>#BKG-84729</span>
                        </div>
                    </div>

                    <div class="booking-card" style="opacity: 0.6;">
                        <div class="booking-status past">Completed</div>
                        <div class="booking-poster">
                            <img src="{{ asset('img/4-Oppenheimer/Mini.png') }}" onerror="this.src='https://via.placeholder.com/150x300/111/ffd000?text=Poster'">
                        </div>
                        
                        <div class="booking-details">
                            <div class="movie-header">
                                <h3>Oppenheimer</h3>
                                <div class="booking-meta">Saturday, Sep 10 • 18:00 • <span>IMAX Room</span></div>
                            </div>

                            <div class="booking-receipt">
                                <h4>Order Summary</h4>
                                <ul>
                                    <li><span>1x Standard Ticket (Row G, Seat 12)</span> <span>$8.50</span></li>
                                </ul>
                                <div class="receipt-total">
                                    <span style="color:#aaa;">Total Paid</span>
                                    <span style="color:#aaa;">$8.50</span>
                                </div>
                            </div>
                        </div>

                        <div class="booking-divider"></div>

                        <div class="booking-qr">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=EXPIRED" alt="QR Code" style="opacity: 0.3;">
                            <span>EXPIRED</span>
                        </div>
                    </div>

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
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                </svg>
                for <span>Beni</span>
            </p>
        </div>
    </footer>

    <script>
        // SCRIPT PARA PESTAÑAS
        const tabBtns = document.querySelectorAll('.tab-btn');
        const tabContents = document.querySelectorAll('.tab-content');

        tabBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                if(!btn.dataset.target) return;

                tabBtns.forEach(b => b.classList.remove('active'));
                tabContents.forEach(c => c.classList.remove('active'));

                btn.classList.add('active');
                document.getElementById(btn.dataset.target).classList.add('active');
            });
        });

        // SCRIPT PARA SELECCIÓN DE AVATAR
        function selectAvatar(imgElement, filename) {
            document.querySelectorAll('.avatar-option').forEach(img => {
                img.classList.remove('selected');
            });
            
            imgElement.classList.add('selected');
            document.getElementById('avatar-input').value = filename;
            document.getElementById('sidebar-avatar').src = imgElement.src;
        }
    </script>

</body>
</html>