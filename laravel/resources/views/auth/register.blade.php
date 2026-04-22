<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Screenbites - Sign Up</title>
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
            padding: clamp(40px, 8vw, 80px) 0;
        }

        .auth-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            max-width: clamp(400px, 90%, 550px);
            padding: 0 20px;

            .auth-logo {
                width: 180px;
                margin-bottom: 30px;
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
                box-shadow: 0 10px 40px rgba(0,0,0,0.9);

                h1 {
                    color: var(--color-amarillo);
                    text-transform: uppercase;
                    margin-bottom: 25px;
                    font-size: clamp(22px, 3vw, 26px);
                }

                .form-group {
                    margin-bottom: 20px;
                    text-align: left;

                    &.avatar-section {
                        text-align: center;
                        margin-bottom: 30px;
                        label.main-label { color: var(--color-amarillo); font-size: 14px; margin-bottom: 15px; }
                    }

                    label { display: block; font-size: 12px; margin-bottom: 8px; color: #aaa; text-transform: uppercase; }

                    input[type="text"], input[type="email"], input[type="password"] {
                        width: 100%;
                        padding: 15px;
                        background: var(--color-gris-input);
                        border: 1px solid #444;
                        color: var(--color-blanco);
                        border-radius: 4px;
                        box-sizing: border-box;
                        transition: border-color 0.3s;
                        &:focus { outline: none; border-color: var(--color-amarillo); }
                    }

                    .avatar-grid {
                        display: grid;
                        grid-template-columns: repeat(5, 1fr);
                        gap: clamp(8px, 2vw, 15px);
                        margin-top: 15px;

                        label {
                            cursor: pointer;
                            input { display: none; }
                            img {
                                width: 100%;
                                aspect-ratio: 1/1;
                                object-fit: cover;
                                border-radius: 50%;
                                border: 3px solid transparent;
                                transition: all 0.2s;
                                opacity: 0.4;
                                &:hover { opacity: 1; }
                            }
                            input:checked + img {
                                border-color: var(--color-amarillo);
                                opacity: 1;
                                transform: scale(1.15);
                                box-shadow: 0 0 15px rgba(255,208,0,0.5);
                            }
                        }
                    }

                    .password-wrapper {
                        position: relative;
                        display: flex;
                        align-items: center;
                        input { padding-right: 45px; }
                        .toggle-password {
                            position: absolute;
                            right: 15px;
                            background: none; border: none; color: #888; cursor: pointer;
                            &:hover { color: var(--color-amarillo); }
                        }
                    }
                }

                .btn-submit {
                    width: 100%;
                    background: var(--color-amarillo);
                    color: var(--color-negro);
                    padding: 18px;
                    border: none;
                    font-weight: 900;
                    text-transform: uppercase;
                    cursor: pointer;
                    border-radius: 4px;
                    margin-top: 10px;
                    font-size: 14px;
                    transition: 0.3s;
                    &:hover { background: var(--color-blanco); transform: translateY(-2px); }
                }

                .link {
                    display: block;
                    margin-top: 25px;
                    color: var(--color-amarillo);
                    text-decoration: none;
                    font-size: 13px;
                    &:hover { color: #fff; }
                }
            }
        }

        @media (max-width: 600px) {
            .auth-container .auth-box .form-group .avatar-grid { grid-template-columns: repeat(4, 1fr); }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <a href="/"><img src="{{ asset('img/img/Logo-Blanco.png') }}" class="auth-logo"></a>
        <div class="auth-box">
            <h1>Join the Club</h1>
            @if($errors->any()) <div class="error">{{ $errors->first() }}</div> @endif
            <form action="{{ url('/registro') }}" method="POST">
                @csrf
                <div class="form-group avatar-section">
                    <label class="main-label">Choose Your Character</label>
                    <div class="avatar-grid">
                        @for ($i = 1; $i <= 16; $i++)
                            <label>
                                <input type="radio" name="avatar" value="avatar{{$i}}.png" {{ $i == 1 ? 'checked' : '' }}>
                                <img src="{{ asset('img/avatars/avatar'.$i.'.png') }}" onerror="this.src='https://via.placeholder.com/80/333/ffd000'">
                            </label>
                        @endfor
                    </div>
                </div>
                <div class="form-group"><label>Name</label><input type="text" name="name" required></div>
                <div class="form-group"><label>Email Address</label><input type="email" name="email" required></div>
                <div class="form-group">
                    <label>Password (Min. 8 characters)</label>
                    <div class="password-wrapper">
                        <input type="password" name="password" id="reg-password" required>
                        <button type="button" class="toggle-password" onclick="toggleVisibility('reg-password', 'icon-reg1')">
                            <svg id="icon-reg1" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        </button>
                    </div>
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <div class="password-wrapper">
                        <input type="password" name="password_confirmation" id="reg-password-conf" required>
                        <button type="button" class="toggle-password" onclick="toggleVisibility('reg-password-conf', 'icon-reg2')">
                            <svg id="icon-reg2" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        </button>
                    </div>
                </div>
                <button type="submit" class="btn-submit">Sign Up</button>
            </form>
            <a href="{{ route('login') }}" class="link">Already have an account? Sign In</a>
            <a href="/" class="link" style="color: #666; margin-top: 15px; font-size: 12px;">Back to Home</a>
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