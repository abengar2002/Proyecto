<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket VIP - Screenbites</title>
    <style>
        /* Estilos Base - Refinados */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; /* Fuente más limpia para el cuerpo */
            background-color: #f4f4f4; /* Fondo gris muy suave para los clientes de correo */
            -webkit-font-smoothing: antialiased;
        }

        /* Contenedor Principal del Ticket - Con Brillo Dorado */
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #000000; /* Negro profundo */
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid #ffd000; /* Borde dorado sólido */
            box-shadow: 0 10px 25px rgba(255, 208, 0, 0.15); /* Sutil brillo dorado VIP */
        }

        /* Cabecera del Ticket - Con efecto Perforado */
        .header {
            background-color: #111111; /* Negro ligeramente más claro para profundidad */
            padding: 40px 30px;
            text-align: center;
            border-bottom: 3px dashed #ffd000; /* Efecto línea discontinua / perforación */
            position: relative;
        }
        /* Pequeñas decoraciones en las esquinas para el efecto ticket */
        .header:before, .header:after {
            content: '';
            position: absolute;
            bottom: -15px;
            width: 30px; height: 30px;
            border-radius: 50%;
            background-color: #000000;
            border: 2px solid #ffd000;
            z-index: 5;
        }
        .header:before { left: -15px; }
        .header:after { right: -15px; }

        .header h1 {
            margin: 0;
            color: #ffd000;
            font-family: 'Arial Black', Gadget, sans-serif; /* Fuente bold cinematográfica */
            letter-spacing: 4px; /* Mayor espaciado para drama */
            text-transform: uppercase;
            font-size: 28px;
            text-shadow: 2px 2px 5px rgba(255, 208, 0, 0.4); /* Sombra dorada */
        }

        /* Contenido - Tipografía y Espaciado Polished */
        .content {
            padding: 50px 40px;
            text-align: center;
            color: #ffffff;
        }
        .content h2 {
            margin-top: 0;
            margin-bottom: 25px;
            color: #ffffff;
            font-size: 24px;
            font-weight: bold;
        }
        .content p {
            font-size: 16px;
            line-height: 1.8; /* Mejor legibilidad */
            color: #cccccc;
            margin-bottom: 30px;
        }

        /* Caja del Código - Integrada y Estilizada */
        .code-box {
            background-color: #1a1a1a; /* Gris muy oscuro para sutil contraste dentro del negro principal */
            border: 1px solid #ffd000;
            padding: 30px;
            margin: 40px 0;
            border-radius: 6px;
            box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.5); /* Sombra interna para profundidad */
        }

        /* Código de Seguridad - GIGANTE y Legible */
        .code {
            font-size: 56px; /* AUMENTO DE TAMAÑO SIGNIFICATIVO para legibilidad máxima */
            font-weight: bold;
            color: #ffd000; /* Oro brillante */
            letter-spacing: 16px; /* Mayor espaciado entre números */
            margin: 0;
            font-family: 'Courier New', Courier, monospace; /* Fuente monoespaciada para alineación y legibilidad */
            display: block;
            text-align: center;
            line-height: 1.2;
            text-shadow: 0 0 10px rgba(255, 208, 0, 0.6); /* Efecto de brillo de luz añadido */
        }

        /* Nueva Sección de Logo - Justo ANTES del Footer */
        .logo-section {
            padding: 40px 30px;
            text-align: center;
            background-color: #111111; /* Misma profundidad que header */
            border-top: 1px solid rgba(255, 255, 255, 0.1); /* Sutil separación superior */
        }
        .logo-section img {
            height: 80px; /* Tamaño decente para el logo */
            width: auto;
        }

        /* Footer - Espaciado y contraste pulido */
        .footer {
            background-color: #111111; /* Misma profundidad */
            padding: 25px 30px;
            text-align: center;
            font-size: 12px;
            color: #888888; /* Un poco más brillante para mejor contraste contra el negro profundo */
            border-top: 2px solid #ffd000; /* Borde superior dorado para definición */
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Cine Screenbites</h1>
        </div>

        <div class="content">
            <h2>¡Hola, {{ $user->name }}!</h2>
            <p>Alguien (esperamos que seas tú) está intentando acceder a tu cuenta. Aquí tienes tu código de seguridad para entrar a la sala:</p>

            <div class="code-box">
                <span class="code">{{ $code }}</span>
            </div>

            <p style="font-size: 14px; color: #aaaaaa; font-style: italic;">Este código caducará en 10 minutos. Si no has sido tú, ignora este mensaje.</p>
        </div>

        <div class="logo-section">
            @if(file_exists(public_path('img/img/Logo-Blanco.png')))
                <img src="{{ $message->embed(public_path('img/img/Logo-Blanco.png')) }}" alt="Screenbites Cinema Logo">
            @else
                <img src="{{ asset('img/img/Logo-Blanco.png') }}" alt="Screenbites Cinema Logo">
            @endif
        </div>

        <div class="footer">
            &copy; 2026 Cine Screenbites. Todos los derechos reservados.<br>
            Experience cinema like never before.
        </div>
    </div>
</body>
</html>