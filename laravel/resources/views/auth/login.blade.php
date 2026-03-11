<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Screenbites - Entrar</title>
    <style>
        body { margin: 0; font-family: 'Arial Black', sans-serif; background-color: #000; color: #fff; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .auth-box { background: #111; padding: 40px; border-top: 5px solid #ffd000; border-radius: 8px; width: 100%; max-width: 400px; text-align: center; }
        .auth-box h1 { color: #ffd000; text-transform: uppercase; margin-bottom: 30px; }
        .form-group { margin-bottom: 20px; text-align: left; }
        .form-group label { display: block; font-size: 12px; margin-bottom: 5px; color: #aaa; text-transform: uppercase; }
        .form-group input { width: 100%; padding: 12px; background: #222; border: 1px solid #444; color: #fff; border-radius: 4px; box-sizing: border-box; }
        
        /* Contenedor relativo para el ojito */
        .password-wrapper { position: relative; display: flex; align-items: center; }
        .password-wrapper input { padding-right: 40px; /* Deja espacio para el icono */ }
        .toggle-password { position: absolute; right: 10px; background: none; border: none; color: #888; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: color 0.3s ease; padding: 0; }
        .toggle-password:hover { color: #ffd000; }

        .btn-submit { width: 100%; background: #ffd000; color: #000; padding: 15px; border: none; font-weight: 900; text-transform: uppercase; cursor: pointer; border-radius: 4px; margin-top: 10px; }
        .btn-submit:hover { background: #fff; }
        .link { display: block; margin-top: 20px; color: #ffd000; text-decoration: none; font-size: 12px; }
        .error { color: red; font-size: 12px; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="auth-box">
        <h1>Iniciar Sesión</h1>
        
        @if($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif

        <form action="{{ url('/login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label>Contraseña</label>
                <div class="password-wrapper">
                    <input type="password" name="password" id="login-password" required>
                    <button type="button" class="toggle-password" onclick="toggleVisibility('login-password', 'icon-login')">
                        <svg id="icon-login" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-submit">Entrar</button>
        </form>
        <a href="{{ route('register') }}" class="link">¿No tienes cuenta? Regístrate</a>
        <a href="/" class="link" style="color: #666; margin-top: 10px;">Volver al inicio</a>
    </div>

    <script>
        // Lógica para cambiar de oculto a visible y cambiar el SVG
        function toggleVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === 'password') {
                input.type = 'text';
                // SVG Ojo cerrado (tachado)
                icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
            } else {
                input.type = 'password';
                // SVG Ojo abierto
                icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
            }
        }
    </script>
</body>
</html>