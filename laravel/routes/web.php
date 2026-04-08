<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\PasswordController;
use Illuminate\Support\Facades\Http; 
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

// 1. PORTADA
Route::get('/', function () {
    $wordpressUrl = env('WP_URL', 'http://127.0.0.1/proyecto/wp');
    $nowPlaying = [];
    $comingSoon = [];

    try {
        $response = Http::withoutVerifying()->timeout(15)->get("{$wordpressUrl}/wp-json/wp/v2/pelicula?acf_format=standard&per_page=100");

        if ($response->successful()) {
            foreach ($response->json() as $wpMovie) {
                $acf = $wpMovie['acf'] ?? [];
                $isComingSoon = filter_var($acf['iscomingsoon'] ?? false, FILTER_VALIDATE_BOOLEAN);

                // Formateamos el ID para que siempre tenga 2 dígitos (ej: "01", "02")
                $laravelId = str_pad($acf['id_laravel'] ?? 0, 2, '0', STR_PAD_LEFT);

                $movieData = [
                    'id' => $laravelId,
                    'title' => $wpMovie['title']['rendered'],
                    'age' => $acf['edad'] ?? 'TP',
                    'rating' => (int)($acf['puntuacion'] ?? 4),
                    'genre' => $acf['genero'] ?? 'Unknown',
                    'bg' => $acf['bg'] ?? '#000000',
                    'textColor' => $acf['textcolor'] ?? 'white',
                    'bgImg' => $acf['bgimg'] ?? '',
                    'poster' => $acf['poster'] ?? '',
                    'date' => $acf['releasedate'] ?? 'SOON'
                ];

                if ($isComingSoon) {
                    $comingSoon[] = $movieData;
                } else {
                    $nowPlaying[] = $movieData;
                }
            }
        }
    } catch (\Exception $e) {}

    // Salvavidas: por si WordPress está apagado
    if (empty($nowPlaying)) {
        $nowPlaying[] = [
            'id' => "00", 'title' => "No Movies Found", 'age' => "TP", 'rating' => 0, 'genre' => "Error",
            'bg' => "#000000", 'textColor' => "white", 'bgImg' => "", 'poster' => "", 'date' => ""
        ];
    } else {
        $nowPlaying = collect($nowPlaying)->sortBy('id')->values()->toArray();
        $comingSoon = collect($comingSoon)->sortBy('id')->values()->toArray();
    }

    return view('index', [
        'movies' => $nowPlaying,
        'comingSoonMovies' => $comingSoon
    ]);
})->name('home');

