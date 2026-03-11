<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class AuthController extends Controller
{
    // ==========================================
    // 1. LÓGICA DE LOGIN
    // ==========================================
    public function showLogin() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $request->validate(['email' => 'required|email', 'password' => 'required']);

        $user = User::where('email', $request->email)->first();

        // Si las credenciales son correctas
        if ($user && Hash::check($request->password, $user->password)) {
            
            // Generar código y guardarlo
            $code = rand(100000, 999999);
            $user->update([
                'two_factor_code' => $code,
                'two_factor_expires_at' => now()->addMinutes(10)
            ]);

            // Enviar email
            Mail::raw("Tu código secreto de acceso a Screenbites es: $code\n\nCaduca en 10 minutos.", function ($message) use ($user) {
                $message->to($user->email)->subject('Código de Seguridad - Screenbites');
            });

            // Guardar ID y mandar a la pantalla del código
            session(['2fa_user_id' => $user->id]);
            return redirect()->route('2fa.form');
        }

        return back()->withErrors(['email' => 'El correo o la contraseña no son correctos.']);
    }

    // ==========================================
    // 2. LÓGICA DE REGISTRO
    // ==========================================
    public function showRegister() { 
        return view('auth.register'); 
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'avatar' => 'required|string'
        ]);

        // 1. Creamos al usuario en la base de datos
        $user = User::create([
            'name' => $request->name, 
            'email' => $request->email,
            'password' => Hash::make($request->password), 
            'avatar' => $request->avatar,
        ]);

        // 2. Generamos el código 2FA INMEDIATAMENTE después de registrarse
        $code = rand(100000, 999999);
        $user->update([
            'two_factor_code' => $code,
            'two_factor_expires_at' => now()->addMinutes(10)
        ]);

        // 3. Le mandamos el correo de bienvenida y verificación
        Mail::raw("¡Bienvenido a Screenbites, $user->name!\n\nTu código secreto de acceso es: $code\n\nCaduca en 10 minutos.", function ($message) use ($user) {
            $message->to($user->email)->subject('Bienvenido - Código de Seguridad');
        });

        // 4. Guardamos su ID y lo mandamos directo a la pantalla de poner el código
        session(['2fa_user_id' => $user->id]);
        return redirect()->route('2fa.form');
    }


    // ==========================================
    // 3. PANTALLA Y COMPROBACIÓN DEL CÓDIGO (2FA)
    // ==========================================
    public function show2faForm() {
        // Si intenta entrar aquí sin haberse logueado o registrado, lo echamos
        if (!session('2fa_user_id')) return redirect('/login');
        
        return view('auth.2fa');
    }

    public function verify2fa(Request $request) {
        $request->validate(['code' => 'required|numeric']);
        
        $user = User::find(session('2fa_user_id'));

        // Si el código es correcto y no ha caducado
        if ($user && $user->two_factor_code == $request->code && now()->lessThan($user->two_factor_expires_at)) {
            
            // Borramos el código de la base de datos por seguridad
            $user->update(['two_factor_code' => null, 'two_factor_expires_at' => null]);
            
            // ¡LO LOGUEAMOS OFICIALMENTE!
            Auth::login($user);
            session()->forget('2fa_user_id');
            
            // Lo mandamos a la portada ya como usuario validado
            return redirect('/');
        }

        return back()->withErrors(['code' => 'El código es incorrecto o ha caducado.']);
    }

    // ==========================================
    // 4. CERRAR SESIÓN
    // ==========================================
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}