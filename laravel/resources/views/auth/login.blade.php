<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cine Screenbites - Login</title>
    <style>
        body { margin: 0; font-family: 'Arial Black', sans-serif; background-color: #000; color: #fff; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .auth-box { background: #111; padding: 40px; border-top: 5px solid #ffd000; border-radius: 8px; width: 100%; max-width: 400px; text-align: center; }
        .auth-box h1 { color: #ffd000; text-transform: uppercase; margin-bottom: 30px; }
        .form-group { margin-bottom: 20px; text-align: left; }
        .form-group label { display: block; font-size: 12px; margin-bottom: 5px; color: #aaa; text-transform: uppercase; }
        .form-group input { width: 100%; padding: 12px; background: #222; border: 1px solid #444; color: #fff; border-radius: 4px; box-sizing: border-box; }
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
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn-submit">Entrar</button>
        </form>
        <a href="{{ route('register') }}" class="link">¿No tienes cuenta? Regístrate</a>
        <a href="/" class="link" style="color: #666;">Volver al inicio</a>
    </div>
</body>
</html>