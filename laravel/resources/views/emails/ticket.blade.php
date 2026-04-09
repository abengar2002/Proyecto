<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmed - Screenbites</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f4f4f4;
            -webkit-font-smoothing: antialiased;
        }

        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #000000;
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid #ffd000;
            box-shadow: 0 10px 25px rgba(255, 208, 0, 0.15);
        }

        .header {
            background-color: #111111;
            padding: 40px 30px;
            text-align: center;
            border-bottom: 3px dashed #ffd000;
            position: relative;
        }
        
        .header:before, .header:after {
            content: '';
            position: absolute;
            bottom: -15px;
            width: 30px; height: 30px;
            border-radius: 50%;
            background-color: #000000;
            border: 2px solid #ffd000;
            z-index: 5;
        }
        .header:before { left: -15px; }
        .header:after { right: -15px; }

        .header h1 {
            margin: 0;
            color: #ffd000;
            font-family: 'Arial Black', Gadget, sans-serif;
            letter-spacing: 4px;
            text-transform: uppercase;
            font-size: 26px;
        }

        .content {
            padding: 50px 40px;
            text-align: center;
            color: #ffffff;
        }
        
        .content h2 {
            margin-top: 0;
            margin-bottom: 25px;
            color: #ffffff;
            font-size: 22px;
            font-weight: bold;
        }
        
        .content p {
            font-size: 13px;
            line-height: 1.8;
            color: #cccccc;
            margin-bottom: 20px;
        }

        .details-box {
            background-color: #1a1a1a;
            border: 1px solid #ffd000;
            padding: 30px;
            margin: 30px 0 40px;
            border-radius: 6px;
            text-align: left;
        }

        .movie-title {
            font-size: 24px;
            font-weight: bold;
            color: #ffd000;
            text-transform: uppercase;
            margin-bottom: 25px;
            text-align: center;
            letter-spacing: 1px;
        }

        .info-row {
            margin-bottom: 20px;
            border-bottom: 1px solid #333;
            padding-bottom: 15px;
        }

        .info-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .label {
            font-size: 11px;
            color: #888888;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
            display: block;
        }

        .value {
            font-size: 18px;
            color: #ffffff;
            font-weight: bold;
        }

        .items-list {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .items-list li {
            font-size: 14px;
            color: #cccccc;
            margin-bottom: 6px;
            padding-left: 15px;
            position: relative;
        }

        .items-list li:before {
            content: '-';
            color: #ffd000;
            position: absolute;
            left: 0;
        }

        .total-price {
            font-size: 32px;
            color: #ffd000;
            font-family: 'Arial Black', sans-serif;
            text-align: right;
            display: block;
            margin-top: 10px;
        }

        .btn-container {
            margin: 30px 0 10px;
            text-align: center;
        }

        .btn-ticket {
            background-color: #ffd000;
            color: #000000 !important;
            padding: 16px 30px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            font-family: 'Arial Black', sans-serif;
            text-transform: uppercase;
            font-size: 14px;
            display: inline-block;
        }

        .logo-section {
            padding: 40px 30px;
            text-align: center;
            background-color: #111111;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        .logo-section img {
            height: 60px;
            width: auto;
            display: inline-block;
        }

        .footer {
            background-color: #111111;
            padding: 25px 30px;
            text-align: center;
            font-size: 11px;
            color: #666666;
            border-top: 2px solid #ffd000;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Booking Confirmed</h1>
        </div>

        <div class="content">
            <h2>Thank you for your purchase!</h2>
            <p>Your reservation has been processed successfully. Here are the details of your order. Please present this at the cinema entrance:</p>

            <div class="details-box">
                <div class="movie-title">{{ $orderData['movie_title'] }}</div>

                <div class="info-row">
                    <span class="label">Selected Seats</span>
                    <span class="value">{{ $orderData['seats'] }}</span>
                </div>

                <div class="info-row">
                    <span class="label">Food & Drinks</span>
                    <ul class="items-list">
                        @php
                            $items = is_string($orderData['items']) ? json_decode($orderData['items'], true) : $orderData['items'];
                        @endphp

                        @if(!empty($items) && count($items) > 0)
                            @foreach($items as $item)
                                @if(!isset($item['isFixed']) || !$item['isFixed'])
                                    <li>{{ $item['qty'] }}x {{ $item['name'] }}</li>
                                @endif
                            @endforeach
                        @else
                            <li style="color: #666; font-style: italic;">No food or drinks added</li>
                        @endif
                    </ul>
                </div>

                <div class="info-row">
                    <span class="label">Total Paid</span>
                    <span class="total-price">${{ number_format($orderData['total'], 2) }}</span>
                </div>
            </div>

            <div class="btn-container">
                <a href="{{ url('/ticket/' . ($orderData['id'] ?? '')) }}" class="btn-ticket">View Digital Ticket</a>
            </div>
        </div>

        <div class="logo-section">
            <img src="{{ $message->embed(public_path('img/img/Logo-Blanco.png')) }}" alt="Screenbites Cinema">
        </div>

        <div class="footer">
            &copy; 2026 Screenbites Cinema. All rights reserved.<br>
            Experience cinema like never before.
        </div>
    </div>
</body>
</html>