// 2. DETALLES DE PELÍCULA
Route::get('/pelicula/{id}', function ($id) {
    $wordpressUrl = env('WP_URL', 'http://127.0.0.1/proyecto/wp'); 

    $movie = [
        "title" => "Unknown Title", "age" => "?", "genre" => "Unknown", 
        "bgImg" => "", "poster" => "", "desc" => "No information available.", 
        "bg" => "#222222", "textColor" => "white",
        "mediaCarousel" => [],
        "menuSpecial" => ["enabled" => false, "title" => "", "text" => "", "image" => ""]
    ];

    try {
        $response = Http::withoutVerifying()->timeout(30)->get("{$wordpressUrl}/wp-json/wp/v2/pelicula?acf_format=standard&per_page=100");

        if ($response->successful()) {
            foreach ($response->json() as $wpMovie) {
                $acf = $wpMovie['acf'] ?? [];
                
                if (isset($acf['id_laravel']) && (int)$acf['id_laravel'] === (int)$id) {
                    $mediaItems = [];
                    $getYoutubeThumb = function($url) {
                        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $url, $match)) {
                            $ytId = $match[1];
                            return "https://img.youtube.com/vi/{$ytId}/maxresdefault.jpg";
                        }
                        return null;
                    };

                    if (!empty($acf['trailer_1'])) {
                        $thumb = $getYoutubeThumb($acf['trailer_1']);
                        if($thumb) $mediaItems[] = ['type' => 'video', 'url' => $acf['trailer_1'], 'thumbnail' => $thumb];
                    }

                    for ($i = 1; $i <= 4; $i++) {
                        $imgKey = "carousel_img_" . $i;
                        if (!empty($acf[$imgKey])) {
                            $mediaItems[] = ['type' => 'image', 'url' => $acf[$imgKey], 'thumbnail' => $acf[$imgKey]];
                        }
                    }

                    // BUSCAMOS SI HAY UN MENÚ EXCLUSIVO PARA ESTA PELÍCULA EN EL POST TYPE "COMIDA"
                    $menuSpecial = ["enabled" => false, "title" => "", "text" => "", "image" => ""];
                    try {
                        $foodResponse = Http::withoutVerifying()->timeout(10)->get("{$wordpressUrl}/wp-json/wp/v2/comida?acf_format=standard&per_page=100");
                        if ($foodResponse->successful()) {
                            foreach ($foodResponse->json() as $item) {
                                $acfFood = $item['acf'] ?? [];
                                $isExclusive = strtolower($acfFood['category'] ?? '') === 'exclusive';
                                $matchesMovie = (int)($acfFood['id_pelicula'] ?? 0) === (int)$id;
                                $isSpent = filter_var($acfFood['spent'] ?? false, FILTER_VALIDATE_BOOLEAN);
                                
                                // Si es exclusivo, coincide el ID, y NO está marcado como gastado manualmente
                                if ($isExclusive && $matchesMovie && !$isSpent) {
                                    $menuSpecial = [
                                        "enabled" => true,
                                        "title"   => $item['title']['rendered'],
                                        "text"    => $acfFood['description'] ?? "",
                                        "image"   => $acfFood['image'] ?? ""
                                    ];
                                    break; // Ya lo tenemos, no seguimos buscando
                                }
                            }
                        }
                    } catch (\Exception $e) {}

                    $movie = [
                        "title" => $wpMovie['title']['rendered'],
                        "desc" => strip_tags($wpMovie['content']['rendered']),
                        "age" => $acf['edad'] ?? "?",
                        "genre" => $acf['genero'] ?? "Unknown",
                        "bgImg" => $acf['bgimg'] ?? "",
                        "poster" => $acf['poster'] ?? "",
                        "bg" => $acf['bg'] ?? "#000000",
                        "textColor" => $acf['textcolor'] ?? "white",
                        "isComingSoon" => filter_var($acf['iscomingsoon'] ?? false, FILTER_VALIDATE_BOOLEAN),
                        "releaseDate" => $acf['releasedate'] ?? "",
                        "mediaCarousel" => array_slice($mediaItems, 0, 5),
                        "menuSpecial" => $menuSpecial // ASIGNAMOS EL MENÚ ENCONTRADO
                    ];
                    break;
                }
            }
        }
    } catch (\Exception $e) { }

    $reviews = [];
    try {
        $responseReviews = Http::withoutVerifying()->timeout(30)->get("{$wordpressUrl}/wp-json/wp/v2/reviews?per_page=100");
        if ($responseReviews->successful()) {
            foreach ($responseReviews->json() as $review) {
                $wp_id = $review['acf']['id_pelicula_laravel'] ?? $review['acf']['id_laravel'] ?? null;
                if ($wp_id !== null && (int)$wp_id === (int)$id) {
                    $reviews[] = [
                        'title' => $review['title']['rendered'],
                        'content' => strip_tags($review['content']['rendered']),
                        'score' => intval($review['acf']['puntuacion'] ?? 0),
                    ];
                }
            }
        }
    } catch (\Exception $e) { }

    return view('pelicula', ['id' => $id, 'movie' => $movie, 'reviews' => $reviews]);
})->name('pelicula.show');

// 3. GUARDAR RESEÑAS
Route::post('/pelicula/{id}/review', function (Request $request, $id) {
    $request->validate(['content' => 'required|string|min:5', 'score' => 'required|integer|min:1|max:5']);
    $wordpressUrl = env('WP_URL', 'http://127.0.0.1/proyecto/wp');
    $userName = Auth::user()->name;

    Http::withBasicAuth(env('WP_USER'), env('WP_PASSWORD'))->withoutVerifying()
        ->post("{$wordpressUrl}/wp-json/wp/v2/reviews", [
            'title'   => 'Review by ' . $userName,
            'content' => $request->input('content'),
            'status'  => 'publish',
            'acf'     => [
                'id_pelicula_laravel' => $id,
                'puntuacion' => $request->input('score'),
                'user_email' => Auth::user()->email
            ]
        ]);
    return back()->with('status', 'Review published!');
})->middleware('auth')->name('pelicula.review');

// 4. AUTENTICACIÓN
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/registro', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/registro', [AuthController::class, 'register']);
});

Route::get('/2fa', [AuthController::class, 'show2faForm'])->name('2fa.form');
Route::post('/2fa', [AuthController::class, 'verify2fa'])->name('2fa.verify');

