<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket - {{ $ticket['movie'] }}</title>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --peli-bg: {{ $ticket['bg'] }};
            --peli-color: {{ $ticket['color'] }};
        }

        body { 
            background: #000; 
            color: #fff; 
            font-family: 'Arial Black', sans-serif; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            min-height: 100vh; 
            margin: 0; 
        }

        /* DISEÑO DE LA ENTRADA */
        .ticket-wrapper {
            width: 850px;
            height: 320px;
            display: flex;
            background: var(--peli-bg);
            border-radius: 24px;
            overflow: hidden;
            position: relative;
            box-shadow: 0 30px 60px rgba(0,0,0,0.8);
            border: 1px solid rgba(255,255,255,0.1);
        }

        /* FLECHA SVG PERFECTA */
        .back-nav {
            position: absolute;
            top: 20px;
            left: 20px;
            z-index: 10;
        }
        .back-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            background: rgba(0,0,0,0.5);
            color: white;
            border-radius: 50%;
            text-decoration: none;
            backdrop-filter: blur(5px);
            transition: 0.3s;
            border: 1px solid rgba(255,255,255,0.2);
        }
        .back-btn:hover { background: #fff; color: #000; transform: scale(1.1); }
        .back-btn svg { width: 24px; height: 24px; fill: none; stroke: currentColor; stroke-width: 3; }

        /* POSTER */
        .poster-side { width: 240px; height: 100%; position: relative; }
        .poster-side img { width: 100%; height: 100%; object-fit: cover; }

        /* CONTENIDO CENTRAL */
        .info-side {
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border-right: 3px dashed rgba(255,255,255,0.15);
            position: relative;
        }

        .info-side::before, .info-side::after {
            content: ''; position: absolute; right: -12px;
            width: 24px; height: 24px; background: #000; border-radius: 50%;
        }
        .info-side::before { top: -12px; }
        .info-side::after { bottom: -12px; }

        .movie-name { 
            font-size: 42px; 
            margin: 0; 
            text-transform: uppercase; 
            color: var(--peli-color);
            letter-spacing: -1px;
            line-height: 1;
        }

        .details-row { display: flex; gap: 40px; margin-top: 30px; }
        .data-group span { display: block; }
        .data-group .label { font-size: 10px; opacity: 0.6; text-transform: uppercase; margin-bottom: 5px; letter-spacing: 1px; }
        .data-group .val { font-size: 20px; color: var(--peli-color); }

        /* QR SIDE */
        .qr-side {
            width: 220px;
            background: rgba(0,0,0,0.2);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .qr-container { background: #fff; padding: 12px; border-radius: 18px; margin-bottom: 10px; }
        .qr-container img { width: 130px; height: 130px; display: block; }
        .bkg-id { font-size: 11px; font-family: monospace; opacity: 0.4; letter-spacing: 2px; }

        /* BOTONES (Solo se ven en pantalla) */
        .actions-area { display: flex; gap: 15px; margin-top: 30px; }
        .btn {
            padding: 12px 25px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 900;
            cursor: pointer;
            text-decoration: none;
            transition: 0.3s;
            border: none;
            text-transform: uppercase;
        }
        .btn-download { background: var(--peli-color); color: var(--peli-bg); }
        .btn-cancel { background: rgba(255, 68, 68, 0.1); color: #ff4444; border: 1px solid rgba(255, 68, 68, 0.2); }
        .btn-cancel:hover { background: #ff4444; color: #fff; }

        /* --- LÓGICA PARA EL PDF (IMPRESIÓN) --- */
        @media print {
            @page { size: landscape; margin: 0; }
            body { background: white; padding: 0; }
            .back-nav, .actions-area { display: none !important; } /* Ocultar botones y flecha */
            .ticket-wrapper {
                box-shadow: none;
                border: 2px solid #eee;
                -webkit-print-color-adjust: exact; /* Forzar colores en PDF */
                print-color-adjust: exact;
                margin: 20px auto;
            }
            .info-side::before, .info-side::after { background: white; } /* Los huecos ahora son blancos */
        }
    </style>
</head>
<body>

    <div class="back-nav">
        <a href="{{ route('profile.edit', ['tab' => 'bookings']) }}" class="back-btn">
            <svg viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </a>
    </div>

    <div class="ticket-wrapper">
        <div class="poster-side">
            <img src="{{ $ticket['poster'] }}" alt="Poster">
        </div>

        <div class="info-side">
            <div>
                <h1 class="movie-name">{{ $ticket['movie'] }}</h1>
                <p style="opacity: 0.7; font-family: Arial; margin-top: 8px;">{{ date('l, d F Y', strtotime($ticket['date'])) }}</p>
                
                <div class="details-row">
                    <div class="data-group">
                        <span class="label">Seats</span>
                        <span class="val">{{ $ticket['seats'] }}</span>
                    </div>
                    <div class="data-group">
                        <span class="label">Hall</span>
                        <span class="val">VIP 01</span>
                    </div>
                    <div class="data-group">
                        <span class="label">Payment</span>
                        <span class="val">${{ number_format($ticket['total'], 2) }}</span>
                    </div>
                </div>
            </div>

            <div class="actions-area">
                <button onclick="window.print()" class="btn btn-download">Download Ticket</button>
                
                <form id="cancel-form" action="{{ route('reserva.destroy', $ticket['id']) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="button" class="btn btn-cancel" onclick="confirmCancel()">Cancel Booking</button>
                </form>
            </div>
        </div>

        <div class="qr-side">
            <div class="qr-container">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=VALID-TICKET-{{ $ticket['id'] }}" alt="QR">
            </div>
            <span class="bkg-id">#{{ strtoupper(substr(md5($ticket['id']), 0, 8)) }}</span>
            <p style="font-size: 8px; margin-top: 15px; opacity: 0.5; text-transform: uppercase;">Show this at entrance</p>
        </div>
    </div>

    <script>
        function confirmCancel() {
            Swal.fire({
                title: 'Cancel Booking?',
                text: "Are you sure you want to cancel this reservation? This action cannot be undone.",
                icon: 'warning',
                background: '#141414',
                color: '#ffffff',
                showCancelButton: true,
                confirmButtonColor: '#ff4444',
                cancelButtonColor: '#333333',
                confirmButtonText: 'Yes, cancel it',
                cancelButtonText: 'No, keep it',
                customClass: {
                    title: 'swal-title-custom'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Si el usuario hace clic en "Yes", enviamos el formulario manualmente
                    document.getElementById('cancel-form').submit();
                }
            });
        }
    </script>
</body>
</html>