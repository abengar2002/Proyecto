<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Screenbites - Food & Drinks</title>
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

            /* FONDO INMERSIVO */
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

            /* HEADER */
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

                .logo img { height: 40px; }

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

                    &:hover { color: var(--color-amarillo); }
                }
            }

            /* CONTENEDOR PRINCIPAL */
            .food-container { 
                display: flex; 
                flex: 1; 
                padding: 40px 5%; 
                gap: 50px; 
                max-width: 1400px; 
                margin: 0 auto; 
                width: 100%; 

                /* ZONA IZQUIERDA: MENÚ DE COMIDA */
                .menu-section { 
                    flex: 3; 

                    .menu-header {
                        margin-bottom: 40px;
                        
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

                    .food-category {
                        margin-bottom: 60px;

                        h2 { 
                            font-size: 24px; 
                            text-transform: uppercase; 
                            border-bottom: 2px solid #333; 
                            padding-bottom: 10px; 
                            margin-bottom: 25px; 
                            color: var(--color-blanco); 
                        }

                        .food-grid {
                            display: grid;
                            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
                            gap: 20px;

                            .food-card {
                                background: rgba(20,20,20,0.8);
                                border: 1px solid #333;
                                border-radius: 12px;
                                overflow: hidden;
                                transition: transform 0.3s ease, border-color 0.3s;
                                display: flex;
                                flex-direction: column;

                                &:hover { 
                                    border-color: var(--color-amarillo); 
                                    transform: translateY(-5px); 
                                }
                                
                                &.exclusive { 
                                    border-color: var(--color-amarillo); 
                                    box-shadow: 0 0 15px rgba(255, 208, 0, 0.2); 
                                }

                                .food-img {
                                    height: 160px; 
                                    width: 100%; 
                                    object-fit: cover;
                                    border-bottom: 1px solid #333;
                                    background-color: #1a1a1a; 
                                }

                                .food-info {
                                    padding: 20px;
                                    flex: 1;
                                    display: flex;
                                    flex-direction: column;
                                    justify-content: space-between;

                                    .food-tag { 
                                        font-size: 10px; 
                                        background: var(--color-amarillo); 
                                        color: var(--color-texto-btn); 
                                        padding: 3px 6px; 
                                        border-radius: 4px; 
                                        font-weight: bold; 
                                        text-transform: uppercase; 
                                        align-self: flex-start; 
                                        margin-bottom: 10px;
                                    }

                                    h3 { 
                                        font-size: 15px; 
                                        margin-bottom: 8px; 
                                        text-transform: uppercase; 
                                        color: var(--color-blanco);
                                    }

                                    .food-price { 
                                        font-size: 18px; 
                                        color: var(--color-amarillo); 
                                        font-weight: bold; 
                                        font-family: 'Arial Black', sans-serif; 
                                        margin-bottom: 15px; 
                                    }

                                    /* Botones de Cantidad */
                                    .qty-controls {
                                        display: flex; 
                                        align-items: center; 
                                        justify-content: space-between; 
                                        background: var(--color-negro); 
                                        border: 1px solid #444; 
                                        border-radius: 6px; 
                                        overflow: hidden;
                                        
                                        button { 
                                            background: transparent; 
                                            color: var(--color-blanco); 
                                            border: none; 
                                            padding: 10px 15px; 
                                            cursor: pointer; 
                                            font-size: 16px; 
                                            font-weight: bold; 
                                            transition: background 0.2s; 
                                            
                                            &:hover { background: #333; }
                                        }

                                        .qty-val { 
                                            font-size: 15px; 
                                            font-weight: bold; 
                                        }
                                    }
                                }
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
                        text-transform: uppercase; 
                        border-bottom: 2px solid var(--color-amarillo); 
                        padding-bottom: 15px; 
                        margin-bottom: 25px; 
                        color: var(--color-blanco);
                    }
                    
                    .cart-items {
                        margin-bottom: 25px;
                        min-height: 100px;
                        max-height: 300px;
                        overflow-y: auto;
                        padding-right: 10px;

                        &::-webkit-scrollbar { width: 6px; }
                        &::-webkit-scrollbar-track { background: transparent; }
                        &::-webkit-scrollbar-thumb { background: #444; border-radius: 4px; }

                        .cart-item {
                            display: flex; 
                            justify-content: space-between; 
                            margin-bottom: 15px; 
                            font-size: 13px; 
                            color: #ccc;

                            .item-name { 
                                flex: 1; 
                                padding-right: 10px; 
                                line-height: 1.4;
                            }

                            .item-price { 
                                font-weight: bold; 
                                color: var(--color-blanco); 
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

                        &:hover { 
                            background-color: var(--color-blanco); 
                            color: var(--color-negro); 
                            transform: translateY(-3px); 
                            box-shadow: 0 10px 20px rgba(0,0,0,0.3); 
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
                <p>Enhance your movie experience. Pre-order now and skip the queue.</p>
            </div>

            @if(in_array((string)$id, ['01', '1', '04', '4', '09', '9']))
                @php
                    $comboName = ''; $comboPrice = 14.99;
                    if ((string)$id === '01' || (string)$id === '1') { 
                        $comboName = 'The Vengeance Combo'; 
                    } elseif ((string)$id === '04' || (string)$id === '4') { 
                        $comboName = 'Atomic Combo'; 
                    } elseif ((string)$id === '09' || (string)$id === '9') { 
                        $comboName = 'Dreamhouse Snack'; 
                    }
                @endphp
                <div class="food-category">
                    <h2>Exclusive for {{ $movie['title'] }}</h2>
                    <div class="food-grid">
                        <div class="food-card exclusive" data-name="{{ $comboName }}" data-price="{{ $comboPrice }}">
                            <img src="" alt="" class="food-img"> <div class="food-info">
                                <span class="food-tag">Limited Edition</span>
                                <h3>{{ $comboName }}</h3>
                                <div class="food-price">${{ $comboPrice }}</div>
                                <div class="qty-controls">
                                    <button onclick="updateQty(this, -1)">-</button>
                                    <span class="qty-val">0</span>
                                    <button onclick="updateQty(this, 1)">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="food-category">
                <h2>Popcorn & Food</h2>
                <div class="food-grid">
                    <div class="food-card" data-name="Classic Salted Popcorn (M)" data-price="5.50">
                        <img src="" alt="" class="food-img">
                        <div class="food-info">
                            <h3>Classic Salted Popcorn (M)</h3>
                            <div class="food-price">$5.50</div>
                            <div class="qty-controls"><button onclick="updateQty(this, -1)">-</button><span class="qty-val">0</span><button onclick="updateQty(this, 1)">+</button></div>
                        </div>
                    </div>
                    <div class="food-card" data-name="Classic Salted Popcorn (L)" data-price="7.00">
                        <img src="" alt="" class="food-img">
                        <div class="food-info">
                            <h3>Classic Salted Popcorn (L)</h3>
                            <div class="food-price">$7.00</div>
                            <div class="qty-controls"><button onclick="updateQty(this, -1)">-</button><span class="qty-val">0</span><button onclick="updateQty(this, 1)">+</button></div>
                        </div>
                    </div>
                    <div class="food-card" data-name="Extra Butter Popcorn (L)" data-price="8.00">
                        <img src="" alt="" class="food-img">
                        <div class="food-info">
                            <h3>Extra Butter Popcorn (L)</h3>
                            <div class="food-price">$8.00</div>
                            <div class="qty-controls"><button onclick="updateQty(this, -1)">-</button><span class="qty-val">0</span><button onclick="updateQty(this, 1)">+</button></div>
                        </div>
                    </div>
                    <div class="food-card" data-name="Sweet Caramel Popcorn (M)" data-price="6.50">
                        <img src="" alt="" class="food-img">
                        <div class="food-info">
                            <h3>Sweet Caramel Popcorn (M)</h3>
                            <div class="food-price">$6.50</div>
                            <div class="qty-controls"><button onclick="updateQty(this, -1)">-</button><span class="qty-val">0</span><button onclick="updateQty(this, 1)">+</button></div>
                        </div>
                    </div>
                    <div class="food-card" data-name="Family Mega Bucket" data-price="9.50">
                        <img src="" alt="" class="food-img">
                        <div class="food-info">
                            <h3>Family Mega Bucket</h3>
                            <div class="food-price">$9.50</div>
                            <div class="qty-controls"><button onclick="updateQty(this, -1)">-</button><span class="qty-val">0</span><button onclick="updateQty(this, 1)">+</button></div>
                        </div>
                    </div>
                    <div class="food-card" data-name="Classic Hot Dog" data-price="5.00">
                        <img src="" alt="" class="food-img">
                        <div class="food-info">
                            <h3>Classic Hot Dog</h3>
                            <div class="food-price">$5.00</div>
                            <div class="qty-controls"><button onclick="updateQty(this, -1)">-</button><span class="qty-val">0</span><button onclick="updateQty(this, 1)">+</button></div>
                        </div>
                    </div>
                    <div class="food-card" data-name="XXL Cheese Hot Dog" data-price="6.50">
                        <img src="" alt="" class="food-img">
                        <div class="food-info">
                            <h3>XXL Cheese Hot Dog</h3>
                            <div class="food-price">$6.50</div>
                            <div class="qty-controls"><button onclick="updateQty(this, -1)">-</button><span class="qty-val">0</span><button onclick="updateQty(this, 1)">+</button></div>
                        </div>
                    </div>
                    <div class="food-card" data-name="Extra Cheese Nachos" data-price="6.50">
                        <img src="" alt="" class="food-img">
                        <div class="food-info">
                            <h3>Extra Cheese Nachos</h3>
                            <div class="food-price">$6.50</div>
                            <div class="qty-controls"><button onclick="updateQty(this, -1)">-</button><span class="qty-val">0</span><button onclick="updateQty(this, 1)">+</button></div>
                        </div>
                    </div>
                    <div class="food-card" data-name="Pepperoni Pizza Slice" data-price="4.00">
                        <img src="" alt="" class="food-img">
                        <div class="food-info">
                            <h3>Pepperoni Pizza Slice</h3>
                            <div class="food-price">$4.00</div>
                            <div class="qty-controls"><button onclick="updateQty(this, -1)">-</button><span class="qty-val">0</span><button onclick="updateQty(this, 1)">+</button></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="food-category">
                <h2>Fresh Drinks</h2>
                <div class="food-grid">
                    <div class="food-card" data-name="Coca-Cola / Zero (M)" data-price="4.00">
                        <img src="" alt="" class="food-img">
                        <div class="food-info">
                            <h3>Coca-Cola / Zero (M)</h3>
                            <div class="food-price">$4.00</div>
                            <div class="qty-controls"><button onclick="updateQty(this, -1)">-</button><span class="qty-val">0</span><button onclick="updateQty(this, 1)">+</button></div>
                        </div>
                    </div>
                    <div class="food-card" data-name="Coca-Cola / Zero (L)" data-price="5.50">
                        <img src="" alt="" class="food-img">
                        <div class="food-info">
                            <h3>Coca-Cola / Zero (L)</h3>
                            <div class="food-price">$5.50</div>
                            <div class="qty-controls"><button onclick="updateQty(this, -1)">-</button><span class="qty-val">0</span><button onclick="updateQty(this, 1)">+</button></div>
                        </div>
                    </div>
                    <div class="food-card" data-name="Fanta Orange (M)" data-price="4.00">
                        <img src="" alt="" class="food-img">
                        <div class="food-info">
                            <h3>Fanta Orange (M)</h3>
                            <div class="food-price">$4.00</div>
                            <div class="qty-controls"><button onclick="updateQty(this, -1)">-</button><span class="qty-val">0</span><button onclick="updateQty(this, 1)">+</button></div>
                        </div>
                    </div>
                    <div class="food-card" data-name="Sprite (L)" data-price="5.50">
                        <img src="" alt="" class="food-img">
                        <div class="food-info">
                            <h3>Sprite (L)</h3>
                            <div class="food-price">$5.50</div>
                            <div class="qty-controls"><button onclick="updateQty(this, -1)">-</button><span class="qty-val">0</span><button onclick="updateQty(this, 1)">+</button></div>
                        </div>
                    </div>
                    <div class="food-card" data-name="Blue Icee Slush" data-price="5.00">
                        <img src="" alt="" class="food-img">
                        <div class="food-info">
                            <h3>Blue Icee Slush</h3>
                            <div class="food-price">$5.00</div>
                            <div class="qty-controls"><button onclick="updateQty(this, -1)">-</button><span class="qty-val">0</span><button onclick="updateQty(this, 1)">+</button></div>
                        </div>
                    </div>
                    <div class="food-card" data-name="Cherry Icee Slush" data-price="5.00">
                        <img src="" alt="" class="food-img">
                        <div class="food-info">
                            <h3>Cherry Icee Slush</h3>
                            <div class="food-price">$5.00</div>
                            <div class="qty-controls"><button onclick="updateQty(this, -1)">-</button><span class="qty-val">0</span><button onclick="updateQty(this, 1)">+</button></div>
                        </div>
                    </div>
                    <div class="food-card" data-name="Bottled Mineral Water" data-price="3.00">
                        <img src="" alt="" class="food-img">
                        <div class="food-info">
                            <h3>Bottled Mineral Water</h3>
                            <div class="food-price">$3.00</div>
                            <div class="qty-controls"><button onclick="updateQty(this, -1)">-</button><span class="qty-val">0</span><button onclick="updateQty(this, 1)">+</button></div>
                        </div>
                    </div>
                    <div class="food-card" data-name="Craft Beer (IPA)" data-price="6.50">
                        <img src="" alt="" class="food-img">
                        <div class="food-info">
                            <h3>Craft Beer (IPA)</h3>
                            <div class="food-price">$6.50</div>
                            <div class="qty-controls"><button onclick="updateQty(this, -1)">-</button><span class="qty-val">0</span><button onclick="updateQty(this, 1)">+</button></div>
                        </div>
                    </div>
                    <div class="food-card" data-name="Hot Coffee / Tea" data-price="3.50">
                        <img src="" alt="" class="food-img">
                        <div class="food-info">
                            <h3>Hot Coffee / Tea</h3>
                            <div class="food-price">$3.50</div>
                            <div class="qty-controls"><button onclick="updateQty(this, -1)">-</button><span class="qty-val">0</span><button onclick="updateQty(this, 1)">+</button></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="food-category">
                <h2>Snacks & Sweets</h2>
                <div class="food-grid">
                    <div class="food-card" data-name="Pretzel Bites" data-price="4.50">
                        <img src="" alt="" class="food-img">
                        <div class="food-info">
                            <h3>Pretzel Bites</h3>
                            <div class="food-price">$4.50</div>
                            <div class="qty-controls"><button onclick="updateQty(this, -1)">-</button><span class="qty-val">0</span><button onclick="updateQty(this, 1)">+</button></div>
                        </div>
                    </div>
                    <div class="food-card" data-name="Chocolate M&M's Bag" data-price="3.50">
                        <img src="" alt="" class="food-img">
                        <div class="food-info">
                            <h3>Chocolate M&M's Bag</h3>
                            <div class="food-price">$3.50</div>
                            <div class="qty-controls"><button onclick="updateQty(this, -1)">-</button><span class="qty-val">0</span><button onclick="updateQty(this, 1)">+</button></div>
                        </div>
                    </div>
                    <div class="food-card" data-name="Skittles Bag" data-price="3.50">
                        <img src="" alt="" class="food-img">
                        <div class="food-info">
                            <h3>Skittles Bag</h3>
                            <div class="food-price">$3.50</div>
                            <div class="qty-controls"><button onclick="updateQty(this, -1)">-</button><span class="qty-val">0</span><button onclick="updateQty(this, 1)">+</button></div>
                        </div>
                    </div>
                    <div class="food-card" data-name="Gummy Bears" data-price="3.00">
                        <img src="" alt="" class="food-img">
                        <div class="food-info">
                            <h3>Gummy Bears</h3>
                            <div class="food-price">$3.00</div>
                            <div class="qty-controls"><button onclick="updateQty(this, -1)">-</button><span class="qty-val">0</span><button onclick="updateQty(this, 1)">+</button></div>
                        </div>
                    </div>
                    <div class="food-card" data-name="Crispy Maltesers" data-price="3.50">
                        <img src="" alt="" class="food-img">
                        <div class="food-info">
                            <h3>Crispy Maltesers</h3>
                            <div class="food-price">$3.50</div>
                            <div class="qty-controls"><button onclick="updateQty(this, -1)">-</button><span class="qty-val">0</span><button onclick="updateQty(this, 1)">+</button></div>
                        </div>
                    </div>
                    <div class="food-card" data-name="Lacasitos" data-price="3.00">
                        <img src="" alt="" class="food-img">
                        <div class="food-info">
                            <h3>Lacasitos</h3>
                            <div class="food-price">$3.00</div>
                            <div class="qty-controls"><button onclick="updateQty(this, -1)">-</button><span class="qty-val">0</span><button onclick="updateQty(this, 1)">+</button></div>
                        </div>
                    </div>
                    <div class="food-card" data-name="Red Licorice" data-price="2.50">
                        <img src="" alt="" class="food-img">
                        <div class="food-info">
                            <h3>Red Licorice</h3>
                            <div class="food-price">$2.50</div>
                            <div class="qty-controls"><button onclick="updateQty(this, -1)">-</button><span class="qty-val">0</span><button onclick="updateQty(this, 1)">+</button></div>
                        </div>
                    </div>
                    <div class="food-card" data-name="Snickers Bar" data-price="2.50">
                        <img src="" alt="" class="food-img">
                        <div class="food-info">
                            <h3>Snickers Bar</h3>
                            <div class="food-price">$2.50</div>
                            <div class="qty-controls"><button onclick="updateQty(this, -1)">-</button><span class="qty-val">0</span><button onclick="updateQty(this, 1)">+</button></div>
                        </div>
                    </div>
                    <div class="food-card" data-name="Classic Magnum Ice Cream" data-price="4.00">
                        <img src="" alt="" class="food-img">
                        <div class="food-info">
                            <h3>Classic Magnum Ice Cream</h3>
                            <div class="food-price">$4.00</div>
                            <div class="qty-controls"><button onclick="updateQty(this, -1)">-</button><span class="qty-val">0</span><button onclick="updateQty(this, 1)">+</button></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="summary-section">
            <h2 class="summary-title">Order Summary</h2>
            
            <div class="cart-items" id="cart-items-container">
                </div>

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
        
        let cart = {};
        
        if (seatsParam && ticketsTotalParam > 0) {
            cart['Tickets'] = {
                name: `Tickets (${seatsParam})`,
                price: ticketsTotalParam,
                qty: 1,
                isFixed: true
            };
        }

        const cartContainer = document.getElementById('cart-items-container');
        const grandTotalDisplay = document.getElementById('grand-total');

        function updateQty(btn, change) {
            const card = btn.closest('.food-card');
            const name = card.dataset.name;
            const price = parseFloat(card.dataset.price);
            const qtySpan = card.querySelector('.qty-val');
            
            let currentQty = parseInt(qtySpan.innerText);
            let newQty = currentQty + change;
            
            if (newQty < 0) newQty = 0; 
            
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
    </script>
</body>
</html>