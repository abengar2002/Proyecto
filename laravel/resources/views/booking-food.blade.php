<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Screenbites - Food & Drinks</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <style>
        :root {
            --color-negro: #000000;
            --color-gris-oscuro: #0a0a0a;
            --color-gris-tarjeta: #141414;
            --color-blanco: #ffffff;
            --color-amarillo: {{ $movie['bg'] ?? '#ffd000' }}; 
            --color-texto-btn: {{ $movie['textColor'] ?? 'black' }};
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Arial', sans-serif; background-color: var(--color-negro); color: var(--color-blanco); min-height: 100vh; display: flex; flex-direction: column; position: relative; }

        .page-bg { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -2; object-fit: cover; opacity: 0.15; filter: blur(8px); }
        .page-bg-gradient { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; background: radial-gradient(circle at center, transparent 0%, var(--color-negro) 80%); }

        header { padding: 20px 5%; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.05); background-color: rgba(0,0,0,0.8); backdrop-filter: blur(10px); position: sticky; top: 0; z-index: 100; }
        header .logo img { height: 40px; }
        .back-btn { color: var(--color-blanco); text-decoration: none; display: flex; align-items: center; gap: 8px; font-weight: bold; font-size: 14px; text-transform: uppercase; transition: color 0.3s ease; }
        .back-btn:hover { color: var(--color-amarillo); }

        .food-container { display: flex; flex: 1; padding: 40px 5%; gap: 50px; max-width: 1400px; margin: 0 auto; width: 100%; }
        .menu-section { flex: 3; }
        
        .menu-header { margin-bottom: 40px; }
        .menu-header h1 { font-family: 'Arial Black', sans-serif; font-size: 42px; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 10px; }
        .menu-header p { color: var(--color-amarillo); font-size: 16px; font-weight: bold; letter-spacing: 1px; }

        .food-category { margin-bottom: 50px; }
        .food-category h2 { font-size: 24px; text-transform: uppercase; border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 25px; color: var(--color-blanco); }

        .food-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 25px; }
        
        /* DISEÑO FOOD CARD */
        .food-card {
            background: rgba(20,20,20,0.8); border: 1px solid #333; border-radius: 16px; overflow: hidden; 
            transition: 0.3s ease; display: flex; flex-direction: column; position: relative;
        }
        .food-card:hover { border-color: var(--color-amarillo); transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.5); }
        .food-card.exclusive { border-color: var(--color-amarillo); box-shadow: 0 0 20px rgba(255, 208, 0, 0.15); }
        
        /* ESTADO AGOTADO */
        .food-card.sold-out { opacity: 0.5; filter: grayscale(100%); border-color: #333 !important; }
        .food-card.sold-out:hover { transform: none; box-shadow: none; }

        .food-img { height: 180px; width: 100%; object-fit: cover; background-color: #111; }
        .food-info { padding: 20px; flex: 1; display: flex; flex-direction: column; justify-content: space-between; }
        .food-tag { position: absolute; top: 10px; right: 10px; font-size: 10px; background: var(--color-amarillo); color: var(--color-texto-btn); padding: 5px 10px; border-radius: 8px; font-weight: bold; text-transform: uppercase; box-shadow: 0 2px 10px rgba(0,0,0,0.5); }
        
        .food-info h3 { font-size: 16px; margin-bottom: 5px; text-transform: uppercase; line-height: 1.2; }
        .food-info p.desc { font-size: 12px; color: #888; margin-bottom: 15px; line-height: 1.4; min-height: 34px; }
        
        .price-row { display: flex; justify-content: space-between; align-items: center; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 15px; }
        .food-price { font-size: 20px; color: var(--color-amarillo); font-weight: bold; font-family: 'Arial Black', sans-serif; }

        .qty-controls { display: flex; align-items: center; background: #000; border: 1px solid #444; border-radius: 8px; overflow: hidden; }
        .qty-controls button { background: transparent; color: white; border: none; padding: 8px 15px; cursor: pointer; font-size: 18px; font-weight: bold; transition: 0.2s; }
        .qty-controls button:hover { background: #333; color: var(--color-amarillo); }
        .qty-val { font-size: 14px; font-weight: bold; width: 25px; text-align: center; }

        /* ZONA DERECHA */
        .summary-section { flex: 1; min-width: 350px; background: rgba(20,20,20,0.85); backdrop-filter: blur(15px); border-radius: 16px; padding: 35px; border: 1px solid rgba(255,255,255,0.1); height: fit-content; position: sticky; top: 120px; box-shadow: 0 20px 50px rgba(0,0,0,0.5); }
        .summary-title { font-family: 'Arial Black', sans-serif; font-size: 20px; text-transform: uppercase; border-bottom: 2px solid var(--color-amarillo); padding-bottom: 15px; margin-bottom: 25px; }
        .cart-items { margin-bottom: 25px; min-height: 100px; max-height: 350px; overflow-y: auto; padding-right: 10px; }
        .cart-items::-webkit-scrollbar { width: 4px; }
        .cart-items::-webkit-scrollbar-thumb { background: #555; border-radius: 4px; }
        .cart-item { display: flex; justify-content: space-between; margin-bottom: 15px; font-size: 13px; color: #ccc; }
        .cart-item .item-price { font-weight: bold; color: white; }
        .total-row { display: flex; justify-content: space-between; align-items: center; border-top: 1px dashed #555; padding-top: 25px; margin-top: 15px; }
        .total-label { font-size: 16px; color: #888; font-weight: bold; text-transform: uppercase; }
        .total-price { font-size: 32px; color: var(--color-amarillo); font-family: 'Arial Black', sans-serif; }
        .btn-checkout { width: 100%; background: var(--color-amarillo); color: var(--color-texto-btn); border: none; padding: 18px; border-radius: 8px; font-family: 'Arial Black', sans-serif; font-size: 14px; text-transform: uppercase; cursor: pointer; transition: 0.3s; margin-top: 35px; display: flex; justify-content: center; align-items: center; gap: 10px; }
        .btn-checkout:hover { background: white; color: black; transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.3); }

        /* WIDGET TEMPORIZADOR */
        #countdown-widget { position: fixed; top: 100px; right: 5%; background: var(--color-amarillo); color: var(--color-texto-btn); padding: 10px 18px; border-radius: 8px; font-family: 'Arial Black', sans-serif; font-size: 14px; z-index: 9999; box-shadow: 0 10px 25px rgba(0,0,0,0.5); display: flex; align-items: center; gap: 10px; border: 1px solid rgba(255,255,255,0.2); }
    </style>
</head>
<body>

    <div id="countdown-widget">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
        <span id="timer-display">10:00</span>
    </div>

    <img src="{{ $movie['bgImg'] ?? '' }}" class="page-bg" onerror="this.src='https://via.placeholder.com/1920x1080/111/333'">
    <div class="page-bg-gradient"></div>

    <header>
        <a href="/booking/{{ $id }}" class="back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Back to Seats
        </a>
        <div class="logo"><a href="/"><img src="{{ asset('img/img/Logo-Blanco.png') }}" alt="Screenbites Logo"></a></div>
        <div style="width: 130px;"></div>
    </header>

    <div class="food-container">
        
        <div class="menu-section">
            <div class="menu-header">
                <h1>Food & Drinks</h1>
                <p>Enhance your movie experience. Pre-order now.</p>
            </div>

            @if(isset($menu['exclusive']) && count($menu['exclusive']) > 0)
                <div class="food-category">
                    <h2>Exclusive for {{ $movie['title'] }}</h2>
                    <div class="food-grid">
                        @foreach($menu['exclusive'] as $item)
                            @php $isSoldOut = ($item['stock'] <= 0 || $item['spent']); @endphp
                            <div class="food-card exclusive {{ $isSoldOut ? 'sold-out' : '' }}" data-name="{{ $item['name'] }}" data-price="{{ $item['price'] }}" data-stock="{{ $item['stock'] }}" data-exclusive="true">
                                @if($isSoldOut)
                                    <span class="food-tag" style="background: #ff4444; color: white;">Sold Out</span>
                                @else
                                    <span class="food-tag">Limited</span>
                                @endif
                                <img src="{{ $item['img'] }}" onerror="this.src='https://via.placeholder.com/400x250/111/ffd000?text=Menu'" class="food-img">
                                <div class="food-info">
                                    <div>
                                        <h3>{{ $item['name'] }}</h3>
                                        <p class="desc">{{ $item['desc'] }}</p>
                                    </div>
                                    <div class="price-row">
                                        <div class="food-price">${{ number_format($item['price'], 2) }}</div>
                                        @if($isSoldOut)
                                            <div style="color: #ff4444; font-weight: bold; font-size: 14px; text-transform: uppercase;">Out of Stock</div>
                                        @else
                                            <div class="qty-controls"><button onclick="updateQty(this, -1)">-</button><span class="qty-val">0</span><button onclick="updateQty(this, 1)">+</button></div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if(isset($menu['popcorn']) && count($menu['popcorn']) > 0)
                <div class="food-category">
                    <h2>Popcorn & Combos</h2>
                    <div class="food-grid">
                        @foreach($menu['popcorn'] as $item)
                            @php $isSoldOut = ($item['stock'] <= 0 || $item['spent']); @endphp
                            <div class="food-card {{ $isSoldOut ? 'sold-out' : '' }}" data-name="{{ $item['name'] }}" data-price="{{ $item['price'] }}" data-stock="{{ $item['stock'] }}" data-exclusive="false">
                                @if($isSoldOut)
                                    <span class="food-tag" style="background: #ff4444; color: white;">Sold Out</span>
                                @endif
                                <img src="{{ $item['img'] }}" onerror="this.src='https://via.placeholder.com/400x250/111/333?text=Popcorn'" class="food-img">
                                <div class="food-info">
                                    <div>
                                        <h3>{{ $item['name'] }}</h3>
                                        <p class="desc">{{ $item['desc'] }}</p>
                                    </div>
                                    <div class="price-row">
                                        <div class="food-price">${{ number_format($item['price'], 2) }}</div>
                                        @if($isSoldOut)
                                            <div style="color: #ff4444; font-weight: bold; font-size: 14px; text-transform: uppercase;">Out of Stock</div>
                                        @else
                                            <div class="qty-controls"><button onclick="updateQty(this, -1)">-</button><span class="qty-val">0</span><button onclick="updateQty(this, 1)">+</button></div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if(isset($menu['drinks']) && count($menu['drinks']) > 0)
                <div class="food-category">
                    <h2>Fresh Drinks</h2>
                    <div class="food-grid">
                        @foreach($menu['drinks'] as $item)
                            @php $isSoldOut = ($item['stock'] <= 0 || $item['spent']); @endphp
                            <div class="food-card {{ $isSoldOut ? 'sold-out' : '' }}" data-name="{{ $item['name'] }}" data-price="{{ $item['price'] }}" data-stock="{{ $item['stock'] }}" data-exclusive="false">
                                @if($isSoldOut)
                                    <span class="food-tag" style="background: #ff4444; color: white;">Sold Out</span>
                                @endif
                                <img src="{{ $item['img'] }}" onerror="this.src='https://via.placeholder.com/400x250/111/333?text=Drink'" class="food-img">
                                <div class="food-info">
                                    <div>
                                        <h3>{{ $item['name'] }}</h3>
                                        <p class="desc">{{ $item['desc'] }}</p>
                                    </div>
                                    <div class="price-row">
                                        <div class="food-price">${{ number_format($item['price'], 2) }}</div>
                                        @if($isSoldOut)
                                            <div style="color: #ff4444; font-weight: bold; font-size: 14px; text-transform: uppercase;">Out of Stock</div>
                                        @else
                                            <div class="qty-controls"><button onclick="updateQty(this, -1)">-</button><span class="qty-val">0</span><button onclick="updateQty(this, 1)">+</button></div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if(isset($menu['snacks']) && count($menu['snacks']) > 0)
                <div class="food-category">
                    <h2>Snacks & Sweets</h2>
                    <div class="food-grid">
                        @foreach($menu['snacks'] as $item)
                            @php $isSoldOut = ($item['stock'] <= 0 || $item['spent']); @endphp
                            <div class="food-card {{ $isSoldOut ? 'sold-out' : '' }}" data-name="{{ $item['name'] }}" data-price="{{ $item['price'] }}" data-stock="{{ $item['stock'] }}" data-exclusive="false">
                                @if($isSoldOut)
                                    <span class="food-tag" style="background: #ff4444; color: white;">Sold Out</span>
                                @endif
                                <img src="{{ $item['img'] }}" onerror="this.src='https://via.placeholder.com/400x250/111/333?text=Snack'" class="food-img">
                                <div class="food-info">
                                    <div>
                                        <h3>{{ $item['name'] }}</h3>
                                        <p class="desc">{{ $item['desc'] }}</p>
                                    </div>
                                    <div class="price-row">
                                        <div class="food-price">${{ number_format($item['price'], 2) }}</div>
                                        @if($isSoldOut)
                                            <div style="color: #ff4444; font-weight: bold; font-size: 14px; text-transform: uppercase;">Out of Stock</div>
                                        @else
                                            <div class="qty-controls"><button onclick="updateQty(this, -1)">-</button><span class="qty-val">0</span><button onclick="updateQty(this, 1)">+</button></div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>

        <div class="summary-section">
            <h2 class="summary-title">Order Summary</h2>
            <div class="cart-items" id="cart-items-container"></div>
            
            <div class="total-row">
                <span class="total-label">Total</span>
                <span class="total-price" id="grand-total">$0.00</span>
            </div>

            <button class="btn-checkout" onclick="proceedToCheckout()">
                Proceed to Checkout
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
            </button>
        </div>

    </div>

    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const seatsParam = urlParams.get('seats');
        const ticketsTotalParam = parseFloat(urlParams.get('ticketsTotal')) || 0;
        
        const maxItemsLimit = seatsParam ? seatsParam.split(',').length : 1;
        
        let cart = {};
        if (seatsParam && ticketsTotalParam > 0) {
            cart['Tickets'] = { name: `Tickets (${seatsParam})`, price: ticketsTotalParam, qty: 1, isFixed: true };
        }

        const cartContainer = document.getElementById('cart-items-container');
        const grandTotalDisplay = document.getElementById('grand-total');

        // --- FUNCIÓN TOASTIFY PERSONALIZADA (CON SVGs) ---
        function showToast(message, type = 'info') {
            let iconSvg = '';
            
            if (type === 'warning') {
                // Icono de Alerta (Triángulo)
                iconSvg = `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--color-amarillo)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>`;
            } else if (type === 'ticket') {
                // Icono de Ticket
                iconSvg = `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--color-amarillo)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="10" rx="2" ry="2"></rect><path d="M2 12h20"></path><path d="M7 7v10"></path><path d="M17 7v10"></path></svg>`;
            } else {
                // Icono de Info (Círculo)
                iconSvg = `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--color-amarillo)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>`;
            }

            Toastify({
                // Metemos el SVG y el texto en un contenedor flexbox para que queden alineados
                text: `<div style="display: flex; align-items: center; gap: 10px;">${iconSvg} <span>${message}</span></div>`,
                escapeMarkup: false, // <-- IMPORTANTE: Permite que Toastify lea nuestro código HTML/SVG
                duration: 3000,
                gravity: "top",
                position: "right",
                style: {
                    background: "#141414",
                    color: "#ffffff",
                    borderLeft: "4px solid var(--color-amarillo)",
                    fontFamily: "'Arial Black', sans-serif",
                    fontSize: "12px",
                    borderRadius: "4px",
                    boxShadow: "0 5px 15px rgba(0,0,0,0.5)"
                }
            }).showToast();
        }

        function updateQty(btn, change) {
            const card = btn.closest('.food-card');
            const name = card.dataset.name;
            const price = parseFloat(card.dataset.price);
            const stock = parseInt(card.dataset.stock); 
            const isExclusive = card.dataset.exclusive === "true";
            const qtySpan = card.querySelector('.qty-val');
            
            let currentQty = parseInt(qtySpan.innerText);
            let newQty = currentQty + change;
            
            if (newQty < 0) newQty = 0; 

            // Límite de stock real
            if (newQty > stock) {
                showToast(`Sorry, we only have ${stock} units left!`, 'warning');
                newQty = stock;
            }

            // Límite de carrito: 1 si es exclusivo, 2 si es normal
            const allowedLimit = isExclusive ? maxItemsLimit : maxItemsLimit * 2;
            
            if (newQty > allowedLimit) { 
                if (isExclusive) {
                    showToast(`Exclusive combos are limited to 1 per person.`, 'ticket');
                } else {
                    showToast(`Maximum order limit reached for your party size.`, 'info');
                }
                newQty = allowedLimit;
            }
            
            qtySpan.innerText = newQty;

            if (newQty === 0) {
                delete cart[name];
            } else {
                cart[name] = { name: name, price: price, qty: newQty, isFixed: false };
            }
            renderCart();
        }

        function renderCart() {
            cartContainer.innerHTML = '';
            let grandTotal = 0;
            const items = Object.values(cart);

            if (items.length === 0) {
                cartContainer.innerHTML = '<span style="color: #666; font-style: italic;">Your cart is empty.</span>';
                grandTotalDisplay.innerText = '$0.00';
                return;
            }

            items.forEach(item => {
                const itemTotal = item.isFixed ? item.price : item.price * item.qty;
                grandTotal += itemTotal;
                const qtyText = item.isFixed ? '' : `${item.qty}x `;
                
                cartContainer.innerHTML += `
                    <div class="cart-item">
                        <span class="item-name">${qtyText}${item.name}</span>
                        <span class="item-price">$${itemTotal.toFixed(2)}</span>
                    </div>
                `;
            });
            grandTotalDisplay.innerText = `$${grandTotal.toFixed(2)}`;
        }

        function proceedToCheckout() {
            sessionStorage.setItem('screenbites_cart', JSON.stringify(cart));
            window.location.href = `/booking/{{ $id }}/checkout`;
        }
        renderCart();

        // TIMER LOGIC (CON SWEETALERT2)
        const TIME_LIMIT = 10 * 60 * 1000; 
        let endTime = sessionStorage.getItem('booking_end_time');
        if (!endTime) {
            endTime = Date.now() + TIME_LIMIT;
            sessionStorage.setItem('booking_end_time', endTime);
        }

        function updateTimer() {
            const now = Date.now();
            const timeLeft = Math.max(0, endTime - now);
            
            const minutes = Math.floor((timeLeft / 1000) / 60);
            const seconds = Math.floor((timeLeft / 1000) % 60);
            
            document.getElementById('timer-display').innerText = String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');

            const widget = document.getElementById('countdown-widget');
            if (timeLeft <= 120000) {
                widget.style.backgroundColor = '#ff4444';
                widget.style.color = 'white';
            }

            // SI SE ACABA EL TIEMPO: BLOQUEO DE PANTALLA
            if (timeLeft <= 0) {
                clearInterval(timerInterval);
                sessionStorage.removeItem('booking_end_time'); 
                
                Swal.fire({
                    title: 'TIME EXPIRED',
                    text: 'Your reservation time has ended. The seats have been released.',
                    icon: 'error',
                    background: '#141414',
                    color: '#ffffff',
                    confirmButtonColor: 'var(--color-amarillo)',
                    confirmButtonText: '<span style="color: black; font-weight: bold;">START AGAIN</span>',
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "/";
                    }
                });
            }
        }
        const timerInterval = setInterval(updateTimer, 1000);
        updateTimer();
    </script>
</body>
</html>