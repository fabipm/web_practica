<?php

use App\Http\Controllers\AtencionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReporteController;
use Illuminate\Support\Facades\Route;

// Página de inicio - redirige al login
Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas de autenticación
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('validate.upt.email');
Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [LoginController::class, 'register']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rutas protegidas (requieren autenticación)
Route::middleware(['auth.docente'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Gestión de Atenciones (CRUD completo)
    Route::resource('atenciones', AtencionController::class);
    
    // Reportes
    Route::prefix('reportes')->name('reportes.')->group(function () {
        Route::get('/', [ReporteController::class, 'index'])->name('index');
        Route::get('/semestre', [ReporteController::class, 'porSemestre'])->name('semestre');
        Route::get('/docente', [ReporteController::class, 'porDocente'])->name('docente');
        Route::get('/tema', [ReporteController::class, 'porTema'])->name('tema');
        Route::get('/detallado', [ReporteController::class, 'detallado'])->name('detallado');
    });
});
