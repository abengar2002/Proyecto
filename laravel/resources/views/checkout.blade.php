<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Screenbites - Checkout</title>
    <style>
        :root {
            --color-negro: #000000;
            --color-gris-oscuro: #0a0a0a;
            --color-gris-tarjeta: #141414;
            --color-blanco: #ffffff;
            --color-amarillo: {{ $movie['bg'] ?? '#ffd000' }}; 
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

            .page-bg { 
                position: fixed; 
                top: 0; 
                left: 0; 
                width: 100%; 
                height: 100%; 
                z-index: -2; 
                object-fit: cover; 
                opacity: 0.1; 
                filter: blur(10px); 
            }

            .page-bg-gradient { 
                position: fixed; 
                top: 0; 
                left: 0; 
                width: 100%; 
                height: 100%; 
                z-index: -1; 
                background: radial-gradient(circle at center, transparent 0%, var(--color-negro) 80%); 
            }

            header { 
                padding: 20px 5%; 
                display: flex; 
                justify-content: space-between; 
                align-items: center; 
                border-bottom: 1px solid rgba(255,255,255,0.05); 
                background-color: rgba(0,0,0,0.8);
                backdrop-filter: blur(10px);

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
                    transition: color 0.3s; 

                    &:hover { color: var(--color-amarillo); }
                }
            }

            .checkout-container { 
                display: flex; 
                flex: 1; 
                padding: 50px 5%; 
                gap: 60px; 
                max-width: 1200px; 
                margin: 0 auto; 
                width: 100%; 
                align-items: flex-start;

                /* --- ZONA IZQUIERDA: FORMULARIO DE PAGO --- */
                .payment-section { 
                    flex: 2; 
                    background-color: rgba(20,20,20,0.8); 
                    backdrop-filter: blur(10px);
                    border: 1px solid rgba(255,255,255,0.1);
                    border-radius: 12px;
                    padding: 40px;

                    h1 { 
                        font-family: 'Arial Black', sans-serif; 
                        font-size: 28px; 
                        text-transform: uppercase; 
                        margin-bottom: 30px; 
                        border-bottom: 2px solid var(--color-amarillo); 
                        padding-bottom: 15px;
                    }

                    .payment-methods { 
                        display: flex; 
                        gap: 15px; 
                        margin-bottom: 30px; 

                        .method-card { 
                            flex: 1; 
                            border: 1px solid #333; 
                            border-radius: 8px; 
                            padding: 15px; 
                            text-align: center; 
                            cursor: pointer; 
                            transition: all 0.3s; 
                            opacity: 0.6; 

                            &.active { 
                                border-color: var(--color-amarillo); 
                                opacity: 1; 
                                background: rgba(255,208,0,0.05); 
                            }

                            svg { 
                                width: 30px; 
                                height: 30px; 
                                margin-bottom: 5px; 
                                color: var(--color-blanco); 
                            }

                            div {
                                font-size: 12px; 
                                font-weight: bold; 
                                margin-top: 5px;
                            }
                        }
                    }

                    .form-group { 
                        margin-bottom: 25px; 

                        label { 
                            display: block; 
                            font-size: 12px; 
                            color: #888; 
                            text-transform: uppercase; 
                            font-weight: bold; 
                            margin-bottom: 8px; 
                            letter-spacing: 1px; 
                        }

                        input { 
                            width: 100%; 
                            background: #0a0a0a; 
                            border: 1px solid #333; 
                            color: white; 
                            padding: 15px; 
                            border-radius: 6px; 
                            font-size: 16px; 
                            font-family: monospace; 
                            transition: all 0.3s;

                            &:focus { 
                                outline: none; 
                                border-color: var(--color-amarillo); 
                                box-shadow: 0 0 10px rgba(255,208,0,0.2); 
                            }
                        }
                    }

                    .form-row { 
                        display: flex; 
                        gap: 20px; 

                        .form-group { flex: 1; }
                    }
                }

                /* --- ZONA DERECHA: RESUMEN FINAL --- */
                .summary-section { 
                    flex: 1; 
                    min-width: 350px; 
                    background-color: var(--color-amarillo); 
                    color: var(--color-negro);
                    border-radius: 12px; 
                    padding: 40px; 
                    box-shadow: 0 20px 50px rgba(0,0,0,0.5);

                    h2 { 
                        font-family: 'Arial Black', sans-serif; 
                        font-size: 24px; 
                        text-transform: uppercase; 
                        margin-bottom: 5px; 
                    }

                    .summary-movie { 
                        font-size: 14px; 
                        font-weight: bold; 
                        margin-bottom: 25px; 
                        opacity: 0.8; 
                    }

                    .final-cart { 
                        margin-bottom: 30px; 
                        border-top: 1px solid rgba(0,0,0,0.1); 
                        border-bottom: 1px solid rgba(0,0,0,0.1); 
                        padding: 20px 0; 
                        
                        .final-item { 
                            display: flex; 
                            justify-content: space-between; 
                            margin-bottom: 10px; 
                            font-size: 14px; 
                            font-weight: bold; 

                            span:first-child { opacity: 0.8; }
                        }
                    }

                    .total-box { 
                        display: flex; 
                        justify-content: space-between; 
                        align-items: center; 

                        span { 
                            font-size: 16px; 
                            font-weight: bold; 
                            text-transform: uppercase; 
                        }

                        strong { 
                            font-family: 'Arial Black', sans-serif; 
                            font-size: 36px; 
                        }
                    }

                    .btn-pay { 
                        width: 100%; 
                        background-color: var(--color-negro); 
                        color: var(--color-amarillo); 
                        border: none; 
                        padding: 20px; 
                        border-radius: 6px; 
                        font-family: 'Arial Black', sans-serif; 
                        font-size: 16px; 
                        text-transform: uppercase; 
                        cursor: pointer; 
                        transition: all 0.3s ease; 
                        margin-top: 30px; 
                        display: flex; 
                        justify-content: center; 
                        align-items: center; 
                        gap: 10px; 

                        &:hover { 
                            background-color: #222; 
                            transform: translateY(-3px); 
                            box-shadow: 0 10px 20px rgba(0,0,0,0.3); 
                        }

                        &:disabled { 
                            opacity: 0.7; 
                            cursor: wait; 
                            transform: none; 
                        }

                        /* Loader */
                        .loader { 
                            border: 3px solid rgba(255,208,0,0.3); 
                            border-top: 3px solid var(--color-amarillo); 
                            border-radius: 50%; 
                            width: 20px; 
                            height: 20px; 
                            animation: spin 1s linear infinite; 
                            display: none; 
                        }
                    }

                    .terms-text {
                        text-align: center; 
                        font-size: 11px; 
                        margin-top: 15px; 
                        opacity: 0.7;
                    }
                }
            }
        }

        @keyframes spin { 
            0% { transform: rotate(0deg); } 
            100% { transform: rotate(360deg); } 
        }

    </style>
