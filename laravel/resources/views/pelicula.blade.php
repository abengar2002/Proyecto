<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cine Screenbites - Detalles de Película</title>
    <style>
        :root {
            --color-negro: #000000;
            --color-gris-oscuro: #111111;
            --color-blanco: #ffffff;
            --color-amarillo: #ffd000;
        }
        body { margin: 0; font-family: 'Arial Black', sans-serif; background-color: var(--color-negro); color: var(--color-blanco); }
        
        header { padding: 30px 5%; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.1); }
        header img { height: 50px; }
        .back-btn { color: var(--color-amarillo); text-decoration: none; text-transform: uppercase; font-size: 14px; letter-spacing: 2px; }
        .back-btn:hover { color: var(--color-blanco); }

        .movie-container { padding: 80px 5%; display: flex; gap: 50px; max-width: 1200px; margin: 0 auto; align-items: flex-start; }
        .movie-poster { width: 350px; border-radius: 8px; box-shadow: 0 20px 40px rgba(255,208,0,0.2); border: 2px solid var(--color-amarillo); background-color: #111;}
        
        .movie-info { flex: 1; }
        .movie-id { color: var(--color-amarillo); font-size: 24px; letter-spacing: 5px; margin-bottom: 10px; display: block; }
        .movie-title { font-size: 60px; margin: 0 0 20px 0; text-transform: uppercase; line-height: 1; }
        .movie-meta { color: #888; font-family: Arial, sans-serif; font-size: 16px; margin-bottom: 30px; }
        .movie-desc { font-family: Arial, sans-serif; line-height: 1.8; color: #ccc; margin-bottom: 40px; font-size: 18px; }
        
        .btn-buy { background: var(--color-amarillo); color: var(--color-negro); padding: 15px 40px; font-size: 16px; font-weight: 900; text-transform: uppercase; border: none; border-radius: 4px; cursor: pointer; letter-spacing: 1px; transition: background 0.2s; }
        .btn-buy:hover { background: var(--color-blanco); }
    </style>
</head>
<body>

    <header>
        <div class="logo">
            <a href="/">
                <img src="{{ asset('img/img/Logo-Blanco.png') }}" alt="Cine Logo">
            </a>
        </div>
        <a href="/" class="back-btn">❮ Volver a la Cartelera</a>
    </header>

    <div class="movie-container">
        <img src="{{ asset('img/' . $id . '-Peli/Mini.png') }}" onerror="this.src='https://via.placeholder.com/350x500/111/ffd000?text=Poster+{{ $id }}'" alt="Poster Película" class="movie-poster">
        
        <div class="movie-info">
            <span class="movie-id">PELÍCULA #{{ $id }}</span>
            <h1 class="movie-title">Info de Película</h1>
            <p class="movie-meta">Duración: 2h 15m | Calificación: +18</p>
            <p class="movie-desc">Aquí irá la sinopsis oficial de la película. Un texto épico que cuente de qué trata para que el usuario se emocione y decida comprar su entrada de inmediato. En los próximos pasos conectaremos esto con tu base de datos para que cada película cargue su texto real.</p>
            
            <button class="btn-buy" onclick="alert('Funcionalidad de Compra Directa en desarrollo')">
                COMPRAR ENTRADAS AHORA - $8.50
            </button>
        </div>
    </div>

</body>
</html>