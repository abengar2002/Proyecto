<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\PasswordController;
use Illuminate\Support\Facades\Http; 
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth;

// 1. PORTADA
Route::get('/', function () {
    return view('index'); 
})->name('home');

// 2. DETALLES DE PELÍCULA
Route::get('/pelicula/{id}', function ($id) {
    $wordpressUrl = env('WP_URL', 'http://127.0.0.1/proyecto/wp'); 

    $movie = [
        "title" => "Película Desconocida", "age" => "?", "genre" => "Desconocido", 
        "bgImg" => "", "poster" => "", "desc" => "No hay información disponible.", 
        "bg" => "#222222", "textColor" => "white",
        "menuSpecial" => ["enabled" => false, "title" => "", "text" => "", "image" => ""]
    ];

    try {
        // ¡TIEMPO AUMENTADO A 30 SEGUNDOS PARA QUE NO CORTE LA CONEXIÓN!
        $response = Http::withoutVerifying()->timeout(30)->get("{$wordpressUrl}/wp-json/wp/v2/pelicula?acf_format=standard&per_page=100");

        if ($response->successful()) {
            foreach ($response->json() as $wpMovie) {
                $acf = $wpMovie['acf'] ?? [];
                
                if (isset($acf['id_laravel']) && (int)$acf['id_laravel'] === (int)$id) {
                    $movie = [
                        "title" => $wpMovie['title']['rendered'],
                        "desc" => strip_tags($wpMovie['content']['rendered']),
                        "age" => $acf['edad'] ?? "?",
                        "genre" => $acf['genero'] ?? "Desconocido",
                        "bgImg" => $acf['bgimg'] ?? "",
                        "poster" => $acf['poster'] ?? "",
                        "bg" => $acf['bg'] ?? "#000000",
                        "textColor" => $acf['textcolor'] ?? "white",
                        "isComingSoon" => filter_var($acf['iscomingsoon'] ?? false, FILTER_VALIDATE_BOOLEAN),
                        "releaseDate" => $acf['releasedate'] ?? "",
                        "menuSpecial" => [
                            // FORZAMOS A QUE ENTIENDA EL SÍ O NO CORRECTAMENTE
                            "enabled" => filter_var($acf['menu_special_enable'] ?? false, FILTER_VALIDATE_BOOLEAN),
                            "title"   => $acf['menu_special_title'] ?? "",
                            "text"    => $acf['menu_special_text'] ?? "",
                            "image"   => $acf['menu_special_img'] ?? ""    
                        ]
                    ];
                    break;
                }
            }
        }
    } catch (\Exception $e) { }

    // RESEÑAS
    $reviews = [];
    try {
        // TIEMPO AUMENTADO Y 100 RESEÑAS MÁXIMO
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

    $response = Http::withBasicAuth(env('WP_USER'), env('WP_PASSWORD'))
        ->withoutVerifying()
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

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
});

// 5. BOOKING (ESTÁTICO)
$bookingMovies = [
    "01" => ["title" => "Kill Bill", "bgImg" => "img/1-Kill-Bill/Portada.png", "bg" => "#ffd000", "textColor" => "black"],
    "02" => ["title" => "Five Nights at Freddy's", "bgImg" => "img/2-Five-Nights/Portada.png", "bg" => "#1a0429", "textColor" => "white"],
    "03" => ["title" => "Godzilla", "bgImg" => "img/3-Godzilla/Portada.png", "bg" => "#0a2233", "textColor" => "white"],
    "04" => ["title" => "Oppenheimer", "bgImg" => "img/4-Oppenheimer/Portada.png", "bg" => "#2e1409", "textColor" => "white"],
    "05" => ["title" => "Up", "bgImg" => "img/5-Up/Portada.png", "bg" => "#a1cce0", "textColor" => "black"],
    "06" => ["title" => "The Joker", "bgImg" => "img/6-The-Joker/Portada.png", "bg" => "#120908", "textColor" => "white"],
    "07" => ["title" => "Alien", "bgImg" => "img/7-Alien/Portada.png", "bg" => "#051417", "textColor" => "white"],
    "08" => ["title" => "Interstellar", "bgImg" => "img/8-Interstellar/Portada.png", "bg" => "#090a0a", "textColor" => "white"],
    "09" => ["title" => "Barbie", "bgImg" => "img/9-Barbie/Portada.png", "bg" => "#51caf5", "textColor" => "white"],
    "10" => ["title" => "Mamma Mia", "bgImg" => "img/10-MammaMia/Portada.jpg", "bg" => "#b3d0e2", "textColor" => "black"],
    "11" => ["title" => "Deadpool & Wolverine", "bgImg" => "img/11-Deadpool/Portada.png", "bg" => "#aa0000", "textColor" => "white"],
    "12" => ["title" => "Gladiator II", "bgImg" => "img/12-Gladiator/Portada.png", "bg" => "#d4af37", "textColor" => "black"],
    "13" => ["title" => "Venom 3", "bgImg" => "img/13-Venom/Portada.png", "bg" => "#630000", "textColor" => "black"],
    "14" => ["title" => "Mufasa", "bgImg" => "img/14-Mufasa/Portada.png", "bg" => "#ffa500", "textColor" => "black"],
    "15" => ["title" => "Kraven", "bgImg" => "img/15-Kraven/Portada.png", "bg" => "#8b4513", "textColor" => "white"]
];

Route::get('/booking/{id}', function ($id) use ($bookingMovies) {
    $movie = $bookingMovies[$id] ?? ["title" => "Película Desconocida", "bgImg" => "", "bg" => "#ffd000", "textColor" => "black"];
    return view('booking', ['id' => $id, 'movie' => $movie]);
})->name('booking.show');