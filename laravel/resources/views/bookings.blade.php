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
            --color-amarillo: #ffd000;
            --color-asiento-libre: #444444;
            --color-asiento-ocupado: #1a1a1a;
            --color-asiento-vip: #8a7300;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Arial', sans-serif; background-color: var(--color-negro); color: var(--color-blanco); min-height: 100vh; display: flex; flex-direction: column; }

        /* HEADER SENCILLO */
        header { padding: 20px 5%; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--color-gris-claro); background-color: var(--color-gris-oscuro); }
        .logo img { height: 40px; }
        .back-btn { color: var(--color-blanco); text-decoration: none; display: flex; align-items: center; gap: 8px; font-weight: bold; font-size: 14px; text-transform: uppercase; transition: color 0.3s; }
        .back-btn:hover { color: var(--color-amarillo); }

        /* CONTENEDOR PRINCIPAL */
        .booking-container { display: flex; flex: 1; padding: 40px 5%; gap: 40px; max-width: 1400px; margin: 0 auto; width: 100%; }

        /* ZONA IZQUIERDA: MAPA DE ASIENTOS */
        .seating-section { flex: 3; display: flex; flex-direction: column; align-items: center; }
        
        .movie-info { text-align: center; margin-bottom: 40px; }
        .movie-info h1 { font-family: 'Arial Black', sans-serif; font-size: 32px; color: var(--color-amarillo); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; }
        .movie-info p { color: #888; font-size: 14px; }

        /* PANTALLA DEL CINE */
        .screen-container { width: 100%; max-width: 600px; margin-bottom: 50px; perspective: 400px; }
        .screen { height: 60px; width: 100%; background: linear-gradient(to bottom, rgba(255, 208, 0, 0.5), transparent); transform: rotateX(-45deg); box-shadow: 0 15px 35px rgba(255, 208, 0, 0.2); border-top: 4px solid var(--color-amarillo); border-radius: 5px 5px 0 0; display: flex; justify-content: center; align-items: center; color: var(--color-amarillo); font-weight: bold; letter-spacing: 5px; text-transform: uppercase; font-size: 12px; }

        /* ASIENTOS */
        .seats-grid { display: flex; flex-direction: column; gap: 15px; margin-bottom: 40px; }
        .seat-row { display: flex; gap: 10px; justify-content: center; align-items: center; }
        .row-label { color: #666; font-size: 12px; width: 20px; text-align: center; font-weight: bold; }
        
        /* Pasillo central */
        .seat-row .seat:nth-child(6) { margin-left: 30px; }

        .seat { width: 35px; height: 35px; background-color: var(--color-asiento-libre); border-radius: 8px 8px 4px 4px; cursor: pointer; transition: all 0.2s ease; position: relative; box-shadow: inset 0 -3px 0 rgba(0,0,0,0.3); }
        .seat::after { content: ''; position: absolute; bottom: -5px; left: 10%; width: 80%; height: 5px; background-color: rgba(0,0,0,0.5); border-radius: 0 0 4px 4px; }
        
        .seat:hover:not(.occupied) { transform: scale(1.1); background-color: #666; }
        .seat.selected { background-color: var(--color-amarillo); box-shadow: 0 0 10px rgba(255, 208, 0, 0.5), inset 0 -3px 0 rgba(0,0,0,0.2); }
        .seat.occupied { background-color: var(--color-asiento-ocupado); cursor: not-allowed; opacity: 0.5; }
        .seat.vip { background-color: var(--color-asiento-vip); }
        .seat.vip.selected { background-color: var(--color-amarillo); }

        /* LEYENDA */
        .legend { display: flex; justify-content: center; gap: 30px; margin-top: 20px; padding: 20px; background-color: var(--color-gris-tarjeta); border-radius: 8px; width: 100%; max-width: 600px; }
        .legend-item { display: flex; align-items: center; gap: 10px; font-size: 13px; color: #aaa; }
        .legend-seat { width: 20px; height: 20px; border-radius: 4px 4px 2px 2px; }

        /* ZONA DERECHA: RESUMEN DEL PEDIDO */
        .summary-section { flex: 1; min-width: 300px; background-color: var(--color-gris-tarjeta); border-radius: 12px; padding: 30px; border: 1px solid var(--color-gris-claro); height: fit-content; position: sticky; top: 120px; }
        .summary-title { font-family: 'Arial Black', sans-serif; font-size: 20px; color: var(--color-blanco); text-transform: uppercase; border-bottom: 2px solid var(--color-amarillo); padding-bottom: 15px; margin-bottom: 20px; }
        
        .summary-details { margin-bottom: 30px; }
        .summary-row { display: flex; justify-content: space-between; margin-bottom: 15px; font-size: 14px; color: #ccc; }
        .summary-row span.val { color: var(--color-blanco); font-weight: bold; text-align: right; }
        
        .selected-seats-list { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 5px; }
        .seat-badge { background-color: var(--color-amarillo); color: var(--color-negro); padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; }

        .total-row { display: flex; justify-content: space-between; align-items: center; border-top: 1px dashed #444; padding-top: 20px; margin-top: 10px; }
        .total-label { font-size: 16px; color: var(--color-blanco); font-weight: bold; }
        .total-price { font-size: 24px; color: var(--color-amarillo); font-family: 'Arial Black', sans-serif; }

        .btn-checkout { width: 100%; background-color: var(--color-amarillo); color: var(--color-negro); border: none; padding: 15px; border-radius: 6px; font-family: 'Arial Black', sans-serif; font-size: 14px; text-transform: uppercase; cursor: pointer; transition: all 0.3s ease; margin-top: 30px; display: flex; justify-content: center; align-items: center; gap: 10px; }
        .btn-checkout:hover { background-color: var(--color-blanco); transform: translateY(-2px); box-shadow: 0 5px 15px rgba(255, 255, 255, 0.2); }
        .btn-checkout:disabled { background-color: #444; color: #888; cursor: not-allowed; transform: none; box-shadow: none; }

    </style>
</head>
<body>

    <header>
        <a href="/" class="back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Back to Home
        </a>
        <div class="logo"><img src="{{ asset('img/img/Logo-Blanco.png') }}" alt="Screenbites Logo"></div>
        <div style="width: 100px;"></div> </header>

    <div class="booking-container">
        
        <div class="seating-section">
            <div class="movie-info">
                <h1>Kill Bill</h1>
                <p>Today, 20:30 • English (Sub) • Room 4</p>
            </div>

            <div class="screen-container">
                <div class="screen">Screen</div>
            </div>

            <div class="seats-grid" id="seats-container">
                </div>

            <div class="legend">
                <div class="legend-item"><div class="legend-seat" style="background-color: var(--color-asiento-libre);"></div> Available</div>
                <div class="legend-item"><div class="legend-seat" style="background-color: var(--color-amarillo);"></div> Selected</div>
                <div class="legend-item"><div class="legend-seat" style="background-color: var(--color-asiento-vip);"></div> VIP ($12.00)</div>
                <div class="legend-item"><div class="legend-seat" style="background-color: var(--color-asiento-ocupado); opacity: 0.5;"></div> Occupied</div>
            </div>
        </div>

        <div class="summary-section">
            <h2 class="summary-title">Booking Summary</h2>
            
            <div class="summary-details">
                <div class="summary-row">
                    <span>Movie</span>
                    <span class="val">Kill Bill</span>
                </div>
                <div class="summary-row">
                    <span>Date & Time</span>
                    <span class="val">Today, 20:30</span>
                </div>
                <div class="summary-row" style="flex-direction: column; gap: 10px;">
                    <span>Selected Seats:</span>
                    <div class="selected-seats-list" id="selected-seats-display">
                        <span style="color: #666; font-size: 12px; font-style: italic;">No seats selected yet.</span>
                    </div>
                </div>
                <div class="summary-row" style="margin-top: 20px;">
                    <span>Tickets Total</span>
                    <span class="val" id="tickets-price">$0.00</span>
                </div>
            </div>

            <div class="total-row">
                <span class="total-label">TOTAL</span>
                <span class="total-price" id="total-price">$0.00</span>
            </div>

            <button class="btn-checkout" id="btn-continue" disabled>
                Continue to Food & Drinks
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </button>
        </div>

    </div>

    <script>
        const STANDARD_PRICE = 8.50;
        const VIP_PRICE = 12.00;
        
        // Configuracion de la sala (Filas de la A a la F, 10 asientos por fila)
        const rows = ['A', 'B', 'C', 'D', 'E', 'F'];
        const seatsPerRow = 10;
        
        // Simulamos asientos ocupados y VIP
        const occupiedSeats = ['B4', 'B5', 'D8', 'D9', 'E1', 'E2', 'E3'];
        const vipRows = ['D', 'E']; // Filas D y E son VIP

        let selectedSeats = [];

        const seatsContainer = document.getElementById('seats-container');
        const selectedSeatsDisplay = document.getElementById('selected-seats-display');
        const ticketsPriceDisplay = document.getElementById('tickets-price');
        const totalPriceDisplay = document.getElementById('total-price');
        const btnContinue = document.getElementById('btn-continue');

        // Generar mapa de asientos
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

                    // Asignar clases especiales
                    if (occupiedSeats.includes(seatId)) {
                        seatDiv.classList.add('occupied');
                    } else {
                        if (vipRows.includes(row)) {
                            seatDiv.classList.add('vip');
                            seatDiv.dataset.price = VIP_PRICE;
                        } else {
                            seatDiv.dataset.price = STANDARD_PRICE;
                        }

                        // Evento de clic para seleccionar
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
                // Deseleccionar
                seatElement.classList.remove('selected');
                selectedSeats = selectedSeats.filter(s => s.id !== seatId);
            } else {
                // Seleccionar (Máximo 8 entradas)
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
                selectedSeatsDisplay.innerHTML = '<span style="color: #666; font-size: 12px; font-style: italic;">No seats selected yet.</span>';
                ticketsPriceDisplay.innerText = '$0.00';
                totalPriceDisplay.innerText = '$0.00';
                btnContinue.disabled = true;
                return;
            }

            selectedSeatsDisplay.innerHTML = '';
            let total = 0;

            // Ordenar asientos alfabéticamente (A1, A2, B1...)
            selectedSeats.sort((a, b) => a.id.localeCompare(b.id));

            selectedSeats.forEach(seat => {
                total += seat.price;
                const badge = document.createElement('span');
                badge.className = 'seat-badge';
                badge.innerText = seat.id;
                selectedSeatsDisplay.appendChild(badge);
            });

            const formattedTotal = `$${total.toFixed(2)}`;
            ticketsPriceDisplay.innerText = formattedTotal;
            totalPriceDisplay.innerText = formattedTotal;
            
            btnContinue.disabled = false;
        }

        // Inicializar
        generateSeats();

    </script>
</body>
</html>