</head>
<body>

    <img src="{{ asset($movie['bgImg'] ?? '') }}" class="page-bg" onerror="this.src=''">
    <div class="page-bg-gradient"></div>

    <header>
        <a href="/booking/{{ $id }}/food" class="back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Back to Menu
        </a>
        <div class="logo"><a href="/"><img src="{{ asset('img/img/Logo-Blanco.png') }}" alt="Screenbites Logo"></a></div>
        <div style="width: 130px;"></div>
    </header>

    <div class="checkout-container">
        
        <div class="payment-section">
            <h1>Payment Details</h1>

            <div class="payment-methods">
                <div class="method-card active">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                    <div>Credit Card</div>
                </div>
                <div class="method-card">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"></rect><line x1="2" y1="10" x2="22" y2="10"></line></svg>
                    <div>PayPal</div>
                </div>
                <div class="method-card">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20"></path><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                    <div>Apple Pay</div>
                </div>
            </div>

            <form id="payment-form" onsubmit="processPayment(event)">
                <div class="form-group">
                    <label>Cardholder Name</label>
                    <input type="text" placeholder="e.g. JOHN DOE" required>
                </div>
                
                <div class="form-group">
                    <label>Card Number</label>
                    <input type="text" placeholder="0000 0000 0000 0000" maxlength="19" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Expiry Date</label>
                        <input type="text" placeholder="MM/YY" maxlength="5" required>
                    </div>
                    <div class="form-group">
                        <label>CVC</label>
                        <input type="password" placeholder="123" maxlength="3" required>
                    </div>
                </div>
            </form>
        </div>

        <div class="summary-section">
            <h2>Your Order</h2>
            <div class="summary-movie">{{ $movie['title'] ?? 'Movie' }} • Today, 20:30</div>

            <div class="final-cart" id="final-cart-list">
                </div>

            <div class="total-box">
                <span>Total to Pay</span>
                <strong id="final-total">$0.00</strong>
            </div>

            <button type="submit" form="payment-form" class="btn-pay" id="btn-pay">
                <span id="btn-text">Confirm Payment</span>
                <div class="loader" id="pay-loader"></div>
            </button>
            <p class="terms-text">By confirming, you agree to our Terms & Conditions.</p>
        </div>

    </div>

    <script>
        // LEER LOS DATOS DEL CARRITO DESDE LA SESIÓN
        const cartData = sessionStorage.getItem('screenbites_cart');
        const cartContainer = document.getElementById('final-cart-list');
        const totalDisplay = document.getElementById('final-total');
        let grandTotal = 0;

        if (cartData) {
            const cart = JSON.parse(cartData);
            const items = Object.values(cart);

            items.forEach(item => {
                const itemTotal = item.isFixed ? item.price : item.price * item.qty;
                grandTotal += itemTotal;

                const qtyText = item.isFixed ? '' : `${item.qty}x `;
                
                cartContainer.innerHTML += `
                    <div class="final-item">
                        <span>${qtyText}${item.name}</span>
                        <span>$${itemTotal.toFixed(2)}</span>
                    </div>
                `;
            });

            totalDisplay.innerText = `$${grandTotal.toFixed(2)}`;
        } else {
            cartContainer.innerHTML = '<div style="text-align:center; font-style:italic;">No items found.</div>';
            document.getElementById('btn-pay').disabled = true;
        }

        // SIMULAR EL PROCESO DE PAGO
        function processPayment(e) {
            e.preventDefault(); 
            
            const btn = document.getElementById('btn-pay');
            const btnText = document.getElementById('btn-text');
            const loader = document.getElementById('pay-loader');

            // Estado de carga
            btn.disabled = true;
            btnText.innerText = 'Processing...';
            loader.style.display = 'block';

            setTimeout(() => {
                // Éxito: Vaciar carrito
                sessionStorage.removeItem('screenbites_cart');
                
                window.location.href = "/profile"; 
            }, 2000);
        }
    </script>
</body>
</html>