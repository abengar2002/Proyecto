<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Screenbites - Security Verification</title>
    <link rel="stylesheet" href="{{ asset('css/webbar.css') }}">
    <style>
        :root {
            --color-negro: #000000;
            --color-gris-oscuro: #111111;
            --color-gris-input: #222222;
            --color-amarillo: #ffd000;
            --color-blanco: #ffffff;
        }

        body {
            margin: 0;
            font-family: 'Arial Black', sans-serif;
            background-color: var(--color-negro);
            color: var(--color-blanco);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .auth-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            max-width: clamp(350px, 90%, 450px);
            padding: 0 20px;

            .auth-logo { width: 180px; margin-bottom: 30px; }

            .auth-box {
                background: var(--color-gris-oscuro);
                padding: clamp(30px, 6vw, 50px) clamp(20px, 4vw, 40px);
                border-top: 5px solid var(--color-amarillo);
                border-radius: 8px;
                width: 100%;
                box-sizing: border-box;
                text-align: center;
                box-shadow: 0 10px 30px rgba(0,0,0,0.8);

                h1 {
                    color: var(--color-amarillo);
                    text-transform: uppercase;
                    margin-bottom: 15px;
                    font-size: clamp(20px, 3vw, 24px);
                }

                p {
                    color: #aaa;
                    font-family: Arial, sans-serif;
                    font-size: clamp(12px, 1.5vw, 14px);
                    margin-bottom: clamp(25px, 4vw, 35px);
                    line-height: 1.6;
                }

                .form-group {
                    input {
                        width: 100%;
                        padding: clamp(15px, 2vw, 20px);
                        background: var(--color-gris-input);
                        border: 2px solid #333;
                        color: var(--color-amarillo);
                        border-radius: 8px;
                        box-sizing: border-box;
                        text-align: center;
                        font-size: clamp(24px, 4vw, 32px);
                        font-weight: bold;
                        letter-spacing: clamp(10px, 3vw, 20px);
                        outline: none;
                        transition: border-color 0.3s;
                        &:focus { border-color: var(--color-amarillo); }
                    }
                }

                .btn-submit {
                    width: 100%;
                    background: var(--color-amarillo);
                    color: var(--color-negro);
                    padding: clamp(15px, 2vw, 18px);
                    border: none;
                    font-weight: 900;
                    text-transform: uppercase;
                    cursor: pointer;
                    border-radius: 4px;
                    margin-top: 25px;
                    font-size: clamp(13px, 1.2vw, 15px);
                    transition: 0.3s;
                    &:hover { background: var(--color-blanco); transform: translateY(-2px); }
                }

                .error {
                    background: rgba(255,0,0,0.1); border-left: 3px solid #ff4444; color: #ff6b6b;
                    padding: 10px; font-size: 12px; margin-bottom: 20px; border-radius: 4px; font-family: Arial, sans-serif;
                }
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <a href="/"><img src="{{ asset('img/img/Logo-Blanco.png') }}" alt="Logo" class="auth-logo"></a>
        <div class="auth-box">
            <h1>2FA Verification</h1>
            <p>We have sent a 6-digit secret code to your email. Enter it here to access the cinema.</p>
            @if($errors->any()) <div class="error">{{ $errors->first() }}</div> @endif
            <form action="{{ route('2fa.verify') }}" method="POST">
                @csrf
                <div class="form-group">
                    <input type="text" name="code" maxlength="6" autocomplete="off" required placeholder="000000">
                </div>
                <button type="submit" class="btn-submit">Enter Cinema</button>
            </form>
        </div>
    </div>
</body>
</html>