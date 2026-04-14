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

// =====================================================================
// 1. PORTADA (HOME)
// =====================================================================
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
                $laravelId = str_pad($acf['id_laravel'] ?? 0, 2, '0', STR_PAD_LEFT);

                $movieData = [
                    'id' => $laravelId,
                    'title' => html_entity_decode($wpMovie['title']['rendered'], ENT_QUOTES | ENT_HTML5, 'UTF-8'),
                    'age' => $acf['edad'] ?? 'TP',
                    'rating' => (int)($acf['puntuacion'] ?? 4),
                    'genre' => $acf['genero'] ?? 'Unknown',
                    'bg' => $acf['bg'] ?? '#000000',
                    'textColor' => $acf['textcolor'] ?? 'white',
                    'bgImg' => $acf['bgimg'] ?? '',
                    'poster' => $acf['poster'] ?? '',
                    'date' => $acf['releasedate'] ?? 'SOON'
                ];

                if ($isComingSoon) { $comingSoon[] = $movieData; } 
                else { $nowPlaying[] = $movieData; }
            }
        }
    } catch (\Exception $e) {}

    if (empty($nowPlaying)) {
        $nowPlaying[] = ['id' => "00", 'title' => "No Movies Found", 'age' => "TP", 'rating' => 0, 'genre' => "Error", 'bg' => "#000000", 'textColor' => "white", 'bgImg' => "", 'poster' => "", 'date' => ""];
    } else {
        $nowPlaying = collect($nowPlaying)->sortBy('id')->values()->toArray();
        $comingSoon = collect($comingSoon)->sortBy('id')->values()->toArray();
    }

    return view('index', ['movies' => $nowPlaying, 'comingSoonMovies' => $comingSoon]);
})->name('home');


// =====================================================================
// 2. DETALLES DE PELÍCULA
// =====================================================================
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
                            return "https://img.youtube.com/vi/{$match[1]}/maxresdefault.jpg";
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

                    $menuSpecial = ["enabled" => false, "title" => "", "text" => "", "image" => ""];
                    try {
                        $foodResponse = Http::withoutVerifying()->timeout(10)->get("{$wordpressUrl}/wp-json/wp/v2/comida?acf_format=standard&per_page=100");
                        if ($foodResponse->successful()) {
                            foreach ($foodResponse->json() as $item) {
                                $acfFood = $item['acf'] ?? [];
                                $isExclusive = strtolower($acfFood['category'] ?? '') === 'exclusive';
                                $matchesMovie = (int)($acfFood['id_pelicula'] ?? 0) === (int)$id;
                                $isSpent = filter_var($acfFood['spent'] ?? false, FILTER_VALIDATE_BOOLEAN);
                                
                                if ($isExclusive && $matchesMovie && !$isSpent) {
                                    $menuSpecial = [
                                        "enabled" => true,
                                        "title"   => html_entity_decode($item['title']['rendered'], ENT_QUOTES | ENT_HTML5, 'UTF-8'),
                                        "text"    => html_entity_decode($acfFood['description'] ?? "", ENT_QUOTES | ENT_HTML5, 'UTF-8'),
                                        "image"   => $acfFood['image'] ?? ""
                                    ];
                                    break; 
                                }
                            }
                        }
                    } catch (\Exception $e) {}

                    $movie = [
                        "title" => html_entity_decode($wpMovie['title']['rendered'], ENT_QUOTES | ENT_HTML5, 'UTF-8'),
                        "desc" => html_entity_decode(strip_tags($wpMovie['content']['rendered']), ENT_QUOTES | ENT_HTML5, 'UTF-8'),
                        "age" => $acf['edad'] ?? "?",
                        "genre" => $acf['genero'] ?? "Unknown",
                        "bgImg" => $acf['bgimg'] ?? "",
                        "poster" => $acf['poster'] ?? "",
                        "bg" => $acf['bg'] ?? "#000000",
                        "textColor" => $acf['textcolor'] ?? "white",
                        "isComingSoon" => filter_var($acf['iscomingsoon'] ?? false, FILTER_VALIDATE_BOOLEAN),
                        "releaseDate" => $acf['releasedate'] ?? "",
                        "mediaCarousel" => array_slice($mediaItems, 0, 5),
                        "menuSpecial" => $menuSpecial
                    ];
                    break;
                }
            }
        }
    } catch (\Exception $e) { }

    return view('pelicula', ['id' => $id, 'movie' => $movie]);
})->name('pelicula.show');