// RUTAS PROTEGIDAS
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // --- RUTA PARA ELIMINAR RESERVA ---
    Route::delete('/reserva/{id}', function ($id) {
        $wordpressUrl = env('WP_URL');
        Http::withBasicAuth(env('WP_USER'), env('WP_PASSWORD'))->withoutVerifying()
            ->delete("{$wordpressUrl}/wp-json/wp/v2/reservas/{$id}?force=true");

        return redirect()->route('profile.edit', ['tab' => 'bookings'])->with('status', 'Booking cancelled successfully.');
    })->name('reserva.destroy');

    // --- RUTA PARA VER ENTRADA INDIVIDUAL ---
    Route::get('/ticket/{id}', function ($id) {
        $user = Auth::user();
        $wordpressUrl = env('WP_URL', 'http://127.0.0.1/proyecto/wp');

        try {
            $resResponse = Http::withoutVerifying()->get("{$wordpressUrl}/wp-json/wp/v2/reservas/{$id}?acf_format=standard");
            $reserva = $resResponse->json();
            $acf = $reserva['acf'] ?? [];

            if (($acf['user_email'] ?? '') !== $user->email) abort(403);

            $movieTitle = $acf['movie_title'];
            $moviesResponse = Http::withoutVerifying()->get("{$wordpressUrl}/wp-json/wp/v2/pelicula?acf_format=standard&per_page=100");
            $movieData = collect($moviesResponse->json())->firstWhere('title.rendered', $movieTitle);

            $ticket = [
                'id'     => $id,
                'movie'  => $movieTitle,
                'seats'  => $acf['seats'],
                'total'  => $acf['total_price'],
                'items'  => json_decode($acf['items_json'] ?? '[]', true),
                'date'   => $reserva['date'],
                'poster' => $movieData['acf']['poster'] ?? '',
                'bg'     => $movieData['acf']['bg'] ?? '#141414',
                'color'  => $movieData['acf']['textcolor'] ?? 'white'
            ];

            return view('ticket-view', compact('ticket'));
        } catch (\Exception $e) { abort(404); }
    })->name('ticket.show');
    
    // --- PERFIL ---
    Route::get('/profile', function () {
        $user = Auth::user();
        $wordpressUrl = env('WP_URL', 'http://127.0.0.1/proyecto/wp');
        $myBookings = [];

        try {
            $moviesResponse = Http::withoutVerifying()->get("{$wordpressUrl}/wp-json/wp/v2/pelicula?acf_format=standard&per_page=100");
            $allMovies = $moviesResponse->successful() ? $moviesResponse->json() : [];

            $resResponse = Http::withoutVerifying()->get("{$wordpressUrl}/wp-json/wp/v2/reservas?per_page=100&acf_format=standard");
            if ($resResponse->successful()) {
                foreach ($resResponse->json() as $reserva) {
                    $acf = $reserva['acf'] ?? [];
                    if (($acf['user_email'] ?? '') === $user->email) {
                        $movieTitle = $acf['movie_title'] ?? '';
                        $movieData = collect($allMovies)->firstWhere('title.rendered', $movieTitle);

                        $myBookings[] = [
                            'id'     => $reserva['id'],
                            'movie'  => $movieTitle,
                            'seats'  => $acf['seats'] ?? 'N/A',
                            'total'  => $acf['total_price'] ?? '0.00',
                            'items'  => json_decode($acf['items_json'] ?? '[]', true),
                            'date'   => $reserva['date'],
                            'poster' => $movieData['acf']['poster'] ?? '',
                            'bg'     => $movieData['acf']['bg'] ?? '#141414', 
                            'color'  => $movieData['acf']['textcolor'] ?? 'white'
                        ];
                    }
                }
            }
        } catch (\Exception $e) { }

        return view('profile', compact('myBookings', 'user'));
    })->name('profile.edit');

    Route::post('/email/verification-notification', [AuthController::class, 'store'])->name('verification.send');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [AuthController::class, 'updatePassword'])->name('password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 5. BOOKING (CON ASIENTOS REALES Y BLOQUEOS TEMPORALES)
    Route::get('/booking/{id}', function ($id) {
        $wordpressUrl = env('WP_URL', 'http://127.0.0.1/proyecto/wp'); 
        $movie = ["title" => "Película Desconocida", "bgImg" => "", "bg" => "#222222", "textColor" => "white"];
        $occupiedSeats = []; // Array de asientos ocupados reales

        try {
            // 1. Obtenemos título de la peli
            $response = Http::withoutVerifying()->get("{$wordpressUrl}/wp-json/wp/v2/pelicula?acf_format=standard&per_page=100");
            $movieTitle = "";
            if ($response->successful()) {
                foreach ($response->json() as $wpMovie) {
                    $acf = $wpMovie['acf'] ?? [];
                    if (isset($acf['id_laravel']) && (int)$acf['id_laravel'] === (int)$id) {
                        $movieTitle = $wpMovie['title']['rendered'];
                        $movie = ["title" => $movieTitle, "bgImg" => $acf['bgimg'] ?? "", "bg" => $acf['bg'] ?? "#000000", "textColor" => $acf['textcolor'] ?? "white"];
                        break;
                    }
                }
            }

            // 2. Extraemos reservas PERMANENTES de WordPress
            if (!empty($movieTitle)) {
                $resResponse = Http::withoutVerifying()->get("{$wordpressUrl}/wp-json/wp/v2/reservas?per_page=100&acf_format=standard");
                if ($resResponse->successful()) {
                    foreach ($resResponse->json() as $reserva) {
                        $acfRes = $reserva['acf'] ?? [];
                        if (($acfRes['movie_title'] ?? '') === $movieTitle) {
                            $seatsString = $acfRes['seats'] ?? '';
                            if (!empty($seatsString)) {
                                $seatsArray = explode(',', $seatsString);
                                foreach($seatsArray as $s) {
                                    $occupiedSeats[] = trim($s);
                                }
                            }
                        }
                    }
                }

                // 3. Extraemos bloqueos TEMPORALES (10 minutos) de la Caché de Laravel
                $rowsArray = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
                foreach ($rowsArray as $row) {
                    for ($i = 1; $i <= 10; $i++) {
                        $seatCheck = $row . $i;
                        // Si el asiento está en caché para esta película, lo marcamos como ocupado
                        if (Cache::has('locked_' . Str::slug($movieTitle) . '_' . $seatCheck)) {
                            $occupiedSeats[] = $seatCheck;
                        }
                    }
                }
            }
        } catch (\Exception $e) { }

        // Limpiamos duplicados por si acaso
        $occupiedSeats = array_unique($occupiedSeats);

        return view('booking', ['id' => $id, 'movie' => $movie, 'realOccupied' => $occupiedSeats]);
    })->middleware('auth')->name('booking.show');


    // 6. COMIDA (APLICA EL BLOQUEO DE 10 MINUTOS Y CARGA MENÚ REAL)
    Route::get('/booking/{id}/food', function (Request $request, $id) {
        $wordpressUrl = env('WP_URL', 'http://127.0.0.1/proyecto/wp'); 
        $movie = ["title" => "Película Desconocida", "bgImg" => "", "bg" => "#222222", "textColor" => "white"];
        
        // Arrays limpios para el menú, sin datos falsos
        $menu = [
            'exclusive' => [], 
            'popcorn'   => [], 
            'drinks'    => [], 
            'snacks'    => []
        ];

        try {
            // 1. Obtenemos la película
            $response = Http::withoutVerifying()->get("{$wordpressUrl}/wp-json/wp/v2/pelicula?acf_format=standard&per_page=100");
            if ($response->successful()) {
                foreach ($response->json() as $wpMovie) {
                    $acf = $wpMovie['acf'] ?? [];
                    if (isset($acf['id_laravel']) && (int)$acf['id_laravel'] === (int)$id) {
                        $movie = [
                            "title" => $wpMovie['title']['rendered'], 
                            "bgImg" => $acf['bgimg'] ?? "", 
                            "bg" => $acf['bg'] ?? "#000000", 
                            "textColor" => $acf['textcolor'] ?? "white"
                        ];
                        break;
                    }
                }
            }

            // 2. BLOQUEO DE ASIENTOS: Los metemos en la caché por 10 minutos
            $seatsParam = $request->query('seats');
            if (!empty($seatsParam) && !empty($movie['title'])) {
                $seatsArray = explode(',', $seatsParam);
                foreach ($seatsArray as $seat) {
                    Cache::put('locked_' . Str::slug($movie['title']) . '_' . trim($seat), true, now()->addMinutes(10));
                }
            }

            // 3. OBTENEMOS LA COMIDA DE WORDPRESS
            $foodResponse = Http::withoutVerifying()->get("{$wordpressUrl}/wp-json/wp/v2/comida?acf_format=standard&per_page=100");
            if ($foodResponse->successful()) {
                foreach ($foodResponse->json() as $item) {
                    $acfFood = $item['acf'] ?? [];
                    $categoria = strtolower($acfFood['category'] ?? 'snacks'); // popcorn, drinks, snacks, exclusive
                    
                    $foodObj = [
                        'name'  => $item['title']['rendered'],
                        'price' => (float)($acfFood['price'] ?? 0),
                        'img'   => $acfFood['image'] ?? '',
                        'desc'  => $acfFood['description'] ?? '',
                        'stock' => (int)($acfFood['stock'] ?? 100),
                        'spent' => filter_var($acfFood['spent'] ?? false, FILTER_VALIDATE_BOOLEAN)
                    ];

                    // Filtro para el menú exclusivo
                    if ($categoria === 'exclusive') {
                        if (isset($acfFood['id_pelicula']) && (int)$acfFood['id_pelicula'] === (int)$id) {
                            $menu['exclusive'][] = $foodObj;
                        }
                    } else {
                        // Lo mandamos a su categoría correspondiente
                        if (isset($menu[$categoria])) {
                            $menu[$categoria][] = $foodObj;
                        } else {
                            $menu['snacks'][] = $foodObj;
                        }
                    }
                }
            }

        } catch (\Exception $e) { }

        return view('booking-food', [
            'id' => $id, 
            'movie' => $movie, 
            'menu' => $menu, 
            'seats' => $request->query('seats'), 
            'ticketsTotal' => $request->query('ticketsTotal')
        ]);
    })->middleware('auth')->name('booking.food');

    // 7. CHECKOUT VISTA
    Route::get('/booking/{id}/checkout', function ($id) {
        $wordpressUrl = env('WP_URL', 'http://127.0.0.1/proyecto/wp'); 
        $movie = ["title" => "Película Desconocida", "bgImg" => "", "bg" => "#222222", "textColor" => "white"];
        try {
            $response = Http::withoutVerifying()->get("{$wordpressUrl}/wp-json/wp/v2/pelicula?acf_format=standard&per_page=100");
            if ($response->successful()) {
                foreach ($response->json() as $wpMovie) {
                    $acf = $wpMovie['acf'] ?? [];
                    if (isset($acf['id_laravel']) && (int)$acf['id_laravel'] === (int)$id) {
                        $movie = ["title" => $wpMovie['title']['rendered'], "bgImg" => $acf['bgimg'] ?? "", "bg" => $acf['bg'] ?? "#000000", "textColor" => $acf['textcolor'] ?? "white"];
                        break;
                    }
                }
            }
        } catch (\Exception $e) { }
        return view('checkout', ['id' => $id, 'movie' => $movie]);
    })->name('booking.checkout.view');
});

