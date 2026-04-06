<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: sans-serif;
            background-color: #000;
            color: #fff;
            padding: 20px;
        }

        .ticket {
            background: #1a1a1a;
            border: 2px solid #ffd000;
            border-radius: 10px;
            max-width: 500px;
            margin: 0 auto;
            overflow: hidden;
        }

        .header {
            background: #ffd000;
            color: #000;
            padding: 20px;
            text-align: center;
        }

        .content {
            padding: 30px;
            color: #bdbdbd;
        }

        .movie-title {
            font-size: 24px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 10px;
            color: #ffd000;
        }

        .info-grid {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            border-bottom: 1px dashed #bdbdbd;
            padding-bottom: 15px;
        }

        .info-cosas {
            display: flex;
            gap: 2rem;
        }

        .label {
            color: #888;
            gap: 1rem;
            font-size: 12px;
            text-transform: uppercase;
        }

        .val {
            font-weight: bold;
            color: #888;
        }

        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="ticket">
        <div class="header">
            <h1 style="margin:0">SCREENBITES CINEMA</h1>
        </div>
        <div class="content">
            <p>¡Hola! Aquí tienes tu confirmación de compra:</p>

            <div class="movie-title">{{ $orderData['movie_title'] }}</div>

            <div class="info-grid">
                <div class="info-cosas">
                    <div class="label">Asientos</div>
                    <div class="val">{{ $orderData['seats'] }}</div>
                </div>
                <div class="info-cosas">
                    <div class="label">Total Pago</div>
                    <div class="val">{{ $orderData['total'] }}€</div>
                </div>
            </div>

            <p style="font-size: 14px; color: #ccc;">Presenta este correo en la entrada del cine o en el mostrador del
                bar para recoger tu menú.</p>
        </div>
        <div class="footer">
            Disfruta de la película. ¡Gracias por confiar en nosotros!
        </div>
    </div>
</body>

</html>