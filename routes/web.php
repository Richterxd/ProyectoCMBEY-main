<?php

use App\Livewire\Auth\LoginForm;
use App\Livewire\Auth\RegisterForm;
use App\Livewire\Dashboard\UsuarioDashboard;
use App\Livewire\Dashboard\AdministradorDashboard;
use App\Livewire\Dashboard\SuperAdminDashboard;
use App\Livewire\Dashboard\SolicitudCompleta;
use App\Livewire\Dashboard\SuperAdminReportes;
use App\Livewire\Dashboard\SuperAdminSolicitudes;
use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard\SuperAdminTrabajadores;
use App\Livewire\Dashboard\SuperadminUsuarios;
use App\Livewire\Dashboard\SuperAdminVisitas;
use App\Livewire\Dashboard\SuperAdminReuniones;
// IMPORTACIÓN AÑADIDA: Necesaria si el controlador no se referencia con el namespace completo
use App\Http\Controllers\ReunionController; 

Route::get('/', function () {
    return redirect(route('login'));
});

Route::match(['get', 'post'], '/login', LoginForm::class)->name('login')->middleware('guest');

Route::match(['get', 'post'], '/registro', RegisterForm::class)->name('registro')->middleware('guest');

Route::match(['get', 'post'], '/recuperar-contraseña', \App\Livewire\Auth\PasswordRecoveryForm::class)->name('password.recovery')->middleware('guest');

Route::get('/home', function () {
    return view('users.clientVista');
})->name('clientHome');

Route::get('/Agente', function () {
    return view('users.añadirAgente');
})->name('agente');

//RUTAS DEL SIDEBAR
Route::middleware('auth')->group(function () {
    // Logout route
    Route::post('/logout', function () {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    })->name('logout');

    // Dashboard redirect based on role
    Route::get('/dashboard', function () {
        $user = auth()->user();

        switch ($user->role) {
            case 1: // SuperAdministrador
                return redirect()->route('dashboard.superadmin');
            case 2: // Administrador
                return redirect()->route('dashboard.admin');
            case 3: // Usuario
                return redirect()->route('dashboard.usuario');
            default:
                return redirect()->route('login');
        }
    })->name('dashboard');

    // Role-specific dashboard routes

    // Gestión de Reuniones usando Livewire (Administrador y SuperAdministrador)
    Route::match(['get', 'post'], '/dashboard/reuniones', SuperAdminReuniones::class)
        ->name('dashboard.reuniones.index')
        ->middleware('role:1,2'); // URI: /dashboard/reuniones - RUTA PRINCIPAL CON LIVEWIRE
    
    // Mantener solo la ruta de PDF del controlador original
    Route::get('/dashboard/reuniones/{reunion}/pdf', [ReunionController::class, 'generatePDF'])
        ->name('dashboard.reuniones.pdf')
        ->middleware('role:1,2'); // URI: /dashboard/reuniones/{reunion}/pdf - RUTA DE PDF

    //usuario routes

    Route::get('/dashboard/usuario', UsuarioDashboard::class)
        ->name('dashboard.usuario')
        ->middleware('role:3');

    Route::get('/dashboard/usuario/solicitud/crear', SolicitudCompleta::class)
        ->name('dashboard.usuario.solicitud.crear')
        ->middleware('role:3');

    Route::get('/dashboard/usuario/solicitud', SolicitudCompleta::class)
        ->name('dashboard.usuario.solicitud')
        ->middleware('role:3');


    //administrador routes

    Route::get('/dashboard/administrador', AdministradorDashboard::class)
        ->name('dashboard.admin')
        ->middleware('role:2');

    //superdmin routes

    Route::get('/dashboard/superadmin', SuperAdminDashboard::class)
        ->name('dashboard.superadmin')
        ->middleware('role:1');


    Route::get('/dashboard/superadmin/visitas', SuperAdminVisitas::class)
        ->name('dashboard.superadmin.visitas')
        ->middleware('role:1');

    Route::get('dashboard/superadmin/trabajadores', SuperAdminTrabajadores::class)
        ->name('dashboard.superadmin.trabajadores')
        ->middleware('role:1');

    Route::get('/dashboard/superadmin/usuarios', SuperadminUsuarios::class)
        ->name('dashboard.superadmin.usuarios')
        ->middleware('role:1');

    Route::get('/dashboard/superadmin/reportes', SuperAdminReportes::class)
        ->name('dashboard.superadmin.reportes')
        ->middleware('role:1,2');


    Route::get('/dashboard/superadmin/solicitudes', SuperAdminSolicitudes::class)
        ->name('dashboard.superadmin.solicitudes')
        ->middleware('role:1');
});
