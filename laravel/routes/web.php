<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// 1. RUTA PRINCIPAL (Tu portada)
// OJO: Asumo que el super diseño que hemos hecho se llama 'index.blade.php'. 
// Si lo guardaste como 'welcome.blade.php', cambia 'index' por 'welcome'.
Route::get('/', function () {
    return view('index'); 
})->name('home');


// 2. RUTAS PARA INVITADOS (GUEST)
// Solo pueden acceder a estas rutas si NO han iniciado sesión.
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/registro', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/registro', [AuthController::class, 'register']);
});


// 3. RUTAS PARA USUARIOS LOGUEADOS (AUTH)
// Solo pueden acceder a estas rutas si YA han iniciado sesión.
Route::middleware('auth')->group(function () {
    
    // Cerrar sesión
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Panel de control básico (por si lo necesitas más adelante)
    Route::get('/dashboard', function () {
        return view('dashboard'); // Tendrás que crear esta vista o redirigir a '/'
    })->name('dashboard');

    // --- Aquí meteremos más adelante las rutas del Carrito de la Compra ---
    // Route::post('/add-to-cart', ...);
    
});

// Ruta dinámica para la página de información de cualquier película
Route::get('/pelicula/{id}', function ($id) {
    return view('pelicula', ['id' => $id]);
})->name('pelicula.show');