// 8. PROCESAR PAGO STRIPE
Route::post('/checkout', function (Request $request) {
    Stripe::setApiKey(env('STRIPE_SECRET'));
    Session::put('last_order', [
        'movie_title' => $request->input('movie_title'),
        'seats' => $request->input('seats'),
        'total' => $request->input('total'),
        'items' => $request->input('items_json'),
    ]);

    $checkout_session = StripeSession::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => ['currency' => 'eur', 'product_data' => ['name' => 'Entradas: ' . $request->input('movie_title')], 'unit_amount' => $request->input('total') * 100],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => route('checkout.success'),
        'cancel_url' => route('home'),
    ]);
    return redirect($checkout_session->url);
})->name('checkout.process');

// 9. ÉXITO Y GUARDADO EN WORDPRESS
Route::get('/checkout/success', function () {
    $orderData = Session::get('last_order');
    if ($orderData) {
        $wordpressUrl = env('WP_URL');
        $userEmail = Auth::user()->email;
        try {
            Http::withBasicAuth(env('WP_USER'), env('WP_PASSWORD'))->withoutVerifying()
                ->post("{$wordpressUrl}/wp-json/wp/v2/reservas", [
                    'title'   => 'Reserva - ' . $orderData['movie_title'] . ' - ' . $userEmail,
                    'status'  => 'publish',
                    'acf'     => [
                        'user_email'  => $userEmail,
                        'movie_title' => $orderData['movie_title'],
                        'seats'       => $orderData['seats'],
                        'total_price' => $orderData['total'],
                        'items_json'  => $orderData['items']
                    ]
                ]);
            Mail::to($userEmail)->send(new \App\Mail\TicketConfirmation($orderData));
        } catch (\Exception $e) { }

        Session::forget('last_order');
        return redirect()->route('profile.edit', ['success' => 1])
            ->withFragment('tab-bookings')
            ->with('payment_success', true)
            ->with('last_purchase', $orderData);
    }
    return redirect()->route('home');
})->name('checkout.success');