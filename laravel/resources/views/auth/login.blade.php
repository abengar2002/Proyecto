<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Screenbites - Sign In</title>
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
            min-height: 100vh;
            padding: clamp(20px, 5vw, 40px) 0;
        }

        .auth-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            max-width: clamp(320px, 90%, 400px);
            padding: 0 20px;

            .auth-logo {
                width: clamp(140px, 20vw, 180px);
                margin-bottom: clamp(20px, 4vw, 30px);
                transition: transform 0.3s ease;
                &:hover { transform: scale(1.05); }
            }

            .auth-box {
                background: var(--color-gris-oscuro);
                padding: clamp(25px, 5vw, 40px);
                border-top: 5px solid var(--color-amarillo);
                border-radius: 8px;
                width: 100%;
                box-sizing: border-box;
                text-align: center;
                box-shadow: 0 10px 30px rgba(0,0,0,0.8);

                h1 {
                    color: var(--color-amarillo);
                    text-transform: uppercase;
                    margin-bottom: clamp(20px, 4vw, 30px);
                    font-size: clamp(20px, 3vw, 24px);
                }

                .form-group {
                    margin-bottom: 20px;
                    text-align: left;

                    label {
                        display: block;
                        font-size: clamp(10px, 1.2vw, 12px);
                        margin-bottom: 8px;
                        color: #aaa;
                        text-transform: uppercase;
                        letter-spacing: 1px;
                    }

                    input {
                        width: 100%;
                        padding: clamp(12px, 1.5vw, 15px);
                        background: var(--color-gris-input);
                        border: 1px solid #444;
                        color: var(--color-blanco);
                        border-radius: 4px;
                        box-sizing: border-box;
                        font-size: clamp(14px, 1.5vw, 16px);
                        transition: border-color 0.3s;

                        &:focus { outline: none; border-color: var(--color-amarillo); }
                    }

                    .password-wrapper {
                        position: relative;
                        display: flex;
                        align-items: center;

                        input { padding-right: 45px; }

                        .toggle-password {
                            position: absolute;
                            right: 15px;
                            background: none;
                            border: none;
                            color: #888;
                            cursor: pointer;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            transition: color 0.3s ease;
                            padding: 0;
                            &:hover { color: var(--color-amarillo); }
                        }
                    }
                }

                .btn-submit {
                    width: 100%;
                    background: var(--color-amarillo);
                    color: var(--color-negro);
                    padding: clamp(12px, 1.5vw, 15px);
                    border: none;
                    font-weight: 900;
                    text-transform: uppercase;
                    cursor: pointer;
                    border-radius: 4px;
                    margin-top: 10px;
                    font-size: clamp(12px, 1.2vw, 14px);
                    transition: background 0.3s, transform 0.2s;
                    &:hover { background: var(--color-blanco); transform: translateY(-2px); }
                    &:active { transform: translateY(0); }
                }

                .link {
                    display: block;
                    margin-top: 20px;
                    color: var(--color-amarillo);
                    text-decoration: none;
                    font-size: clamp(11px, 1.2vw, 13px);
                    font-family: Arial, sans-serif;
                    transition: color 0.3s;
                    &:hover { color: var(--color-blanco); }
                    &.back-home { color: #666; font-size: 11px; margin-top: 15px; }
                }

                .error {
                    background: rgba(255,0,0,0.1);
                    border-left: 3px solid #ff4444;
                    color: #ff6b6b;
                    padding: 10px;
                    font-size: 12px;
                    margin-bottom: 20px;
                    text-align: left;
                    border-radius: 4px;
                    font-family: Arial, sans-serif;
                }
            }
        }

        @media (max-width: 480px) {
            .auth-container .auth-box { padding: 25px 20px; }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <a href="/"><img src="{{ asset('img/img/Logo-Blanco.png') }}" alt="Logo" class="auth-logo"></a>
        <div class="auth-box">
            <h1>Sign In</h1>
            @if($errors->any()) <div class="error">{{ $errors->first() }}</div> @endif
            <form action="{{ url('/login') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
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
                <button type="submit" class="btn-submit">Log In</button>
            </form>
            <a href="{{ route('register') }}" class="link">Don't have an account? Sign Up</a>
            <a href="/" class="link back-home">Back to Home</a>
        </div>
    </div>
    <script>
        function toggleVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
            } else {
                input.type = 'password';
                icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
            }
        }
    </script>
</body>
</html>