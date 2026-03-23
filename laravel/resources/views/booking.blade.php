<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Screenbites - Seat Selection</title>
    <style>
        :root {
            --color-negro: #000000;
            --color-gris-oscuro: #0a0a0a;
            --color-gris-tarjeta: #141414;
            --color-gris-claro: #333333;
            --color-blanco: #ffffff;
            
            /* COLOR DINÁMICO DE LA PELÍCULA */
            --color-amarillo: {{ $movie['bg'] ?? '#ffd000' }}; 
            --color-texto-btn: {{ $movie['textColor'] ?? 'black' }};

            --color-asiento-libre: #222222;
            --color-asiento-ocupado: #0f0f0f;
            --color-asiento-vip: #5a3e90;
        }

        * { 
            box-sizing: border-box; 
            margin: 0; 
            padding: 0; 
        }
        
        body { 
            font-family: 'Arial', sans-serif; 
            background-color: var(--color-negro); 
            color: var(--color-blanco); 
            min-height: 100vh; 
            display: flex; 
            flex-direction: column; 
            position: relative;

            /* --- FONDO INMERSIVO DE LA PELI --- */
            .page-bg {
                position: fixed;
                top: 0; left: 0; width: 100%; height: 100%;
                z-index: -2;
                object-fit: cover;
                opacity: 0.15;
                filter: blur(8px);
            }

            .page-bg-gradient {
                position: fixed;
                top: 0; left: 0; width: 100%; height: 100%;
                z-index: -1;
                background: radial-gradient(circle at center, transparent 0%, var(--color-negro) 80%);
            }

            /* --- HEADER --- */
            header { 
                padding: 20px 5%; 
                display: flex; 
                justify-content: space-between; 
                align-items: center; 
                border-bottom: 1px solid rgba(255,255,255,0.05); 
                background-color: rgba(0,0,0,0.8);
                backdrop-filter: blur(10px);
                position: sticky;
                top: 0;
                z-index: 100;

                .logo img { 
                    height: 40px; 
                }

                .back-btn { 
                    color: var(--color-blanco); 
                    text-decoration: none; 
                    display: flex; 
                    align-items: center; 
                    gap: 8px; 
                    font-weight: bold; 
                    font-size: 14px; 
                    text-transform: uppercase; 
                    transition: color 0.3s ease; 

                    &:hover { 
                        color: var(--color-amarillo); 
                    }
                }
            }

            /* --- CONTENEDOR PRINCIPAL --- */
            .booking-container { 
                display: flex; 
                flex: 1; 
                padding: 40px 5%; 
                gap: 50px; 
                max-width: 1400px; 
                margin: 0 auto; 
                width: 100%; 

                /* ZONA IZQUIERDA: MAPA DE ASIENTOS */
                .seating-section { 
                    flex: 3; 
                    display: flex; 
                    flex-direction: column; 
                    align-items: center; 
                    
                    .movie-info { 
                        text-align: center; 
                        margin-bottom: 50px; 

                        h1 { 
                            font-family: 'Arial Black', sans-serif; 
                            font-size: 42px; 
                            color: var(--color-blanco); 
                            text-transform: uppercase; 
                            letter-spacing: 2px; 
                            margin-bottom: 10px; 
                            text-shadow: 0 5px 15px rgba(0,0,0,0.5);
                        }

                        p { 
                            color: var(--color-amarillo); 
                            font-size: 16px; 
                            font-weight: bold;
                            letter-spacing: 1px;
                        }
                    }

                    /* PANTALLA DEL CINE */
                    .screen-container { 
                        width: 100%; 
                        max-width: 600px; 
                        margin-bottom: 60px; 
                        perspective: 400px; 

                        .screen { 
                            height: 70px; 
                            width: 100%; 
                            background: linear-gradient(to bottom, rgba(255, 255, 255, 0.8), transparent); 
                            transform: rotateX(-45deg); 
                            box-shadow: 0 15px 50px rgba(255, 255, 255, 0.15); 
                            border-top: 4px solid var(--color-blanco); 
                            border-radius: 5px 5px 0 0; 
                            display: flex; 
                            justify-content: center; 
                            align-items: center; 
                            color: var(--color-blanco); 
                            font-weight: 900; 
                            letter-spacing: 8px; 
                            text-transform: uppercase; 
                            font-size: 12px; 
                            opacity: 0.8;
                        }
                    }

                    /* ASIENTOS */
                    .seats-grid { 
                        display: flex; 
                        flex-direction: column; 
                        gap: 15px; 
                        margin-bottom: 50px; 

                        .seat-row { 
                            display: flex; 
                            gap: 12px; 
                            justify-content: center; 
                            align-items: center; 

                            .row-label { 
                                color: #666; 
                                font-size: 12px; 
                                width: 20px; 
                                text-align: center; 
                                font-weight: bold; 
                            }

                            .seat { 
                                width: 38px; 
                                height: 38px; 
                                background-color: var(--color-asiento-libre); 
                                border-radius: 8px 8px 4px 4px; 
                                cursor: pointer; 
                                transition: all 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275); 
                                position: relative; 
                                border: 1px solid #333;

                                &::after { 
                                    content: ''; 
                                    position: absolute; 
                                    bottom: -5px; 
                                    left: 10%; 
                                    width: 80%; 
                                    height: 5px; 
                                    background-color: rgba(0,0,0,0.5); 
                                    border-radius: 0 0 4px 4px; 
                                }
                                
                                &:hover:not(.occupied) { 
                                    transform: translateY(-5px) scale(1.1); 
                                    background-color: #555; 
                                    border-color: #777;
                                }

                                &.selected { 
                                    background-color: var(--color-amarillo); 
                                    border-color: var(--color-amarillo);
                                    box-shadow: 0 0 15px rgba(255, 208, 0, 0.4); 
                                    transform: scale(1.1);
                                }

                                &.occupied { 
                                    background-color: var(--color-asiento-ocupado); 
                                    border-color: #111;
                                    cursor: not-allowed; 
                                    opacity: 0.4; 
                                }

                                &.vip { 
                                    background-color: var(--color-asiento-vip); 
                                    border-color: #724db8; 

                                    &.selected { 
                                        background-color: var(--color-amarillo); 
                                        border-color: var(--color-amarillo); 
                                    }
                                }

                                /* Pasillo central */
                                &:nth-child(6) { 
                                    margin-right: 30px; 
                                } 
                            }
                        }
                    }

                    /* LEYENDA */
                    .legend { 
                        display: flex; 
                        justify-content: center; 
                        gap: 30px; 
                        margin-top: 20px; 
                        padding: 20px 40px; 
                        background-color: rgba(20,20,20,0.8); 
                        border-radius: 50px; 
                        border: 1px solid #333;
                        backdrop-filter: blur(5px);

                        .legend-item { 
                            display: flex; 
                            align-items: center; 
                            gap: 10px; 
                            font-size: 13px; 
                            color: #aaa; 
                            font-weight: bold;

                            .legend-seat { 
                                width: 20px; 
                                height: 20px; 
                                border-radius: 4px 4px 2px 2px; 
                            }
                        }
                    }
                }

                /* ZONA DERECHA: RESUMEN DEL PEDIDO */
                .summary-section { 
                    flex: 1; 
                    min-width: 350px; 
                    background-color: rgba(20, 20, 20, 0.85); 
                    backdrop-filter: blur(15px);
                    border-radius: 12px; 
                    padding: 35px; 
                    border: 1px solid rgba(255,255,255,0.1); 
                    height: fit-content; 
                    position: sticky; 
                    top: 120px; 
                    box-shadow: 0 20px 50px rgba(0,0,0,0.5);

                    .summary-title { 
                        font-family: 'Arial Black', sans-serif; 
                        font-size: 20px; 
                        color: var(--color-blanco); 
                        text-transform: uppercase; 
                        border-bottom: 2px solid var(--color-amarillo); 
                        padding-bottom: 15px; 
                        margin-bottom: 25px; 
                    }
                    
                    .summary-details { 
                        margin-bottom: 30px; 

                        .summary-row { 
                            display: flex; 
                            justify-content: space-between; 
                            margin-bottom: 18px; 
                            font-size: 14px; 
                            color: #ccc; 

                            span.val { 
                                color: var(--color-blanco); 
                                font-weight: bold; 
                                text-align: right; 
                            }
                            
                            .selected-seats-list { 
                                display: flex; 
                                flex-wrap: wrap; 
                                gap: 8px; 
                                margin-top: 10px; 

                                .seat-badge { 
                                    background-color: transparent; 
                                    color: var(--color-amarillo); 
                                    border: 1px solid var(--color-amarillo);
                                    padding: 4px 10px; 
                                    border-radius: 4px; 
                                    font-size: 12px; 
                                    font-weight: bold; 
                                }
                            }
                        }
                    }

                    .total-row { 
                        display: flex; 
                        justify-content: space-between; 
                        align-items: center; 
                        border-top: 1px dashed #555; 
                        padding-top: 25px; 
                        margin-top: 15px; 
                        
                        .total-label { 
                            font-size: 16px; 
                            color: #888; 
                            font-weight: bold; 
                            text-transform: uppercase; 
                            letter-spacing: 1px;
                        }
                        
                        .total-price { 
                            font-size: 32px; 
                            color: var(--color-amarillo); 
                            font-family: 'Arial Black', sans-serif; 
                        }
                    }

                    .btn-checkout { 
                        width: 100%; 
                        background-color: var(--color-amarillo); 
                        color: var(--color-texto-btn); 
                        border: none; 
                        padding: 18px; 
                        border-radius: 6px; 
                        font-family: 'Arial Black', sans-serif; 
                        font-size: 14px; 
                        text-transform: uppercase; 
                        cursor: pointer; 
                        transition: all 0.3s ease; 
                        margin-top: 35px; 
                        display: flex; 
                        justify-content: center; 
                        align-items: center; 
                        gap: 10px; 

                        &:hover:not(:disabled) { 
                            background-color: var(--color-blanco); 
                            color: var(--color-negro);
                            transform: translateY(-3px); 
                            box-shadow: 0 10px 20px rgba(0,0,0,0.3); 
                        }

                        &:disabled { 
                            background-color: #333; 
                            color: #666; 
                            cursor: not-allowed; 
                        }
                    }
                }
            }
        }
    </style>
