<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cine Screenbites - Verificación de Seguridad</title>
    <link rel="stylesheet" href="{{ asset('css/webbar.css') }}">
    <style>
        body { margin: 0; font-family: 'Arial Black', sans-serif; background-color: #000; color: #fff; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .auth-box { background: #111; padding: 50px 40px; border-top: 5px solid #ffd000; border-radius: 8px; width: 100%; max-width: 400px; text-align: center; }
        .auth-box h1 { color: #ffd000; text-transform: uppercase; margin-bottom: 10px; font-size: 24px; }
        .auth-box p { color: #888; font-family: Arial, sans-serif; font-size: 14px; margin-bottom: 30px; line-height: 1.5; }
        .form-group input { width: 100%; padding: 15px; background: #222; border: 1px solid #ffd000; color: #ffd000; border-radius: 4px; box-sizing: border-box; text-align: center; font-size: 28px; font-weight: bold; letter-spacing: 15px; outline: none; }
        .btn-submit { width: 100%; background: #ffd000; color: #000; padding: 15px; border: none; font-weight: 900; text-transform: uppercase; cursor: pointer; border-radius: 4px; margin-top: 20px; transition: 0.3s; }
        .btn-submit:hover { background: #fff; }
        .error { color: red; font-size: 12px; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="auth-box">
        <h1>Verificación 2FA</h1>
        <p>Hemos enviado un código secreto de 6 dígitos a tu correo. Introdúcelo aquí para acceder al cine.</p>
        
        @if($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('2fa.verify') }}" method="POST">
            @csrf
            <div class="form-group">
                <input type="text" name="code" maxlength="6" autocomplete="off" required placeholder="000000">
            </div>
            <button type="submit" class="btn-submit">Entrar al Cine</button>
        </form>
    </div>
</body>
</html>