// =====================================================================
// 3. AUTENTICACIÓN Y PERFIL
// =====================================================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/registro', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/registro', [AuthController::class, 'register']);
});

Route::get('/2fa', [AuthController::class, 'show2faForm'])->name('2fa.form');
Route::post('/2fa', [AuthController::class, 'verify2fa'])->name('2fa.verify');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

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
});


// =====================================================================
// 4. RESERVAS (BOOKING, COMIDA Y ASIENTOS)
// =====================================================================
Route::middleware('auth')->group(function () {
    Route::get('/booking/{id}', function ($id) {
        $wordpressUrl = env('WP_URL', 'http://127.0.0.1/proyecto/wp'); 
        $movie = ["title" => "Película Desconocida", "bgImg" => "", "bg" => "#222222", "textColor" => "white"];
        $occupiedSeats = []; 

        try {
            $response = Http::withoutVerifying()->get("{$wordpressUrl}/wp-json/wp/v2/pelicula?acf_format=standard&per_page=100");
            $movieTitle = "";
            if ($response->successful()) {
                foreach ($response->json() as $wpMovie) {
                    $acf = $wpMovie['acf'] ?? [];
                    if (isset($acf['id_laravel']) && (int)$acf['id_laravel'] === (int)$id) {
                        $movieTitle = html_entity_decode($wpMovie['title']['rendered'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
                        $movie = ["title" => $movieTitle, "bgImg" => $acf['bgimg'] ?? "", "bg" => $acf['bg'] ?? "#000000", "textColor" => $acf['textcolor'] ?? "white"];
                        break;
                    }
                }
            }

            if (!empty($movieTitle)) {
                $resResponse = Http::withoutVerifying()->get("{$wordpressUrl}/wp-json/wp/v2/reservas?per_page=100&acf_format=standard");
                if ($resResponse->successful()) {
                    foreach ($resResponse->json() as $reserva) {
                        $acfRes = $reserva['acf'] ?? [];
                        if (($acfRes['movie_title'] ?? '') === $movieTitle) {
                            $seatsString = $acfRes['seats'] ?? '';
                            if (!empty($seatsString)) {
                                foreach(explode(',', $seatsString) as $s) {
                                    $occupiedSeats[] = trim($s);
                                }
                            }
                        }
                    }
                }

                $rowsArray = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
                foreach ($rowsArray as $row) {
                    for ($i = 1; $i <= 10; $i++) {
                        $seatCheck = $row . $i;
                        if (Cache::has('locked_' . Str::slug($movieTitle) . '_' . $seatCheck)) {
                            $occupiedSeats[] = $seatCheck;
                        }
                    }
                }
            }
        } catch (\Exception $e) { }

        $occupiedSeats = array_unique($occupiedSeats);
        return view('booking', ['id' => $id, 'movie' => $movie, 'realOccupied' => $occupiedSeats]);
    })->name('booking.show');


    Route::get('/booking/{id}/food', function (Request $request, $id) {
        $wordpressUrl = env('WP_URL', 'http://127.0.0.1/proyecto/wp'); 
        $movie = ["title" => "Película Desconocida", "bgImg" => "", "bg" => "#222222", "textColor" => "white"];
        $menu = ['exclusive' => [], 'popcorn' => [], 'drinks' => [], 'snacks' => []];

        try {
            $response = Http::withoutVerifying()->get("{$wordpressUrl}/wp-json/wp/v2/pelicula?acf_format=standard&per_page=100");
            if ($response->successful()) {
                foreach ($response->json() as $wpMovie) {
                    $acf = $wpMovie['acf'] ?? [];
                    if (isset($acf['id_laravel']) && (int)$acf['id_laravel'] === (int)$id) {
                        $movie = ["title" => html_entity_decode($wpMovie['title']['rendered'], ENT_QUOTES | ENT_HTML5, 'UTF-8'), "bgImg" => $acf['bgimg'] ?? "", "bg" => $acf['bg'] ?? "#000000", "textColor" => $acf['textcolor'] ?? "white"];
                        break;
                    }
                }
            }

            $seatsParam = $request->query('seats');
            if (!empty($seatsParam) && !empty($movie['title'])) {
                $seatsArray = explode(',', $seatsParam);
                foreach ($seatsArray as $seat) {
                    Cache::put('locked_' . Str::slug($movie['title']) . '_' . trim($seat), true, now()->addMinutes(10));
                }
            }

            $foodResponse = Http::withoutVerifying()->get("{$wordpressUrl}/wp-json/wp/v2/comida?acf_format=standard&per_page=100");
            if ($foodResponse->successful()) {
                foreach ($foodResponse->json() as $item) {
                    $acfFood = $item['acf'] ?? [];
                    $categoria = strtolower($acfFood['category'] ?? 'snacks'); 
                    $foodObj = [
                        'name'  => html_entity_decode($item['title']['rendered'], ENT_QUOTES | ENT_HTML5, 'UTF-8'),
                        'price' => (float)($acfFood['price'] ?? 0),
                        'img'   => $acfFood['image'] ?? '',
                        'desc'  => html_entity_decode($acfFood['description'] ?? "", ENT_QUOTES | ENT_HTML5, 'UTF-8'),
                        'stock' => (int)($acfFood['stock'] ?? 100),
                        'spent' => filter_var($acfFood['spent'] ?? false, FILTER_VALIDATE_BOOLEAN)
                    ];

                    if ($categoria === 'exclusive') {
                        if (isset($acfFood['id_pelicula']) && (int)$acfFood['id_pelicula'] === (int)$id) {
                            $menu['exclusive'][] = $foodObj;
                        }
                    } else {
                        if (isset($menu[$categoria])) { $menu[$categoria][] = $foodObj; } 
                        else { $menu['snacks'][] = $foodObj; }
                    }
                }
            }
        } catch (\Exception $e) { }

        return view('booking-food', [
            'id' => $id, 'movie' => $movie, 'menu' => $menu, 
            'seats' => $request->query('seats'), 'ticketsTotal' => $request->query('ticketsTotal')
        ]);
    })->name('booking.food');


    Route::get('/booking/{id}/checkout', function ($id) {
        $wordpressUrl = env('WP_URL', 'http://127.0.0.1/proyecto/wp'); 
        $movie = ["title" => "Película Desconocida", "bgImg" => "", "bg" => "#222222", "textColor" => "white"];
        try {
            $response = Http::withoutVerifying()->get("{$wordpressUrl}/wp-json/wp/v2/pelicula?acf_format=standard&per_page=100");
            if ($response->successful()) {
                foreach ($response->json() as $wpMovie) {
                    $acf = $wpMovie['acf'] ?? [];
                    if (isset($acf['id_laravel']) && (int)$acf['id_laravel'] === (int)$id) {
                        $movie = ["title" => html_entity_decode($wpMovie['title']['rendered'], ENT_QUOTES | ENT_HTML5, 'UTF-8'), "bgImg" => $acf['bgimg'] ?? "", "bg" => $acf['bg'] ?? "#000000", "textColor" => $acf['textcolor'] ?? "white"];
                        break;
                    }
                }
            }
        } catch (\Exception $e) { }
        return view('checkout', ['id' => $id, 'movie' => $movie]);
    })->name('booking.checkout.view');


    Route::post('/api/unlock-seats', function (Request $request) {
        $movieTitle = $request->input('movie_title');
        $seatsString = $request->input('seats');
        if (!empty($movieTitle) && !empty($seatsString)) {
            foreach (explode(',', $seatsString) as $seat) {
                Cache::forget('locked_' . Str::slug($movieTitle) . '_' . trim($seat));
            }
        }
        return response()->json(['success' => true]);
    })->name('api.unlock.seats');


    Route::delete('/reserva/{id}', function ($id) {
        $wordpressUrl = env('WP_URL', 'http://127.0.0.1/proyecto/wp');
        try {
            $resResponse = Http::withoutVerifying()->get("{$wordpressUrl}/wp-json/wp/v2/reservas/{$id}?acf_format=standard");
            if ($resResponse->successful()) {
                $acf = $resResponse->json()['acf'] ?? [];
                $movieTitle = $acf['movie_title'] ?? '';
                $seatsString = $acf['seats'] ?? '';
                if (!empty($movieTitle) && !empty($seatsString)) {
                    $movieSlug = Str::slug($movieTitle);
                    foreach (explode(',', $seatsString) as $seat) {
                        Cache::forget('locked_' . $movieSlug . '_' . trim($seat));
                    }
                }
            }
            Http::withBasicAuth(env('WP_USER'), env('WP_PASSWORD'))->withoutVerifying()->delete("{$wordpressUrl}/wp-json/wp/v2/reservas/{$id}?force=true");
        } catch (\Exception $e) {}
        return redirect()->route('profile.edit', ['tab' => 'bookings'])->with('status', 'Booking cancelled successfully.');
    })->name('reserva.destroy');


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
});


// =====================================================================
// 5. PASARELA STRIPE
// =====================================================================
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

Route::get('/checkout/success', function () {
    $orderData = Session::get('last_order');
    if ($orderData) {
        $wordpressUrl = env('WP_URL', 'http://127.0.0.1/proyecto/wp');
        $userEmail = Auth::user()->email;
        try {
            $response = Http::withBasicAuth(env('WP_USER'), env('WP_PASSWORD'))->withoutVerifying()
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
            if ($response->successful()) { $orderData['id'] = $response->json()['id'] ?? ''; }
            Mail::to($userEmail)->send(new \App\Mail\TicketConfirmation($orderData));
        } catch (\Exception $e) { }

        Session::forget('last_order');
        return redirect()->route('profile.edit', ['success' => 1])
            ->withFragment('tab-bookings')
            ->with('payment_success', true)
            ->with('last_purchase', $orderData);
    }
    return redirect()->route('home');
})->middleware('auth')->name('checkout.success');


// =====================================================================
// 6. COMUNIDAD / FORO 
// =====================================================================
Route::get('/community', function () {
    $wordpressUrl = env('WP_URL', 'http://127.0.0.1/proyecto/wp');
    $movies = [];
    $allPosts = [];
    $replies = [];

    try {
        $movRes = Http::withoutVerifying()->get("{$wordpressUrl}/wp-json/wp/v2/pelicula?acf_format=standard&per_page=100");
        if ($movRes->successful()) {
            foreach ($movRes->json() as $wpMovie) {
                $acf = $wpMovie['acf'] ?? [];
                $movies[$acf['id_laravel'] ?? 0] = [
                    'id' => $acf['id_laravel'] ?? 0,
                    'title' => html_entity_decode($wpMovie['title']['rendered'], ENT_QUOTES | ENT_HTML5, 'UTF-8'),
                    'color' => $acf['bg'] ?? '#ffd000',
                    'poster' => $acf['poster'] ?? '',
                    'post_count' => 0
                ];
            }
            ksort($movies); 
        }

        $revRes = Http::withoutVerifying()->get("{$wordpressUrl}/wp-json/wp/v2/reviews?per_page=100&acf_format=standard");
        if ($revRes->successful()) {
            $currentUserEmail = Auth::check() ? Auth::user()->email : null;

            foreach ($revRes->json() as $review) {
                $acf = $review['acf'] ?? [];
                $movieId = $acf['id_pelicula_laravel'] ?? 0;
                $parentId = (int)($acf['parent_id'] ?? 0);
                
                if (isset($movies[$movieId])) {
                    $movies[$movieId]['post_count']++;
                }

                $rawTitle = html_entity_decode($review['title']['rendered'] ?? '', ENT_QUOTES | ENT_HTML5, 'UTF-8');
                $userEmail = $acf['user_email'] ?? '';
                $postTitle = $rawTitle;

                // --- TRUCO INFALIBLE: SEPARAMOS EL EMAIL DEL TÍTULO ---
                if (str_contains($rawTitle, '|||')) {
                    $parts = explode('|||', $rawTitle);
                    $userEmail = trim($parts[0]);
                    $postTitle = trim($parts[1] ?? '');
                }

                // Buscamos al usuario 
                $localUser = \App\Models\User::where('email', $userEmail)->first();
                
                if ($localUser) {
                    $authorName = $localUser->name;
                } else {
                    if (str_starts_with($postTitle, 'Review by ')) {
                        $authorName = str_replace('Review by ', '', $postTitle);
                    } elseif (!empty($userEmail)) {
                        $authorName = explode('@', $userEmail)[0];
                    } else {
                        $authorName = 'Anonymous';
                    }
                }
                
                // AVATAR
                if ($localUser && !empty($localUser->avatar)) {
                    $avatarName = str_contains($localUser->avatar, '.png') ? $localUser->avatar : $localUser->avatar . '.png';
                    $avatarUrl = asset('img/avatars/' . $avatarName);
                } else {
                    $randomId = (crc32($authorName) % 10) + 1; 
                    $avatarUrl = asset('img/avatars/avatar' . $randomId . '.png');
                }
                
                $likedBy = $acf['users_liked'] ?? '';
                $hasLiked = $currentUserEmail && str_contains($likedBy, $currentUserEmail);

                // Limpiamos los títulos por defecto para que no se vean
                if (str_starts_with($postTitle, 'Review by') || str_starts_with($postTitle, 'Reserva -')) {
                    $postTitle = '';
                }

                $rawContent = strip_tags($review['content']['rendered'] ?? '');
                $cleanContent = html_entity_decode($rawContent, ENT_QUOTES | ENT_HTML5, 'UTF-8');

                $postData = [
                    'id' => $review['id'],
                    'author' => $authorName,
                    'post_title' => $postTitle,
                    'avatar' => $avatarUrl,
                    'content' => $cleanContent,
                    'movie_info' => $movies[$movieId] ?? null,
                    'date' => date('M j, H:i', strtotime($review['date'])),
                    'likes' => (int)($acf['likes'] ?? 0),
                    'has_liked' => $hasLiked,
                    'parent_id' => $parentId,
                    'movie_id' => $movieId,
                    'replies' => []
                ];

                if ($parentId === 0) { $allPosts[$review['id']] = $postData; } 
                else { $replies[] = $postData; }
            }

            foreach ($replies as $reply) {
                if (isset($allPosts[$reply['parent_id']])) {
                    array_push($allPosts[$reply['parent_id']]['replies'], $reply);
                }
            }
        }
    } catch (\Exception $e) {}

    $posts = array_values($allPosts);
    
    usort($posts, function($a, $b) { 
        if ($a['likes'] === $b['likes']) {
            return $b['id'] <=> $a['id']; 
        }
        return $b['likes'] <=> $a['likes']; 
    });

    $trendingMovies = array_filter($movies, function($m) { return $m['post_count'] > 0; });
    usort($trendingMovies, function($a, $b) { return $b['post_count'] <=> $a['post_count']; });
    $trendingMovies = array_slice($trendingMovies, 0, 3);

    return view('community', compact('movies', 'posts', 'trendingMovies'));
})->name('community.index');


Route::post('/community/post', function (Request $request) {
    $request->validate([
        'post_title' => 'nullable|string|max:150',
        'content' => 'required|string|min:2',
        'movie_id' => 'required',
        'parent_id' => 'nullable'
    ]);
    
    $wordpressUrl = env('WP_URL', 'http://127.0.0.1/proyecto/wp');
    
    $titleToSave = $request->input('post_title');
    if (empty($titleToSave)) {
        $titleToSave = 'Review';
    }

    // --- TRUCO INFALIBLE: Unimos email y título para que WordPress lo guarde sí o sí ---
    $composedTitle = Auth::user()->email . '|||' . $titleToSave;

    $postData = [
        'title'   => $composedTitle,
        'content' => $request->input('content'),
        'status'  => 'publish',
        'acf'     => [
            'id_pelicula_laravel' => (string) $request->input('movie_id'),
            'user_email' => Auth::user()->email,
            'likes' => 0,
            'users_liked' => '',
            'parent_id' => (int) $request->input('parent_id', 0) 
        ]
    ];

    $response = Http::withBasicAuth(env('WP_USER'), env('WP_PASSWORD'))->withoutVerifying()
        ->post("{$wordpressUrl}/wp-json/wp/v2/reviews", $postData);

    if ($response->failed()) {
        return back()->with('error', 'WP Error: ' . $response->body());
    }

    return back()->with('status', 'Posted successfully!');
})->name('community.post')->middleware('auth');


Route::post('/api/community/like/{id}', function ($id) {
    $wordpressUrl = env('WP_URL', 'http://127.0.0.1/proyecto/wp');
    $userEmail = Auth::user()->email;

    $getRes = Http::withoutVerifying()->get("{$wordpressUrl}/wp-json/wp/v2/reviews/{$id}?acf_format=standard");
    if ($getRes->successful()) {
        $acf = $getRes->json()['acf'] ?? [];
        $likedBy = $acf['users_liked'] ?? '';
        $currentLikes = (int)($acf['likes'] ?? 0);
        
        $likedArray = array_filter(explode(',', $likedBy)); 

        if (in_array($userEmail, $likedArray)) {
            $likedArray = array_diff($likedArray, [$userEmail]);
            $newLikes = max(0, $currentLikes - 1);
            $isLiked = false;
        } else {
            $likedArray[] = $userEmail;
            $newLikes = $currentLikes + 1;
            $isLiked = true;
        }

        $newList = implode(',', $likedArray); 

        $updateRes = Http::withBasicAuth(env('WP_USER'), env('WP_PASSWORD'))->withoutVerifying()
            ->post("{$wordpressUrl}/wp-json/wp/v2/reviews/{$id}", [
                'acf' => [ 
                    'likes' => $newLikes,
                    'users_liked' => $newList
                ]
            ]);

        if ($updateRes->successful()) {
            return response()->json(['success' => true, 'likes' => $newLikes, 'is_liked' => $isLiked]);
        }
    }
    return response()->json(['success' => false], 500);
})->middleware('auth');