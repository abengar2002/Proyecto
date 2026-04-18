<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Screenbites Cinema - {{ $movie['title'] ?? 'Movie' }}</title>
    
    <link rel="stylesheet" href="{{ asset('css/webbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">

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

        /* SOBREESCRIBIMOS LA BARRA DE SCROLL GLOBAL CON EL COLOR DE LA PELÍCULA */
        ::-webkit-scrollbar-thumb {
            background-color: var(--color-principal) !important;
            
            &:hover {
                background-color: var(--color-principal) !important;
                filter: brightness(0.85);
            }
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

            &.menu-open {
                overflow: hidden;
            }
        }

        /* Ocultar el icono hamburguesa y el menú móvil en escritorio por defecto */
        #nav-icon, .menu_mobile {
            display: none;
        }

        /* --- HEADER (CON NESTING) --- */
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
            background-color: transparent;
            border-bottom: 1px solid transparent;
            transition: background-color 0.3s ease, box-shadow 0.3s ease, border-bottom 0.3s ease;

            &.scrolled {
                background-color: rgba(0, 0, 0, 0.95);
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.8);
                border-bottom: 1px solid rgba(255, 255, 255, 0.05);

                nav a,
                nav .logout-btn,
                .user-profile .user-name,
                .user-profile .chevron-icon {
                    color: var(--color-blanco) !important;
                    text-shadow: none !important;
                }
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

                a,
                .logout-btn {
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
                        color: var(--color-principal) !important;
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
                        color: var(--header-text-color, var(--color-blanco));
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
                            color: var(--color-principal) !important;
                            text-shadow: 0px 2px 10px rgba(0, 0, 0, 1), 0px 0px 4px rgba(0, 0, 0, 1) !important;
                        }
                    }
                }
            }
        }

        /* --- MOVIE HERO (NETFLIX STYLE) CON NESTING --- */
        .movie-hero {
            position: relative;
            width: 100%;
            min-height: 65vh;
            display: flex;
            align-items: center;
            padding: clamp(100px, 12vw, 120px) 5% clamp(30px, 5vw, 40px);

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
                gap: clamp(20px, 5vw, 50px);
                max-width: 1300px;
                margin: 0 auto;
                width: 100%;
                align-items: center;

                .movie-poster {
                    width: clamp(180px, 30vw, 280px);
                    border-radius: 8px;
                    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.9);
                    border: 2px solid var(--color-principal);
                    flex-shrink: 0;
                }

                .movie-info {
                    flex: 1;
                    min-width: 0; 

                    .movie-id {
                        color: var(--color-principal);
                        font-size: clamp(12px, 1.5vw, 16px);
                        letter-spacing: clamp(2px, 0.5vw, 5px);
                        margin-bottom: 10px;
                        display: block;
                    }

                    .movie-title {
                        font-size: clamp(18px, 4vw, 60px);
                        margin: 0 0 15px 0;
                        text-transform: uppercase;
                        line-height: 1.1;
                        text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.8);
                        white-space: nowrap; 
                    }

                    .movie-meta {
                        display: flex;
                        gap: clamp(10px, 2vw, 20px);
                        align-items: center;
                        font-family: Arial, sans-serif;
                        font-size: clamp(11px, 1.5vw, 14px);
                        margin-bottom: clamp(15px, 2.5vw, 25px);
                        color: #ddd;
                        flex-wrap: wrap; 

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
                        margin-bottom: clamp(20px, 3vw, 35px);
                        font-size: clamp(13px, 1.5vw, 16px);
                        max-width: 800px;
                        white-space: normal; 
                    }

                    .action-buttons {
                        display: flex;
                        gap: clamp(10px, 1.5vw, 15px);
                        align-items: center;
                        flex-wrap: wrap;

                        .btn-buy {
                            background: var(--color-principal);
                            color: var(--color-texto-btn) !important;
                            padding: clamp(10px, 1.5vw, 12px) clamp(20px, 3vw, 30px);
                            font-size: clamp(11px, 1.2vw, 13px);
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

                            svg {
                                width: clamp(16px, 2vw, 20px);
                                height: clamp(16px, 2vw, 20px);
                                stroke: currentColor; 
                                transition: stroke 0.3s ease;
                            }

                            &:hover:not(:disabled) {
                                background: var(--color-blanco);
                                color: var(--color-negro) !important;
                                transform: scale(1.05);
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
                            padding: clamp(10px, 1.5vw, 12px) clamp(20px, 3vw, 30px);
                            font-size: clamp(11px, 1.2vw, 13px);
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
            font-size: clamp(20px, 3vw, 24px);
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: -1px;
            color: var(--color-blanco);
            border-left: 5px solid var(--color-principal);
            padding-left: 15px;
            margin-bottom: clamp(20px, 3vw, 30px);
            line-height: 1;
        }

        /* --- MEDIA CAROUSEL INFINITO (CON NESTING) --- */
        .media-carousel-section {
            padding: clamp(30px, 5vw, 60px) 5%;
            background-color: var(--color-negro);
            max-width: 1400px;
            margin: 0 auto;

            .carousel-container {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: clamp(10px, 2vw, 20px);
                width: 100%;

                .media-nav-btn {
                    background: transparent;
                    border: none;
                    color: var(--color-blanco);
                    cursor: pointer;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    padding: clamp(5px, 1vw, 10px);
                    opacity: 0.6;
                    transition: all 0.3s ease;
                    flex-shrink: 0;

                    svg {
                        width: clamp(24px, 3vw, 36px);
                        height: clamp(24px, 3vw, 36px);
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
                    height: clamp(180px, 25vw, 300px);
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
                        width: clamp(40px, 6vw, 60px);
                        height: clamp(40px, 6vw, 60px);
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
                            width: clamp(16px, 2.5vw, 24px);
                            height: clamp(16px, 2.5vw, 24px);
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

        /* --- MODAL (LIGHTBOX) PARA MEDIA (CON NESTING) --- */
        .media-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.85); 
            z-index: 9999;
            justify-content: center;
            align-items: center;
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            opacity: 0;
            transition: opacity 0.3s ease;

            &.active {
                display: flex;
                opacity: 1;

                .media-modal-content {
                    transform: scale(1);
                }
            }

            .media-modal-content {
                position: relative;
                width: 90%;
                max-width: 1200px;
                aspect-ratio: 16/9;
                background: #000;
                border-radius: 12px;
                box-shadow: 0 0 50px rgba(0, 0, 0, 0.9);
                border: 2px solid var(--color-principal);
                display: flex;
                align-items: center;
                justify-content: center;
                overflow: hidden;
                transform: scale(0.9);
                transition: transform 0.3s ease;

                img, iframe {
                    max-width: 100%;
                    max-height: 100%;
                    border-radius: 10px;
                    border: none;
                    display: block;
                }
                
                img {
                    object-fit: contain; 
                }
                
                iframe {
                    width: 100%;
                    height: 100%;
                }
            }

            .media-modal-close {
                position: absolute;
                top: clamp(10px, 2vw, 20px);
                right: clamp(15px, 3vw, 30px);
                background: none;
                border: none;
                color: var(--color-blanco);
                font-size: clamp(35px, 5vw, 50px);
                font-family: Arial, sans-serif;
                cursor: pointer;
                transition: all 0.3s ease;
                line-height: 1;
                z-index: 10;
                opacity: 0.7;

                &:hover {
                    color: var(--color-principal);
                    transform: scale(1.1);
                    opacity: 1;
                }
            }

            .modal-nav-btn {
                position: absolute;
                top: 50%;
                transform: translateY(-50%);
                background: rgba(0, 0, 0, 0.5);
                border: 2px solid rgba(255, 255, 255, 0.2);
                color: var(--color-blanco);
                width: clamp(40px, 6vw, 60px);
                height: clamp(40px, 6vw, 60px);
                border-radius: 50%;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.3s ease;
                z-index: 10;
                opacity: 0; 

                svg {
                    width: clamp(20px, 3vw, 30px);
                    height: clamp(20px, 3vw, 30px);
                    stroke-width: 3;
                    transition: transform 0.3s ease;
                }

                &:hover {
                    background: var(--color-principal);
                    border-color: var(--color-principal);
                    color: var(--color-texto-btn);
                    box-shadow: 0 0 20px rgba(255, 208, 0, 0.5);
                }

                &.prev { 
                    left: clamp(10px, 3vw, 30px); 
                    &:hover svg { transform: translateX(-4px); }
                }
                
                &.next { 
                    right: clamp(10px, 3vw, 30px); 
                    &:hover svg { transform: translateX(4px); }
                }
            }

            &:hover .modal-nav-btn {
                opacity: 1;
            }

            &.single-item .modal-nav-btn {
                display: none !important;
            }
        }

        /* --- EXCLUSIVE MENU (CON NESTING) --- */
        .exclusive-movie-menu {
            padding: clamp(30px, 5vw, 60px) 5% clamp(60px, 8vw, 80px);
            background-color: var(--color-negro);
            max-width: 1400px;
            margin: 0 auto;

            .exclusive-banner {
                background: linear-gradient(135deg, #1a1a1a 0%, #000000 100%);
                border: 1px solid #333;
                border-radius: 12px;
                padding: clamp(20px, 4vw, 40px);
                display: flex;
                align-items: center;
                gap: clamp(20px, 4vw, 40px);
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
                    width: clamp(200px, 30vw, 380px); 
                    height: clamp(150px, 20vw, 260px); 
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
                        font-size: clamp(9px, 1.2vw, 11px);
                        font-weight: 900;
                        padding: 4px 10px;
                        border-radius: 12px;
                        text-transform: uppercase;
                        margin-bottom: 15px;
                    }

                    h3 {
                        font-size: clamp(22px, 4vw, 32px);
                        color: var(--color-blanco);
                        text-transform: uppercase;
                        margin-bottom: 10px;
                        line-height: 1.1;
                    }

                    p {
                        font-family: Arial, sans-serif;
                        color: #aaa;
                        font-size: clamp(13px, 1.5vw, 15px);
                        line-height: 1.6;
                        margin-bottom: 25px;
                        max-width: 500px;
                    }

                    .btn-unlock {
                        background: transparent;
                        color: var(--color-principal);
                        padding: clamp(10px, 1.5vw, 12px) clamp(15px, 2vw, 25px);
                        font-size: clamp(11px, 1.2vw, 13px);
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
                            width: clamp(16px, 1.8vw, 18px);
                            height: clamp(16px, 1.8vw, 18px);
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

        /* --- FOOTER (CON NESTING) --- */
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

                        p {
                            max-width: 250px;
                        }
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
                                font-size: clamp(12px, 1vw, 14px);
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
                font-size: clamp(10px, 1vw, 12px);
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

        /* =========================================================================
           --- MEDIA QUERIES (DISEÑO RESPONSIVE Y MENÚ MÓVIL) ---
           ========================================================================= */

        @media (max-width: 1024px) {
            .media-carousel-section .carousel-container .media-item {
                flex: 0 0 calc(50% - 10px); 
            }
        }

        @media (max-width: 768px) {
            .desktop-nav { display: none; }

            #nav-icon {
                display: block;
                width: 30px;
                height: 22px;
                position: relative;
                cursor: pointer;
                z-index: 1001; 
                
                span {
                    display: block;
                    position: absolute;
                    height: 3px;
                    width: 100%;
                    background: var(--color-principal); 
                    border-radius: 3px;
                    opacity: 1;
                    left: 0;
                    transition: 0.25s ease-in-out, background-color 0.3s ease;
                    
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
                display: flex;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100vh;
                background-color: var(--color-negro);
                z-index: 1000;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                opacity: 0;
                pointer-events: none;
                transition: opacity 0.4s ease;

                &.grow {
                    opacity: 1;
                    pointer-events: auto;
                }

                .menu-mobile-close {
                    position: absolute;
                    top: clamp(20px, 4vw, 30px);
                    right: clamp(20px, 5vw, 30px);
                    background: none;
                    border: none;
                    color: var(--color-blanco);
                    font-size: clamp(45px, 8vw, 60px);
                    cursor: pointer;
                    z-index: 1002;
                    line-height: 1;
                    transition: color 0.3s ease, transform 0.3s ease;

                    &:hover {
                        color: var(--color-principal);
                        transform: scale(1.1);
                    }
                }

                .mobile-logo-container {
                    margin-bottom: 40px;
                    opacity: 0;
                    transform: translateY(-20px);
                    
                    img { height: 60px; }
                }

                .menu_mobile_nav {
                    list-style: none;
                    text-align: center;
                    padding: 0;

                    li {
                        margin: 20px 0;
                        opacity: 0;
                        transform: translateY(20px);

                        a, .logout-btn-mobile {
                            color: var(--color-blanco);
                            text-decoration: none;
                            font-size: clamp(20px, 5vw, 24px);
                            font-weight: 900;
                            text-transform: uppercase;
                            letter-spacing: 2px;
                            transition: color 0.3s ease;

                            &:hover {
                                color: var(--color-principal); 
                            }
                        }
                    }
                }
            }

            /* --- Adaptación del Hero de Película al Móvil --- */
            .movie-hero {
                padding-top: 120px; 
                min-height: auto; 
                padding-bottom: 40px;

                .movie-content {
                    flex-direction: column;
                    text-align: center;
                    gap: 25px; 

                    .movie-poster {
                        width: 150px; 
                        margin: 0 auto;
                        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.8);
                    }

                    .movie-info {
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        
                        .movie-meta {
                            justify-content: center;
                            gap: 10px; 
                        }

                        .action-buttons {
                            justify-content: center;
                        }
                    }
                }
            }

            /* Carrusel móvil - 1 elemento por vista */
            .media-carousel-section .carousel-container .media-item {
                flex: 0 0 100%; 
            }

            /* Exclusivo móvil */
            .exclusive-movie-menu .exclusive-banner {
                flex-direction: column;
                text-align: center;
                gap: 20px;

                .exclusive-img-container {
                    width: 100%;
                    height: auto;
                    aspect-ratio: 16/9;
                }

                .exclusive-info {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                }
            }

            /* Footer móvil */
            footer {
                .footer-content {
                    flex-direction: column;
                    text-align: center;

                    .footer-col:first-child {
                        align-items: center;
                    }
                }
                .footer-bottom {
                    flex-direction: column;
                    gap: 15px;
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
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 7h14a2 2 0 0 1 2 2v1.5a1.5 1.5 0 0 0 0 3V15a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-1.5a1.5 1.5 0 0 0 0-3V9a2 2 0 0 1 2-2z"></path>
                                <line x1="8" y1="7" x2="8" y2="17" stroke-dasharray="2 2"></line>
                            </svg>
                            BUY TICKETS
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
                            <div class="media-item" onclick="openModal({{ $loop->index }}, 'video', '{{ $media['url'] }}', '{{ $media['thumbnail'] }}')">
                                <img src="{{ $media['thumbnail'] }}" alt="Trailer Thumbnail" onerror="this.src='https://via.placeholder.com/400x225/111/ffd000?text=Video+Not+Found'">
                                <div class="play-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                                </div>
                            </div>
                        @else
                            <div class="media-item" onclick="openModal({{ $loop->index }}, 'image', '{{ $media['url'] }}')">
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

    <section style="padding: clamp(40px, 6vw, 60px) 5%; background-color: var(--color-negro); text-align: center; border-top: 1px solid #222;">
        <h2 style="color: var(--color-principal); font-size: clamp(24px, 4vw, 32px); margin-bottom: 15px; text-transform: uppercase;">Join the Conversation</h2>
        <p style="color: #aaa; margin-bottom: 30px; font-size: clamp(14px, 1.5vw, 16px);">What did you think of {{ $movie['title'] }}? Read theories, share your thoughts, and connect with other moviegoers.</p>
        <button onclick="window.location.href='/community'" style="background: var(--color-principal); color: var(--color-texto-btn); padding: clamp(12px, 1.5vw, 15px) clamp(25px, 4vw, 40px); border: none; border-radius: 30px; font-weight: 900; font-size: clamp(12px, 1.2vw, 14px); cursor: pointer; text-transform: uppercase; transition: transform 0.2s;">
            Go to Community Thread
        </button>
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

    <div id="mediaModal" class="media-modal">
        <button class="media-modal-close" onclick="closeModal()">&times;</button>
        
        <button class="modal-nav-btn prev" onclick="moveModalCarousel(-1)" title="Previous">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
        </button>
        
        <div class="media-modal-content" id="modalContent" onclick="event.stopPropagation()">
            </div>
        
        <button class="modal-nav-btn next" onclick="moveModalCarousel(1)" title="Next">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
        </button>
    </div>

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

        let modalMediaData = []; 
        let modalCurrentIndex = 0; 

        function openModal(index, type, url, thumbnail = '') {
            const modal = document.getElementById('mediaModal');
            modalCurrentIndex = index; 
            
            if (modalMediaData.length === 0) {
                collectModalData();
            }
            
            if (modalMediaData.length <= 1) {
                modal.classList.add('single-item');
            } else {
                modal.classList.remove('single-item');
            }

            renderModalContent(); 
            modal.classList.add('active'); 
            
            document.body.style.overflow = 'hidden';
            
            modal.addEventListener('click', closeModalOutside);
            document.addEventListener('keydown', handleEsc);
        }
        
        let isDataCollected = false;
        function collectModalData() {
            if(!isDataCollected) {
                modalMediaData = [];
                const track = document.getElementById('media-track');
                const originalItems = track.querySelectorAll('.media-item');
                
                originalItems.forEach((item, i) => {
                    const onclickStr = item.getAttribute('onclick');
                    const match = onclickStr.match(/openModal\(\s*\d+\s*,\s*'([^']+)'\s*,\s*'([^']+)'(?:,\s*'([^']*)')?\s*\)/);
                    
                    if (match) {
                        modalMediaData.push({
                            type: match[1],
                            url: match[2],
                            thumbnail: match[3] || ''
                        });
                    }
                });
                isDataCollected = true;
            }
        }

        function renderModalContent() {
            const container = document.getElementById('modalContent');
            container.innerHTML = ''; 
            
            if (modalMediaData.length === 0) return;
            
            const item = modalMediaData[modalCurrentIndex];

            if (item.type === 'video') {
                let embedUrl = item.url;
                const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
                const match = item.url.match(regExp);
                if (match && match[2].length === 11) {
                    embedUrl = 'https://www.youtube.com/embed/' + match[2] + '?autoplay=1&rel=0&modestbranding=1';
                }
                container.innerHTML = `<iframe src="${embedUrl}" allow="autoplay; encrypted-media" allowfullscreen></iframe>`;
            } else {
                container.innerHTML = `<img src="${item.url}" alt="Media Viewer ${modalCurrentIndex + 1}">`;
            }
        }

        function moveModalCarousel(direction) {
            if (modalMediaData.length <= 1) return; 
            
            const total = modalMediaData.length;
            modalCurrentIndex = (modalCurrentIndex + direction + total) % total;
            
            const container = document.getElementById('modalContent');
            container.style.opacity = '0';
            container.style.transition = 'opacity 0.15s ease';
            
            setTimeout(() => {
                renderModalContent(); 
                container.style.opacity = '1'; 
            }, 150);
        }

        function closeModal() {
            const modal = document.getElementById('mediaModal');
            const container = document.getElementById('modalContent');
            modal.classList.remove('active');
            
            setTimeout(() => {
                container.innerHTML = ''; 
                document.body.style.overflow = ''; 
            }, 300); 

            modal.removeEventListener('click', closeModalOutside);
            document.removeEventListener('keydown', handleEsc);
        }
        
        function closeModalOutside(e) {
            if (e.target.id === 'mediaModal') {
                closeModal();
            }
        }
        
        function handleEsc(e) {
            if (e.key === 'Escape') closeModal();
            if (e.key === 'ArrowRight') moveModalCarousel(1);
            if (e.key === 'ArrowLeft') moveModalCarousel(-1);
        }

        // Lógica de Carrusel Infinito y Auto-Play
        document.addEventListener('DOMContentLoaded', () => {
            const track = document.getElementById('media-track');
            
            if(!track) return; 

            const items = Array.from(track.children);
            const totalOriginals = items.length;
            
            if (totalOriginals === 0) return;
            
            items.forEach(item => {
                let clone = item.cloneNode(true);
                track.appendChild(clone);
            });
            
            items.slice().reverse().forEach(item => {
                let clone = item.cloneNode(true);
                track.insertBefore(clone, track.firstChild);
            });

            let currentIndex = totalOriginals;
            let isTransitioning = false;

            function updatePosition() {
                const itemElement = track.querySelector('.media-item');
                if(!itemElement) return;

                const gap = 20; 
                const itemWidth = itemElement.getBoundingClientRect().width + gap;
                track.style.transition = 'none';
                track.style.transform = `translateX(-${currentIndex * itemWidth}px)`;
            }

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
                }, 3500); 
            }

            resetAutoPlay();
        });
    </script>
    
    <script src="{{ asset('js/hamburguer.js') }}"></script>

</body>
</html>