</head>
<body>

    <img src="{{ asset($movie['bgImg'] ?? '') }}" class="page-bg" onerror="this.src='https://via.placeholder.com/1920x1080/111/333'">
    <div class="page-bg-gradient"></div>

    <header>
        <a href="/pelicula/{{ $id }}" class="back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Back to Movie
        </a>
        <div class="logo"><a href="/"><img src="{{ asset('img/img/Logo-Blanco.png') }}" alt="Screenbites Logo"></a></div>
        <div style="width: 130px;"></div> </header>

    <div class="booking-container">
        
        <div class="seating-section">
            <div class="movie-info">
                <h1>{{ $movie['title'] ?? 'Movie' }}</h1>
                <p>Today, 20:30 &nbsp;•&nbsp; Room 4 &nbsp;•&nbsp; {{ $movie['age'] ?? '+18' }}</p>
            </div>

            <div class="screen-container">
                <div class="screen">Screen</div>
            </div>

            <div class="seats-grid" id="seats-container">
                </div>

            <div class="legend">
                <div class="legend-item"><div class="legend-seat" style="background-color: var(--color-asiento-libre);"></div> Standard ($8.50)</div>
                <div class="legend-item"><div class="legend-seat" style="background-color: var(--color-asiento-vip);"></div> VIP ($12.00)</div>
                <div class="legend-item"><div class="legend-seat" style="background-color: var(--color-amarillo);"></div> Selected</div>
                <div class="legend-item"><div class="legend-seat" style="background-color: var(--color-asiento-ocupado);"></div> Occupied</div>
            </div>
        </div>

        <div class="summary-section">
            <h2 class="summary-title">Booking Summary</h2>
            
            <div class="summary-details">
                <div class="summary-row">
                    <span>Movie</span>
                    <span class="val">{{ $movie['title'] ?? 'Movie' }}</span>
                </div>
                <div class="summary-row">
                    <span>Session</span>
                    <span class="val">Today, 20:30</span>
                </div>
                <div class="summary-row" style="flex-direction: column; gap: 10px; margin-top: 25px;">
                    <span style="border-bottom: 1px solid #333; padding-bottom: 8px;">Selected Seats:</span>
                    <div class="selected-seats-list" id="selected-seats-display">
                        <span style="color: #666; font-size: 13px; font-style: italic;">No seats selected yet.</span>
                    </div>
                </div>
                <div class="summary-row" style="margin-top: 25px;">
                    <span>Tickets Total</span>
                    <span class="val" id="tickets-price" style="font-size: 18px;">$0.00</span>
                </div>
            </div>

            <div class="total-row">
                <span class="total-label">Total</span>
                <span class="total-price" id="total-price">$0.00</span>
            </div>

            <button class="btn-checkout" id="btn-continue" disabled>
                Continue to Food
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </button>
        </div>

    </div>

    @php
        // Convertimos el ID de la película en un número único.
        // Así, Kill Bill (01) siempre generará el mismo patrón, y Godzilla (03) el suyo propio.
        $seed = crc32($id);
        mt_srand($seed);

        $rowsArray = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
        $seatsPerRowArray = 10;
        $occupiedArray = [];

        // Cada película tendrá entre 10 y 35 asientos ocupados (de 70 totales)
        $targetOccupied = mt_rand(10, 35); 
        $currentOccupied = 0;
        $attempts = 0;

        while ($currentOccupied < $targetOccupied && $attempts < 200) {
            $attempts++;
            
            // Lógica de agrupaciones:
            // Es mucho más común ver parejas (2) o tríos (3). 
            // A veces va alguien solo (1) y rara vez grupos grandes (4 o 5).
            $groupSizes = [1, 2, 2, 2, 3, 3, 4, 5];
            $groupSize = $groupSizes[mt_rand(0, count($groupSizes) - 1)];

            $randomRow = $rowsArray[mt_rand(0, count($rowsArray) - 1)];
            $startSeat = mt_rand(1, $seatsPerRowArray - $groupSize + 1);

            $canPlace = true;
            $tempSeats = [];
            
            // Comprobar si ese bloque de butacas está libre
            for ($i = 0; $i < $groupSize; $i++) {
                $seatId = $randomRow . ($startSeat + $i);
                if (in_array($seatId, $occupiedArray)) {
                    $canPlace = false;
                    break;
                }
                $tempSeats[] = $seatId;
            }

            // Si están libres, los ocupamos
            if ($canPlace) {
                $occupiedArray = array_merge($occupiedArray, $tempSeats);
                $currentOccupied += $groupSize;
            }
        }
        
        // Devolvemos el generador a la normalidad para no afectar a Laravel
        mt_srand();
    @endphp

    <script>
        const STANDARD_PRICE = 8.50;
        const VIP_PRICE = 12.00;
        
        const rows = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
        const seatsPerRow = 10;
        const vipRows = ['D', 'E']; // Filas D y E son VIP
        
        // RECIBIMOS LOS ASIENTOS OCUPADOS DESDE PHP PARA ESTA PELÍCULA EN CONCRETO
        const occupiedSeats = {!! json_encode($occupiedArray) !!};

        let selectedSeats = [];
        let currentTotal = 0;

        const seatsContainer = document.getElementById('seats-container');
        const selectedSeatsDisplay = document.getElementById('selected-seats-display');
        const ticketsPriceDisplay = document.getElementById('tickets-price');
        const totalPriceDisplay = document.getElementById('total-price');
        const btnContinue = document.getElementById('btn-continue');

        function generateSeats() {
            rows.forEach(row => {
                const rowDiv = document.createElement('div');
                rowDiv.className = 'seat-row';
                
                const labelDiv = document.createElement('div');
                labelDiv.className = 'row-label';
                labelDiv.innerText = row;
                rowDiv.appendChild(labelDiv);

                for (let i = 1; i <= seatsPerRow; i++) {
                    const seatId = `${row}${i}`;
                    const seatDiv = document.createElement('div');
                    seatDiv.className = 'seat';
                    seatDiv.dataset.seatId = seatId;

                    if (occupiedSeats.includes(seatId)) {
                        seatDiv.classList.add('occupied');
                    } else {
                        if (vipRows.includes(row)) {
                            seatDiv.classList.add('vip');
                            seatDiv.dataset.price = VIP_PRICE;
                        } else {
                            seatDiv.dataset.price = STANDARD_PRICE;
                        }

                        seatDiv.addEventListener('click', () => toggleSeat(seatDiv));
                    }

                    rowDiv.appendChild(seatDiv);
                }
                
                const labelDivRight = document.createElement('div');
                labelDivRight.className = 'row-label';
                labelDivRight.innerText = row;
                rowDiv.appendChild(labelDivRight);

                seatsContainer.appendChild(rowDiv);
            });
        }

        function toggleSeat(seatElement) {
            const seatId = seatElement.dataset.seatId;
            const price = parseFloat(seatElement.dataset.price);

            if (seatElement.classList.contains('selected')) {
                seatElement.classList.remove('selected');
                selectedSeats = selectedSeats.filter(s => s.id !== seatId);
            } else {
                if(selectedSeats.length >= 8) {
                    alert("You can only select up to 8 seats per transaction.");
                    return;
                }
                seatElement.classList.add('selected');
                selectedSeats.push({ id: seatId, price: price });
            }

            updateSummary();
        }

        function updateSummary() {
            if (selectedSeats.length === 0) {
                selectedSeatsDisplay.innerHTML = '<span style="color: #666; font-size: 13px; font-style: italic;">No seats selected yet.</span>';
                ticketsPriceDisplay.innerText = '$0.00';
                totalPriceDisplay.innerText = '$0.00';
                btnContinue.disabled = true;
                currentTotal = 0;
                return;
            }

            selectedSeatsDisplay.innerHTML = '';
            currentTotal = 0;

            selectedSeats.sort((a, b) => a.id.localeCompare(b.id));

            selectedSeats.forEach(seat => {
                currentTotal += seat.price;
                const badge = document.createElement('span');
                badge.className = 'seat-badge';
                badge.innerText = seat.id;
                selectedSeatsDisplay.appendChild(badge);
            });

            const formattedTotal = `$${currentTotal.toFixed(2)}`;
            ticketsPriceDisplay.innerText = formattedTotal;
            totalPriceDisplay.innerText = formattedTotal;
            
            btnContinue.disabled = false;
        }

        btnContinue.addEventListener('click', () => {
            const seatsParam = selectedSeats.map(s => s.id).join(',');
            const totalParam = currentTotal.toFixed(2);
            window.location.href = `/booking/{{ $id }}/food?seats=${seatsParam}&ticketsTotal=${totalParam}`;
        });

        generateSeats();

    </script>
</body>
</html>