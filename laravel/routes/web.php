<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\PasswordController;

// ==========================================
// 1. RUTA PRINCIPAL (PORTADA)
// ==========================================
Route::get('/', function () {
    return view('index'); 
})->name('home');


// ==========================================
// 2. RUTA DE DETALLES DE PELÍCULA
// ==========================================
Route::get('/pelicula/{id}', function ($id) {
    $movies = [
        "01" => ["title" => "Kill Bill", "age" => "+18", "genre" => "Action, Suspense", "bgImg" => "img/1-Kill-Bill/Portada.png", "poster" => "img/1-Kill-Bill/Mini.png", "desc" => "Una asesina despierta de un coma y jura vengarse de sus antiguos compañeros que la traicionaron el día de su boda."],
        "02" => ["title" => "Five Nights at Freddy's", "age" => "+16", "genre" => "Horror, Thriller", "bgImg" => "img/2-Five-Nights/Portada.png", "poster" => "img/2-Five-Nights/Mini.png", "desc" => "Un guardia de seguridad nocturno comienza a trabajar en Freddy Fazbear's Pizza, donde descubre que los animatrónicos cobran vida."],
        "03" => ["title" => "Godzilla", "age" => "+12", "genre" => "Action, Sci-Fi", "bgImg" => "img/3-Godzilla/Portada.png", "poster" => "img/3-Godzilla/Mini.png", "desc" => "El rey de los monstruos regresa para enfrentarse a criaturas gigantescas que amenazan la existencia de la humanidad."],
        "04" => ["title" => "Oppenheimer", "age" => "+16", "genre" => "Biography, History", "bgImg" => "img/4-Oppenheimer/Portada.png", "poster" => "img/4-Oppenheimer/Mini.png", "desc" => "La fascinante y paradójica historia del científico J. Robert Oppenheimer y su papel clave en el desarrollo de la bomba atómica."],
        "05" => ["title" => "Up", "age" => "TP", "genre" => "Animation, Adventure", "bgImg" => "img/5-Up/Portada.png", "poster" => "img/5-Up/Mini.png", "desc" => "Un viudo de 78 años viaja a Paradise Falls en su casa equipada con miles de globos, acompañado por un joven explorador."],
        "06" => ["title" => "The Joker", "age" => "+18", "genre" => "Crime, Drama", "bgImg" => "img/6-The-Joker/Portada.png", "poster" => "img/6-The-Joker/Mini.png", "desc" => "Un comediante fallido, ignorado por la sociedad, se vuelve loco y se convierte en un cerebro psicópata criminal en Gotham."],
        "07" => ["title" => "Alien", "age" => "+18", "genre" => "Horror, Sci-Fi", "bgImg" => "img/7-Alien/Portada.png", "poster" => "img/7-Alien/Mini.png", "desc" => "La tripulación de una nave espacial comercial aterriza en un planeta desconocido y se encuentra con una letal forma de vida."],
        "08" => ["title" => "Interstellar", "age" => "+12", "genre" => "Adventure, Sci-Fi", "bgImg" => "img/8-Interstellar/Portada.png", "poster" => "img/8-Interstellar/Mini.png", "desc" => "Un equipo de exploradores viaja a través de un agujero de gusano en el espacio en un intento por asegurar la supervivencia de la humanidad."],
        "09" => ["title" => "Barbie", "age" => "TP", "genre" => "Comedy, Fantasy", "bgImg" => "img/9-Barbie/Portada.png", "poster" => "img/9-Barbie/Mini.png", "desc" => "Barbie sufre una crisis que la lleva a cuestionarse su mundo perfecto, emprendiendo un viaje al mundo real."],
        "10" => ["title" => "Mamma Mia", "age" => "TP", "genre" => "Comedy, Musical", "bgImg" => "img/10-MammaMia/Portada.jpg", "poster" => "img/10-MammaMia/Mini.jpg", "desc" => "La historia de una joven que, antes de casarse, decide invitar a los tres posibles padres que su madre tuvo en el pasado."],
        
        "11" => ["title" => "Deadpool & Wolverine", "age" => "+18", "genre" => "Action, Comedy", "bgImg" => "img/11-Peli/Portada.png", "poster" => "img/11-Peli/Mini.png", "desc" => "Deadpool y Wolverine se unen en una nueva y alocada aventura."],
        "12" => ["title" => "Gladiator II", "age" => "+16", "genre" => "Action, Drama", "bgImg" => "img/12-Peli/Portada.png", "poster" => "img/12-Peli/Mini.png", "desc" => "La esperada secuela de la épica historia de Roma."],
        "13" => ["title" => "Venom 3", "age" => "+16", "genre" => "Sci-Fi, Action", "bgImg" => "img/13-Peli/Portada.png", "poster" => "img/13-Peli/Mini.png", "desc" => "Eddie Brock y el simbionte se enfrentan a su mayor desafío."],
        "14" => ["title" => "Mufasa", "age" => "TP", "genre" => "Adventure, Family", "bgImg" => "img/14-Peli/Portada.png", "poster" => "img/14-Peli/Mini.png", "desc" => "El origen del rey de la sabana contado a la nueva generación."],
        "15" => ["title" => "Kraven", "age" => "+16", "genre" => "Action, Thriller", "bgImg" => "img/15-Peli/Portada.png", "poster" => "img/15-Peli/Mini.png", "desc" => "Descubre cómo surgió uno de los cazadores más letales del universo."]
    ];

    $movie = $movies[$id] ?? [
        "title" => "Película Desconocida", "age" => "?", "genre" => "Desconocido", 
        "bgImg" => "", "poster" => "", "desc" => "No hay información disponible para esta película."
    ];

    return view('pelicula', ['id' => $id, 'movie' => $movie]);
})->name('pelicula.show');


// ==========================================
// 3. RUTAS DE USUARIOS (AUTENTICACIÓN Y PERFIL)
// ==========================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/registro', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/registro', [AuthController::class, 'register']);

    Route::get('/verificacion-2fa', [AuthController::class, 'show2faForm'])->name('2fa.form');
    Route::post('/verificacion-2fa', [AuthController::class, 'verify2fa'])->name('2fa.verify');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::put('/password', [PasswordController::class, 'update'])->name('password.update');
});


// ==========================================
// 4. FLUJO DE COMPRA (BOOKING)
// ==========================================

// Array global simulado para las rutas de compra
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
    "10" => ["title" => "Mamma Mia", "bgImg" => "img/10-MammaMia/Portada.jpg", "bg" => "#b3d0e2", "textColor" => "black"]
];

// Paso 1: Selección de butacas
Route::get('/booking/{id}', function ($id) use ($bookingMovies) {
    $movie = $bookingMovies[$id] ?? ["title" => "Película Desconocida", "bgImg" => "", "bg" => "#ffd000", "textColor" => "black"];
    return view('booking', ['id' => $id, 'movie' => $movie]);
})->name('booking.show');

// Paso 2: Selección de comida
Route::get('/booking/{id}/food', function ($id) use ($bookingMovies) {
    $movie = $bookingMovies[$id] ?? ["title" => "Película Desconocida", "bgImg" => "", "bg" => "#ffd000", "textColor" => "black"];
    return view('booking-food', ['id' => $id, 'movie' => $movie]);
})->name('booking.food');

// Paso 3: Pasarela de pago
Route::get('/booking/{id}/checkout', function ($id) use ($bookingMovies) {
    $movie = $bookingMovies[$id] ?? ["title" => "Película Desconocida", "bgImg" => "", "bg" => "#ffd000", "textColor" => "black"];
    return view('checkout', ['id' => $id, 'movie' => $movie]);
})->name('booking.checkout');