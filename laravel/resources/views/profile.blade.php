<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Screenbites Cinema - My Profile</title>
    <link rel="stylesheet" href="{{ asset('css/webbar.css') }}">

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
            top: 0; left: 0; right: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 5%;
            height: 100px;
            z-index: 1000;
            background-color: rgba(0, 0, 0, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        header .logo img { height: 50px; }

        header nav ul {
            list-style: none;
            display: flex;
            align-items: center;
            gap: 30px;
        }

        header nav a, .logout-btn {
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
            display: flex;
            align-items: center;
            gap: 8px;
        }

        header nav a:hover, .logout-btn:hover {
            color: var(--color-amarillo) !important;
            transform: scale(1.05);
        }

        .user-nav {
            display: flex;
            align-items: center;
            gap: 20px;
            border-left: 2px solid rgba(255, 255, 255, 0.2);
            padding-left: 20px;
            margin-left: 10px;
        }

        .user-nav .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--color-amarillo);
        }

        .user-nav .user-avatar {
            width: 35px; height: 35px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--color-amarillo);
        }

        /* --- PROFILE DASHBOARD --- */
        .profile-container {
            max-width: 1200px;
            margin: 150px auto 100px;
            padding: 0 5%;
            display: flex;
            gap: 40px;
        }

        .profile-sidebar {
            width: 250px;
            flex-shrink: 0;
        }

        .user-header {
            display: flex; align-items: center; gap: 15px;
            margin-bottom: 40px; padding-bottom: 20px;
            border-bottom: 1px solid var(--color-gris-claro);
        }

        .user-header .main-avatar { width: 60px; height: 60px; border-radius: 50%; object-fit: cover; border: 2px solid var(--color-amarillo); }
        .user-header h2 { font-size: 18px; text-transform: uppercase; }
        .user-header p { font-family: Arial; font-size: 12px; color: #888; }

        .sidebar-menu {
            list-style: none;
        }

        .sidebar-menu li { margin-bottom: 10px; }
        .sidebar-menu button {
            width: 100%; background: transparent; border: none; color: #888;
            text-align: left; padding: 12px 15px; font-size: 14px;
            font-family: 'Arial Black'; text-transform: uppercase;
            cursor: pointer; border-radius: 6px; transition: all 0.3s;
            display: flex; align-items: center; gap: 10px;
        }

        .sidebar-menu button:hover { background: var(--color-gris-tarjeta); color: var(--color-blanco); }
        .sidebar-menu button.active { background: var(--color-amarillo); color: var(--color-negro); }

        .profile-content {
            flex: 1;
            background: var(--color-gris-tarjeta);
            border: 1px solid var(--color-gris-claro);
            border-radius: 12px;
            padding: 40px;
            min-height: 500px;
        }

        .tab-content { display: none; animation: fadeIn 0.4s ease; }
        .tab-content.active { display: block; }
        .content-title { font-size: 24px; text-transform: uppercase; color: var(--color-amarillo); border-bottom: 1px solid #333; padding-bottom: 15px; margin-bottom: 30px; }

        /* FORMS */
        .alert-success { background: rgba(255, 208, 0, 0.1); border-left: 4px solid var(--color-amarillo); padding: 15px; margin-bottom: 30px; border-radius: 4px; font-family: Arial; }
        .form-group { margin-bottom: 25px; }
        .form-group label { display: block; color: #888; margin-bottom: 8px; font-size: 12px; text-transform: uppercase; font-weight: bold; }
        .form-group input { width: 100%; background: var(--color-negro); border: 1px solid #333; color: white; padding: 15px; border-radius: 6px; }
        .btn-save { background: var(--color-amarillo); color: var(--color-negro); padding: 15px 40px; font-weight: 900; text-transform: uppercase; border: none; border-radius: 4px; cursor: pointer; transition: 0.3s; }
        
        .avatar-grid { display: flex; gap: 15px; flex-wrap: wrap; margin-bottom: 20px; }
        .avatar-option { width: 65px; height: 65px; border-radius: 50%; cursor: pointer; border: 3px solid transparent; opacity: 0.5; transition: 0.3s; }
        .avatar-option.selected { border-color: var(--color-amarillo); opacity: 1; transform: scale(1.1); }

        /* --- LISTA DE BOOKINGS (ARREGLADA) --- */
        .bookings-list { display: flex; flex-direction: column; gap: 15px; }
        
        .booking-item {
            display: flex;
            align-items: center;
            padding: 15px;
            border-radius: 15px;
            gap: 20px;
            transition: 0.3s;
            border: 1px solid rgba(255,255,255,0.05);
            position: relative;
        }

        .booking-item:hover { transform: scale(1.01); border-color: rgba(255,255,255,0.2); }
        
        /* Contenedor de imagen para evitar que crezca */
        .booking-img-wrapper {
            width: 70px;
            height: 100px;
            flex-shrink: 0;
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.5);
        }

        .booking-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .booking-info { flex: 1; }
        .booking-info h3 { font-size: 20px; text-transform: uppercase; margin: 0; letter-spacing: 1px; }
        .booking-info p { font-size: 13px; opacity: 0.7; margin-top: 5px; font-family: Arial; }

        .view-ticket-btn {
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 900;
            text-transform: uppercase;
            transition: 0.3s;
        }

        .view-ticket-btn:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(255,255,255,0.1); }

        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        footer { background: var(--color-negro); padding: 60px 5% 40px; border-top: 1px solid var(--color-gris-claro); text-align: center;}
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
                        <a href="/profile" class="user-profile">
                            <img src="{{ asset('img/avatars/' . (Auth::user()->avatar ?? 'avatar1.png')) }}" alt="Avatar" class="user-avatar" onerror="this.src='https://via.placeholder.com/35/333/ffd000'">
                            <span class="user-name">{{ strtoupper(Auth::user()->name ?? 'User') }}</span>
                        </a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="logout-btn">
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
                <img src="{{ asset('img/avatars/' . (Auth::user()->avatar ?? 'avatar1.png')) }}" id="sidebar-avatar" class="main-avatar" onerror="this.src='https://via.placeholder.com/60/333/ffd000'">
                <div>
                    <h2>{{ Auth::user()->name ?? 'User' }}</h2>
                    <p>VIP Member</p>
                </div>
            </div>
            <ul class="sidebar-menu">
                <li><button class="tab-btn active" data-target="tab-profile">Profile Settings</button></li>
                <li><button class="tab-btn" data-target="tab-security">Security</button></li>
                <li><button class="tab-btn" data-target="tab-bookings">My Bookings</button></li>
            </ul>
        </aside>

        <main class="profile-content">
            @if (session('status'))
                <div class="alert-success">{{ session('status') }}</div>
            @endif

            <div id="tab-profile" class="tab-content active">
                <h2 class="content-title">Profile Settings</h2>
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf @method('PATCH')
                    <div class="avatar-grid">
                        <input type="hidden" name="avatar" id="avatar-input" value="{{ Auth::user()->avatar ?? 'avatar1.png' }}">
                        @for ($i = 1; $i <= 6; $i++)
                            <img src="{{ asset('img/avatars/avatar'.$i.'.png') }}" class="avatar-option {{ (Auth::user()->avatar == 'avatar'.$i.'.png') ? 'selected' : '' }}" onclick="selectAvatar(this, 'avatar{{$i}}.png')" onerror="this.src='https://via.placeholder.com/65/111/ffd000?text=A{{$i}}'">
                        @endfor
                    </div>
                    <div class="form-group">
                        <label>Display Name</label>
                        <input type="text" name="name" value="{{ Auth::user()->name }}" required>
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" value="{{ Auth::user()->email }}" required>
                    </div>
                    <button type="submit" class="btn-save">Save Changes</button>
                </form>
            </div>

            <div id="tab-security" class="tab-content">
                <h2 class="content-title">Security</h2>
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf @method('PUT')
                    <div class="form-group">
                        <label>Current Password</label>
                        <input type="password" name="current_password" required>
                    </div>
                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" name="password" required>
                    </div>
                    <button type="submit" class="btn-save">Update Password</button>
                </form>
            </div>

            <div id="tab-bookings" class="tab-content">
                <h2 class="content-title">My Bookings</h2>
                <div class="bookings-list">
                    
                    @forelse($myBookings ?? [] as $b)
                        <div class="booking-item" style="background: {{ $b['bg'] ?? '#141414' }};">
                            <div class="booking-img-wrapper">
                                <img src="{{ $b['poster'] ?? '' }}" onerror="this.src='https://via.placeholder.com/70x100/333/white?text=FILM'">
                            </div>
                            
                            <div class="booking-info">
                                <h3 style="color: {{ $b['color'] ?? 'white' }};">{{ $b['movie'] }}</h3>
                                <p style="color: {{ $b['color'] ?? 'white' }}; opacity: 0.8;">
                                    {{ date('d M Y', strtotime($b['date'])) }} • Seats: <strong>{{ $b['seats'] }}</strong>
                                </p>
                            </div>

                            <a href="{{ route('ticket.show', $b['id'] ?? 0) }}" class="view-ticket-btn" 
                               style="background: {{ $b['color'] ?? 'white' }}; color: {{ $b['bg'] ?? 'black' }};">
                                VIEW TICKET
                            </a>
                        </div>
                    @empty
                        <div style="text-align:center; padding: 40px; border: 1px dashed #333; border-radius: 12px;">
                            <p style="color:#666;">You don't have any bookings yet.</p>
                            <a href="/#cartelera" style="color:var(--color-amarillo); text-decoration:none; font-size:12px; margin-top:10px; display:block;">EXPLORE MOVIES</a>
                        </div>
                    @endforelse

                </div>
            </div>
        </main>
    </div>

    <footer>
        <img src="{{ asset('img/img/Logo-Blanco.png') }}" height="40">
        <p style="color: #444; font-size: 11px; margin-top: 15px;">&copy; 2026 Screenbites Cinema. VIP Access Only.</p>
    </footer>

    <script>
        const tabBtns = document.querySelectorAll('.tab-btn');
        const tabContents = document.querySelectorAll('.tab-content');
        tabBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                tabBtns.forEach(b => b.classList.remove('active'));
                tabContents.forEach(c => c.classList.remove('active'));
                btn.classList.add('active');
                document.getElementById(btn.dataset.target).classList.add('active');
            });
        });

        function selectAvatar(img, filename) {
            document.querySelectorAll('.avatar-option').forEach(i => i.classList.remove('selected'));
            img.classList.add('selected');
            document.getElementById('avatar-input').value = filename;
            document.getElementById('sidebar-avatar').src = img.src;
        }

        window.onload = () => {
            const urlParams = new URLSearchParams(window.location.search);
            if(urlParams.get('success') === '1' || window.location.hash === '#tab-bookings') {
                const btn = document.querySelector('[data-target="tab-bookings"]');
                if(btn) btn.click();
            }
        };

        // Si venimos de un pago exitoso, borramos el temporizador
if(urlParams.get('success') === '1') {
    sessionStorage.removeItem('booking_end_time');
    // ... el resto de tu código de success
}
    </script>
</body>
</html>