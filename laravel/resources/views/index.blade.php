<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Screenbites Cinema - Home</title>
    
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
            background-color: var(--color-negro);
            color: var(--color-blanco);
            width: 100%;
            margin: 0;
            padding: 0;

            &.menu-open {
                overflow: hidden;
            }
        }

        /* Ocultar el icono hamburguesa y el menú móvil en escritorio por defecto */
        #nav-icon, .menu_mobile {
            display: none;
        }

        /* --- HERO BACKGROUND --- */
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

            &.fade {
                opacity: 0.2;
            }
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
            z-index: 100002;
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
                            color: var(--color-amarillo) !important;
                            text-shadow: 0px 2px 10px rgba(0, 0, 0, 1), 0px 0px 4px rgba(0, 0, 0, 1) !important;
                        }
                    }
                }
            }
        }

        /* --- CUANDO EL MENÚ MÓVIL ESTÁ ABIERTO --- */
        body.menu-open header {
            background-color: transparent !important;
            backdrop-filter: none !important;
            box-shadow: none !important;
            border-bottom: none !important;

            .logo {
                opacity: 0;
                pointer-events: none;
                transition: opacity 0.3s ease;
            }

            #nav-icon span {
                background: var(--color-blanco) !important;
            }
        }

        /* --- HERO SECTION (CON NESTING Y OVERFLOW) --- */
        .hero {
            height: 100vh;
            display: flex;
            align-items: center;
            padding: 0 clamp(3%, 5vw, 5%);
            position: relative;
            color: var(--color-negro);
            transition: color 0.4s ease;
            overflow: hidden; 

            .hero-container {
                display: flex;
                width: 100%;
                justify-content: space-between;
                align-items: flex-end;
                padding-bottom: 5vh;
                position: relative;
                z-index: 10;

                .hero-info {
                    width: 45%;

                    .title-wrapper {
                        display: flex;
                        align-items: flex-end;
                        gap: clamp(10px, 2vw, 20px);

                        .number {
                            font-size: clamp(60px, 10vw, 150px);
                            font-weight: 100;
                            font-family: Arial, sans-serif;
                            color: transparent;
                            -webkit-text-stroke: 2px currentColor;
                            line-height: 0.75;
                            transition: all 0.3s ease;
                        }

                        .title-details {
                            padding-bottom: clamp(2px, 0.5vw, 5px);
                            width: 100%;

                            h1 {
                                font-size: clamp(18px, 3vw, 50px);
                                margin: 0 0 5px 0;
                                font-weight: 900;
                                display: flex;
                                align-items: center;
                                flex-wrap: wrap;
                                gap: clamp(8px, 1.5vw, 15px);
                                letter-spacing: -1px;
                                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);

                                .age-rating {
                                    font-size: clamp(10px, 1.2vw, 14px);
                                    border: 2px solid currentColor;
                                    padding: 3px 8px;
                                    border-radius: 4px;
                                    letter-spacing: 1px;
                                    text-shadow: none;
                                }
                            }

                            .stars {
                                display: flex;
                                align-items: center;
                                gap: 4px;
                                margin-top: 5px;
                                filter: drop-shadow(1px 1px 2px rgba(0, 0, 0, 0.5));

                                .star-icon {
                                    width: clamp(12px, 1.5vw, 18px);
                                    height: auto;
                                }
                            }

                            .genre {
                                font-size: clamp(10px, 1.2vw, 12px);
                                margin-top: 8px;
                                font-weight: bold;
                                text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.8);
                            }
                        }
                    }

                    .hero-buttons {
                        margin-top: clamp(20px, 3vw, 40px);
                        display: flex;
                        flex-wrap: wrap;
                        gap: clamp(10px, 1.5vw, 20px);

                        .btn-primary,
                        .btn-secondary {
                            padding: clamp(10px, 1.5vw, 12px) clamp(15px, 2vw, 25px);
                            font-weight: 900;
                            font-size: clamp(10px, 1.2vw, 12px);
                            letter-spacing: 1px;
                            text-transform: uppercase;
                            cursor: pointer;
                            border-radius: 4px;
                            border: none;
                            transition: all 0.3s ease;
                            display: flex;
                            align-items: center;
                            justify-content: center;

                            &:hover {
                                transform: scale(1.05);
                            }
                        }

                        .btn-primary {
                            gap: 10px;
                            svg { width: clamp(16px, 1.8vw, 20px); height: auto; }
                        }

                        .btn-secondary {
                            background: transparent;
                            border: 2px solid currentColor;
                            color: inherit;
                            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
                        }
                    }
                }

                .hero-slider-section {
                    width: 45%;
                    position: relative;
                    height: clamp(250px, 40vw, 400px);

                    .custom-slider {
                        position: relative;
                        width: 100%;
                        height: 100%;

                        .slide-item {
                            position: absolute;
                            top: 50%;
                            left: 50%;
                            width: clamp(120px, 20vw, 220px);
                            transition: all 0.5s cubic-bezier(0.25, 0.8, 0.25, 1);
                            pointer-events: none;

                            img.poster-img {
                                width: 100%;
                                border-radius: 4px;
                                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
                                border: 4px solid transparent;
                                transition: border-color 0.3s ease;
                                background-color: #111;
                                object-fit: cover;
                            }

                            &.active {
                                transform: translate(-50%, -60%) scale(1.15);
                                opacity: 1;
                                z-index: 10;
                                pointer-events: auto;

                                .progress-track { opacity: 1; }
                                .progress-fill { animation: fillBar 6s linear forwards; }
                            }

                            &.prev {
                                transform: translate(-140%, -50%) scale(0.85);
                                opacity: 0.5;
                                z-index: 5;
                                pointer-events: auto;
                                cursor: pointer;
                            }

                            &.next {
                                transform: translate(40%, -50%) scale(0.85);
                                opacity: 0.5;
                                z-index: 5;
                                pointer-events: auto;
                                cursor: pointer;
                            }

                            &.hidden-left {
                                transform: translate(-250%, -50%) scale(0.5);
                                opacity: 0;
                                z-index: 1;
                            }

                            &.hidden-right {
                                transform: translate(150%, -50%) scale(0.5);
                                opacity: 0;
                                z-index: 1;
                            }

                            .progress-track {
                                position: absolute;
                                bottom: -15px; left: 0;
                                width: 100%; height: 4px;
                                background: rgba(128, 128, 128, 0.3);
                                border-radius: 2px;
                                opacity: 0;
                                transition: opacity 0.3s ease;

                                .progress-fill {
                                    height: 100%; width: 0%;
                                    background: currentColor;
                                    border-radius: 2px;
                                }
                            }
                        }
                    }

                    .hero-navigation {
                        position: absolute;
                        bottom: -40px;
                        width: 100%;
                        display: flex;
                        justify-content: center;
                        gap: 25px;
                        z-index: 20;

                        .nav-btn {
                            background: transparent;
                            border: none;
                            color: inherit;
                            cursor: pointer;
                            transition: all 0.3s ease;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            padding: 10px;
                            opacity: 1;

                            svg {
                                width: clamp(24px, 3vw, 32px);
                                height: clamp(24px, 3vw, 32px);
                                stroke-width: 3;
                                transition: transform 0.3s ease;
                            }

                            &:hover { transform: scale(1.15); }
                            &#btn-prev:hover svg { transform: translateX(-5px); }
                            &#btn-next:hover svg { transform: translateX(5px); }
                        }
                    }
                }
            }
        }

        @keyframes fillBar {
            0% { width: 0%; }
            100% { width: 100%; }
        }

        /* --- MOVIES SECTION --- */
        .movies-section {
            padding: clamp(50px, 8vw, 80px) 5%;
            background-color: var(--color-gris-oscuro);
            display: flex;
            flex-direction: column;
            align-items: center;

            .movies-container {
                width: 100%;
                max-width: 1300px;
                margin-bottom: clamp(40px, 6vw, 60px);

                .row-header {
                    display: flex;
                    justify-content: space-between;
                    align-items: flex-end;
                    margin-bottom: clamp(20px, 3vw, 30px);
                    border-bottom: 1px solid var(--color-gris-claro);
                    padding-bottom: 15px;

                    .row-title {
                        font-size: clamp(22px, 3vw, 30px);
                        font-weight: 900;
                        text-transform: uppercase;
                        letter-spacing: -1px;
                        color: var(--color-blanco);
                        border-left: 5px solid var(--color-amarillo);
                        padding-left: 15px;
                        line-height: 1;
                    }
                }

                .movies-grid-full {
                    display: grid;
                    grid-template-columns: repeat(5, 1fr);
                    gap: clamp(15px, 2vw, 20px);
                    width: 100%;

                    .movie-card {
                        position: relative;
                        border-radius: 6px;
                        overflow: hidden;
                        background-color: var(--color-negro);
                        transition: transform 0.3s ease, box-shadow 0.3s ease;

                        img {
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
                            font-size: clamp(9px, 1vw, 11px);
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
                            padding: clamp(15px, 2vw, 20px);
                            text-align: center;
                            z-index: 4;
                            pointer-events: none;

                            .movie-card-title {
                                font-size: clamp(14px, 1.8vw, 18px);
                                margin-bottom: 5px;
                                color: var(--color-blanco);
                                line-height: 1.1;
                                cursor: pointer;
                            }

                            .movie-card-genre {
                                font-size: clamp(10px, 1vw, 11px);
                                color: var(--color-amarillo);
                                font-family: Arial, sans-serif;
                                margin-bottom: 15px;
                            }

                            .btn-card {
                                background: var(--color-amarillo);
                                color: var(--color-negro);
                                padding: clamp(8px, 1vw, 10px);
                                font-size: clamp(9px, 1vw, 11px);
                                font-weight: 900;
                                text-transform: uppercase;
                                border: none;
                                border-radius: 4px;
                                cursor: pointer;
                                letter-spacing: 1px;
                                transition: background 0.2s;
                                width: 100%;
                                pointer-events: auto;

                                &:hover {
                                    background: #ffffff;
                                    color: black;
                                    border-color: transparent;
                                }

                                &.btn-outline {
                                    background: transparent;
                                    color: var(--color-blanco);
                                    border: 2px solid var(--color-blanco);
                                    margin-top: 5px;
                                }
                            }
                        }

                        &:hover {
                            transform: translateY(-8px);
                            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.9);
                            z-index: 2;

                            .movie-card-overlay {
                                opacity: 1;
                                pointer-events: auto;
                            }
                        }
                    }
                }
            }
        }

        /* --- FOOD SECTION --- */
        .food-section {
            padding: clamp(50px, 8vw, 80px) 5%;
            background-color: var(--color-negro);
            display: flex;
            flex-direction: column;
            align-items: center;
            border-top: 1px solid #222;

            .food-container {
                width: 100%;
                max-width: 1200px;

                .food-header {
                    text-align: center;
                    margin-bottom: clamp(30px, 5vw, 50px);

                    h2 {
                        font-size: clamp(28px, 4vw, 40px);
                        color: var(--color-blanco);
                        text-transform: uppercase;
                        letter-spacing: -1px;
                        margin-bottom: 10px;

                        span { color: var(--color-amarillo); }
                    }

                    p {
                        font-family: Arial, sans-serif;
                        color: #888888;
                        font-size: clamp(14px, 1.5vw, 16px);
                        max-width: 600px;
                        margin: 0 auto;
                    }
                }

                .food-grid {
                    display: grid;
                    grid-template-columns: repeat(3, 1fr);
                    gap: clamp(20px, 3vw, 30px);
                    margin-bottom: clamp(40px, 6vw, 60px);

                    .food-card {
                        background-color: var(--color-gris-tarjeta);
                        border-top: 4px solid var(--color-amarillo);
                        padding: clamp(20px, 3vw, 40px) clamp(15px, 2vw, 30px);
                        border-radius: 6px;

                        .food-card-header {
                            display: flex;
                            align-items: center;
                            gap: 15px;
                            margin-bottom: 30px;
                            border-bottom: 1px solid #333;
                            padding-bottom: 15px;

                            .food-icon-img {
                                width: clamp(28px, 3vw, 35px);
                                height: clamp(28px, 3vw, 35px);
                                object-fit: contain;
                            }

                            h3 {
                                color: var(--color-blanco);
                                text-transform: uppercase;
                                letter-spacing: 1px;
                                font-size: clamp(16px, 2vw, 20px);
                                margin: 0;
                            }
                        }

                        ul {
                            list-style: none;

                            li {
                                display: flex;
                                justify-content: space-between;
                                align-items: center;
                                margin-bottom: 15px;
                                font-family: Arial, sans-serif;
                                font-size: clamp(13px, 1.2vw, 15px);
                                border-bottom: 1px dashed #222;
                                padding-bottom: 10px;
                                color: #cccccc;

                                .price-tag {
                                    background-color: #222;
                                    color: var(--color-amarillo);
                                    font-weight: bold;
                                    padding: 4px 8px;
                                    border-radius: 4px;
                                    font-size: clamp(11px, 1vw, 13px);
                                    border: 1px solid #444;
                                }
                            }
                        }
                    }
                }

                .exclusive-section {
                    width: 100%;
                    background: linear-gradient(135deg, #1a1a1a 0%, #000000 100%);
                    border-radius: 8px;
                    border: 1px solid #333;
                    padding: clamp(30px, 5vw, 50px);
                    position: relative;
                    overflow: hidden;

                    &::before {
                        content: '';
                        position: absolute;
                        top: -50px;
                        right: -50px;
                        width: 150px;
                        height: 150px;
                        background: var(--color-amarillo);
                        filter: blur(100px);
                        opacity: 0.1;
                    }

                    .exclusive-title {
                        text-align: center;
                        margin-bottom: 40px;
                        position: relative;
                        z-index: 2;

                        h3 {
                            font-size: clamp(22px, 3vw, 30px);
                            color: var(--color-amarillo);
                            text-transform: uppercase;
                            margin-bottom: 10px;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            gap: 10px;

                            svg {
                                width: clamp(22px, 2.5vw, 28px);
                                height: clamp(22px, 2.5vw, 28px);
                            }
                        }

                        p {
                            color: #aaa;
                            font-family: Arial, sans-serif;
                            font-size: clamp(13px, 1.2vw, 15px);
                        }
                    }

                    .exclusive-grid {
                        display: grid;
                        grid-template-columns: repeat(3, 1fr);
                        gap: clamp(15px, 2vw, 20px);
                        position: relative;
                        z-index: 2;

                        .exclusive-card {
                            background-color: #0a0a0a;
                            border: 1px solid #333;
                            border-radius: 8px;
                            overflow: hidden;
                            transition: transform 0.3s ease, border-color 0.3s;
                            text-align: center;
                            padding-bottom: 20px;

                            .exclusive-img {
                                width: 100%;
                                height: clamp(150px, 15vw, 200px);
                                background-color: #111;
                                object-fit: cover;
                                border-bottom: 2px solid #222;
                            }

                            h4 {
                                font-size: clamp(15px, 1.5vw, 18px);
                                color: #fff;
                                margin: 15px 0 5px;
                                text-transform: uppercase;
                            }

                            p {
                                font-size: clamp(11px, 1vw, 13px);
                                color: #888;
                                font-family: Arial, sans-serif;
                                padding: 0 15px;
                                margin-bottom: 15px;
                                height: 40px;
                            }

                            .exclusive-tag {
                                display: inline-block;
                                background-color: var(--color-amarillo);
                                color: #000;
                                font-size: 11px;
                                font-weight: bold;
                                padding: 3px 10px;
                                border-radius: 12px;
                                text-transform: uppercase;
                            }

                            &:hover {
                                transform: translateY(-5px);
                                border-color: var(--color-amarillo);
                                box-shadow: 0 10px 20px rgba(255, 208, 0, 0.1);
                            }
                        }
                    }
                }
            }
        }

        /* --- FOOTER --- */
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

                                &:hover {
                                    color: var(--color-amarillo);
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
                        color: var(--color-amarillo);
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
           --- MEDIA QUERIES (MÓVIL Y HAMBURGUESA DE 6 SPANS AL ESTILO BRASIL) ---
           ========================================================================= */

        @media (max-width: 1024px) {
            .movies-section .movies-container .movies-grid-full { grid-template-columns: repeat(3, 1fr); }
            .food-section .food-container .food-grid,
            .food-section .food-container .exclusive-section .exclusive-grid { grid-template-columns: repeat(2, 1fr); }
            .hero .hero-container .hero-info { width: 50%; }
            .hero .hero-container .hero-slider-section { width: 45%; }
        }

        @media (max-width: 900px) {
            footer .footer-content { flex-direction: column; text-align: center; }
            footer .footer-content .footer-col:first-child { align-items: center; }
            footer .footer-bottom { flex-direction: column; gap: 15px; }
        }

        @media (max-width: 768px) {
            .desktop-nav { display: none !important; }

            /* --- LA HAMBURGUESA PERFECTA (6 SPANS SIN OVERFLOW) --- */
            #nav-icon {
                display: block !important;
                width: 30px;
                height: 22px;
                position: relative;
                cursor: pointer;
                z-index: 100005; /* Siempre por encima del menú */

                span {
                    display: block;
                    position: absolute;
                    width: 50%;
                    height: 3px;
                    background: var(--header-text-color, var(--color-blanco));
                    transition: .25s ease-in-out;

                    &:nth-child(odd) { left: 0; border-radius: 3px 0 0 3px; }
                    &:nth-child(even) { left: 50%; border-radius: 0 3px 3px 0; }
                    
                    &:nth-child(1), &:nth-child(2) { top: 0px; }
                    &:nth-child(3), &:nth-child(4) { top: 9px; }
                    &:nth-child(5), &:nth-child(6) { top: 18px; }
                }

                &.open span {
                    background: var(--color-blanco) !important;
                    
                    &:nth-child(1), &:nth-child(6) { transform: rotate(45deg); }
                    &:nth-child(2), &:nth-child(5) { transform: rotate(-45deg); }
                    
                    /* Formando la X perfecta */
                    &:nth-child(1) { left: 3px; top: 5px; }
                    &:nth-child(2) { left: calc(50% - 3px); top: 5px; }
                    
                    /* MAGIA: En lugar de hacer que vuelen a los lados (causando overflow), simplemente desaparecen en su sitio */
                    &:nth-child(3), &:nth-child(4) { transform: scaleX(0); opacity: 0; }
                    
                    &:nth-child(5) { left: 3px; top: 15px; }
                    &:nth-child(6) { left: calc(50% - 3px); top: 15px; }
                }
            }

            /* --- EL MENÚ CORTINA (ALTURA DE 0 A 100VH) --- */
            .menu_mobile {
                display: flex !important;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 0; /* Empieza cerrado */
                background-color: var(--color-negro);
                z-index: 100001;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                gap: 2rem;
                overflow: hidden;
                transition: height 0.5s ease-in-out; /* Despliegue persiana */

                &.grow {
                    height: 100vh; /* Se abre entero */

                    .mobile-logo-container {
                        opacity: 1; transform: translateY(0);
                    }

                    .menu_mobile_nav li {
                        opacity: 1; transform: translateY(0);
                    }
                }

                .mobile-logo-container {
                    text-align: center;
                    opacity: 0;
                    transform: translateY(-20px);
                    transition: opacity 0.5s ease 0.2s, transform 0.5s ease 0.2s;
                    
                    img { height: 60px; margin-bottom: 1rem; }
                }

                .menu_mobile_nav {
                    list-style: none;
                    text-align: center;
                    padding: 0;
                    display: flex;
                    flex-direction: column;
                    gap: 1.5rem;

                    li {
                        opacity: 0;
                        transform: translateY(20px);
                        transition: opacity 0.5s ease, transform 0.5s ease;

                        /* Retardos en cascada como en Brasil */
                        &:nth-child(1) { transition-delay: 0.3s; }
                        &:nth-child(2) { transition-delay: 0.4s; }
                        &:nth-child(3) { transition-delay: 0.5s; }
                        &:nth-child(4) { transition-delay: 0.6s; }
                        &:nth-child(5) { transition-delay: 0.7s; }
                        &:nth-child(6) { transition-delay: 0.8s; }

                        a, .logout-btn-mobile {
                            color: var(--color-blanco);
                            text-decoration: none;
                            font-size: clamp(20px, 5vw, 24px);
                            font-weight: 900;
                            text-transform: uppercase;
                            letter-spacing: 2px;
                            transition: color 0.3s ease, transform 0.3s ease;
                            background: none;
                            border: none;
                            cursor: pointer;
                            padding: 0;
                            font-family: inherit;
                            display: inline-block;

                            &:hover {
                                color: var(--color-amarillo);
                                transform: scale(1.1);
                            }
                        }
                    }
                }
            }

            .hero {
                height: auto;
                min-height: 100vh;
                padding-top: clamp(80px, 12vw, 120px);

                .hero-container {
                    flex-direction: column;
                    align-items: center;
                    gap: clamp(40px, 8vw, 80px);
                    text-align: center;

                    .hero-info, .hero-slider-section { width: 100%; }

                    .hero-info {
                        .title-wrapper {
                            flex-direction: column;
                            align-items: center;
                            gap: 5px;

                            .title-details h1 { justify-content: center; }
                            .stars { justify-content: center; }
                        }
                        .hero-buttons { justify-content: center; }
                    }
                }
            }

            .food-section .food-container {
                .food-grid, .exclusive-section .exclusive-grid {
                    grid-template-columns: 1fr;
                }
            }
        }

        @media (max-width: 480px) {
            .movies-section .movies-container .movies-grid-full {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <main class="hero" id="main-hero">
        <img src="{{ count($movies) > 0 ? $movies[0]['bgImg'] : asset('img/1-Kill-Bill/Portada.png') }}" alt="Background Image" class="hero-bg" id="hero-bg">

        <header id="main-header">
            <div class="logo"><img src="{{ asset('img/img/Logo-Negro.png') }}" alt="Cinema Logo" id="main-logo"></div>
            
            <nav class="desktop-nav">
                <ul>
                    <li><a href="#main-hero">HOME</a></li>
                    <li><a href="#cartelera">FILMS</a></li>
                    <li><a href="#bar">MENUS</a></li>
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
                <span></span><span></span><span></span><span></span><span></span><span></span>
            </div>
        </header>

        <div class="menu_mobile">
            <div class="mobile-logo-container">
                <img src="{{ asset('img/img/Logo-Blanco.png') }}" alt="Cinema Logo">
            </div>
            <ul class="menu_mobile_nav">
                <li><a href="#main-hero">HOME</a></li>
                <li><a href="#cartelera">FILMS</a></li>
                <li><a href="#bar">MENUS</a></li>
                <li><a href="/community">COMMUNITY</a></li>
                
                @auth
                    <li><a href="/profile">MY PROFILE</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="logout-btn-mobile">SIGN OUT</button>
                        </form>
                    </li>
                @else
                    <li><a href="{{ route('login') }}">SIGN IN</a></li>
                    <li><a href="{{ route('register') }}">CREATE ACCOUNT</a></li>
                @endauth
            </ul>
        </div>

        @if (session('status'))
        <div id="toast-message" style="position: fixed; top: 120px; right: 5%; background-color: var(--color-amarillo); color: var(--color-negro); padding: 15px 25px; border-radius: 6px; font-weight: 900; text-transform: uppercase; letter-spacing: 1px; z-index: 9999; box-shadow: 0 10px 30px rgba(0,0,0,0.8); animation: slideIn 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);">
            <div style="display: flex; align-items: center; gap: 10px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                @if(session('status') === 'profile-updated')
                    Profile updated successfully!
                @else
                    {{ session('status') }}
                @endif
            </div>
        </div>

        <style>
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
        </style>

        <script>
            setTimeout(() => {
                const toast = document.getElementById('toast-message');
                if(toast) {
                    toast.style.transition = 'all 0.5s ease';
                    toast.style.transform = 'translateX(100%)';
                    toast.style.opacity = '0';
                    setTimeout(() => toast.remove(), 500);
                }
            }, 4000);
        </script>
        @endif

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
                    <button class="btn-primary" id="btn-buy" onclick="window.location.href='/booking/01'">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="ticket-icon">
                            <path d="M5 7h14a2 2 0 0 1 2 2v1.5a1.5 1.5 0 0 0 0 3V15a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-1.5a1.5 1.5 0 0 0 0-3V9a2 2 0 0 1 2-2z"></path>
                            <line x1="8" y1="7" x2="8" y2="17" stroke-dasharray="2 2"></line>
                        </svg> 
                        BUY TICKETS
                    </button>
                    <button class="btn-secondary" id="btn-view-film">VIEW FILM</button>
                </div>
            </div>
            <div class="hero-slider-section">
                <div class="custom-slider" id="slider-track"></div>
                <div class="hero-navigation">
                    <button class="nav-btn" id="btn-prev" title="Previous">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="15 18 9 12 15 6"></polyline>
                        </svg>
                    </button>
                    <button class="nav-btn" id="btn-next" title="Next">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </button>
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

        <div class="movies-container" style="margin-top: clamp(20px, 4vw, 40px);">
            <div class="row-header">
                <h2 class="row-title">Coming Soon</h2>
            </div>
            <div class="movies-grid-full" id="coming-soon-grid"></div>
        </div>
    </section>

    <section class="food-section" id="bar">
        <div class="food-container">
            <div class="food-header">
                <h2>Explore the <span>Menu</span></h2>
                <p>Discover our delicious snacks and drinks. You can add them to your order during the seat selection
                    process.</p>
            </div>

            <div class="food-grid">

                <div class="food-card">
                    <div class="food-card-header">
                        <img src="{{ asset('img/svg/popcorn.svg') }}" alt="Popcorn Icon" class="food-icon-img">
                        <h3>Popcorn & Food</h3>
                    </div>
                    <ul>
                        <li>Classic Salted Popcorn (M) <span class="price-tag">$5.50</span></li>
                        <li>Classic Salted Popcorn (L) <span class="price-tag">$7.00</span></li>
                        <li>Extra Butter Popcorn (L) <span class="price-tag">$8.00</span></li>
                        <li>Sweet Caramel Popcorn (M) <span class="price-tag">$6.50</span></li>
                        <li>Family Mega Bucket <span class="price-tag">$9.50</span></li>
                        <li>Classic Hot Dog <span class="price-tag">$5.00</span></li>
                        <li>XXL Cheese Hot Dog <span class="price-tag">$6.50</span></li>
                        <li>Extra Cheese Nachos <span class="price-tag">$6.50</span></li>
                        <li>Pepperoni Pizza Slice <span class="price-tag">$4.00</span></li>
                    </ul>
                </div>

                <div class="food-card">
                    <div class="food-card-header">
                        <img src="{{ asset('img/svg/drinks.svg') }}" alt="Drinks Icon" class="food-icon-img">
                        <h3>Fresh Drinks</h3>
                    </div>
                    <ul>
                        <li>Coca-Cola / Zero (M) <span class="price-tag">$4.00</span></li>
                        <li>Coca-Cola / Zero (L) <span class="price-tag">$5.50</span></li>
                        <li>Fanta Orange (M) <span class="price-tag">$4.00</span></li>
                        <li>Sprite (L) <span class="price-tag">$5.50</span></li>
                        <li>Blue Icee Slush <span class="price-tag">$5.00</span></li>
                        <li>Cherry Icee Slush <span class="price-tag">$5.00</span></li>
                        <li>Bottled Mineral Water <span class="price-tag">$3.00</span></li>
                        <li>Craft Beer (IPA) <span class="price-tag">$6.50</span></li>
                        <li>Hot Coffee / Tea <span class="price-tag">$3.50</span></li>
                    </ul>
                </div>

                <div class="food-card">
                    <div class="food-card-header">
                        <img src="{{ asset('img/svg/sweets.svg') }}" alt="Sweets Icon" class="food-icon-img">
                        <h3>Snacks & Sweets</h3>
                    </div>
                    <ul>
                        <li>Pretzel Bites <span class="price-tag">$4.50</span></li>
                        <li>Chocolate M&M's Bag <span class="price-tag">$3.50</span></li>
                        <li>Skittles Bag <span class="price-tag">$3.50</span></li>
                        <li>Gummy Bears <span class="price-tag">$3.00</span></li>
                        <li>Crispy Maltesers <span class="price-tag">$3.50</span></li>
                        <li>Lacasitos <span class="price-tag">$3.00</span></li>
                        <li>Red Licorice <span class="price-tag">$2.50</span></li>
                        <li>Snickers Bar <span class="price-tag">$2.50</span></li>
                        <li>Classic Magnum Ice Cream <span class="price-tag">$4.00</span></li>
                    </ul>
                </div>
            </div>

            <div class="exclusive-section">
                <div class="exclusive-title">
                    <h3><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polygon
                                points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                            </polygon>
                        </svg> Exclusive Collectibles</h3>
                    <p>Unlock these limited edition combos when purchasing a ticket for their respective movie.</p>
                </div>

                <div class="exclusive-grid">
                    <div class="exclusive-card">
                        <img src="{{ asset('img/1-Kill-Bill/kill-bill.jpeg') }}" class="exclusive-img">
                        <h4>Vengeance Combo</h4>
                        <p>Yellow suit design popcorn bucket + XL Katana Cup.</p>
                        <span class="exclusive-tag">Kill Bill Only</span>
                    </div>

                    <div class="exclusive-card">
                        <img src="{{ asset('img/4-Oppenheimer/oppenheimer.png') }}" class="exclusive-img">
                        <h4>Atomic Combo</h4>
                        <p>Extra Spicy Popcorn + Limited Edition Black Soda.</p>
                        <span class="exclusive-tag">Oppenheimer Only</span>
                    </div>

                    <div class="exclusive-card">
                        <img src="{{ asset('img/9-Barbie/barbie.png') }}" class="exclusive-img">
                        <h4>Dreamhouse Snack</h4>
                        <p>Sparkly pink bucket with sweet popcorn + Cotton Candy Drink.</p>
                        <span class="exclusive-tag">Barbie Only</span>
                    </div>
                </div>
            </div>

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
        const movies = @json($movies);
        const comingSoonMovies = @json($comingSoonMovies);

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
            if (totalMovies === 0) return;
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

        if (totalMovies > 0) {
            movies.forEach((movie, index) => {
                const slideDiv = document.createElement('div');
                slideDiv.classList.add('slide-item');
                slideDiv.innerHTML = `<img src="${movie.poster}" alt="${movie.title}" class="poster-img" onerror="this.src='https://via.placeholder.com/280x420/111/ffd000?text=Poster'"><div class="progress-track"><div class="progress-fill"></div></div>`;
                slideDiv.addEventListener('click', () => {
                    if (slideDiv.classList.contains('prev')) moveSlider(-1);
                    if (slideDiv.classList.contains('next')) moveSlider(1);
                });
                sliderTrack.appendChild(slideDiv);

                const npCard = document.createElement('div');
                npCard.classList.add('movie-card');
                npCard.innerHTML = `
                    <img src="${movie.poster}" alt="${movie.title}" onerror="this.src='https://via.placeholder.com/280x420/111/ffd000?text=Poster'" onclick="window.location.href='/pelicula/${movie.id}'">
                    <div class="movie-card-overlay">
                        <h4 class="movie-card-title" onclick="window.location.href='/pelicula/${movie.id}'">${movie.title}</h4>
                        <p class="movie-card-genre">${movie.genre}</p>
                        <button class="btn-card" onclick="window.location.href='/booking/${movie.id}'">Buy Tickets</button>
                        <button class="btn-card btn-outline" style="margin-top:8px;" onclick="window.location.href='/pelicula/${movie.id}'">More Info</button>
                    </div>
                `;
                nowPlayingGrid.appendChild(npCard);
            });
        }

        if (comingSoonMovies.length > 0) {
            comingSoonMovies.forEach((movie) => {
                const csCard = document.createElement('div');
                csCard.classList.add('movie-card');
                csCard.innerHTML = `
                    <div class="date-badge">${movie.date}</div>
                    <img src="${movie.poster}" alt="${movie.title}" onerror="this.src='https://via.placeholder.com/280x420/111/ffd000?text=Poster'" onclick="window.location.href='/pelicula/${movie.id}'">
                    <div class="movie-card-overlay">
                        <h4 class="movie-card-title" onclick="window.location.href='/pelicula/${movie.id}'">${movie.title}</h4>
                        <p class="movie-card-genre">${movie.genre}</p>
                        <button class="btn-card btn-outline" onclick="window.location.href='/pelicula/${movie.id}'">More Info</button>
                    </div>
                `;
                comingSoonGrid.appendChild(csCard);
            });
        }

        const slides = document.querySelectorAll('.slide-item');

        function updateCarousel() {
            if (totalMovies === 0) return;
            
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

            const isBlackStar = activeMovie.textColor === "black";
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

            const btnBuyHero = document.getElementById('btn-buy');
            btnBuyHero.setAttribute('onclick', `window.location.href='/booking/${activeMovie.id}'`);

            if (color === 'white') {
                btnBuyHero.style.background = '#ffffff';
                btnBuyHero.style.color = '#000000';
            } else {
                btnBuyHero.style.background = '#000000';
                btnBuyHero.style.color = '#ffffff'; 
            }

            const btnViewHero = document.getElementById('btn-view-film');
            btnViewHero.onclick = function () {
                window.location.href = '/pelicula/' + activeMovie.id;
            };

            if (!headerEl.classList.contains('scrolled')) {
                headerEl.style.setProperty('--header-text-color', color);
                logoEl.src = color === "white" ? "{{ asset('img/img/Logo-Blanco.png') }}" : "{{ asset('img/img/Logo-Negro.png') }}";
            }
        }

        function moveSlider(direction) {
            if (totalMovies === 0) return;
            currentIndex = (currentIndex + direction + totalMovies) % totalMovies;
            updateCarousel();
            resetAutoPlay();
        }

        function resetAutoPlay() {
            if (totalMovies === 0) return;
            clearInterval(autoPlayTimer);
            autoPlayTimer = setInterval(() => { moveSlider(1); }, AUTO_PLAY_DELAY);
        }

        document.getElementById('btn-prev').addEventListener('click', () => moveSlider(-1));
        document.getElementById('btn-next').addEventListener('click', () => moveSlider(1));

        if (totalMovies > 0) {
            updateCarousel();
            resetAutoPlay();
        }
    </script>
    
    <script src="{{ asset('js/hamburguer.js') }}"></script>
</body>

</html>