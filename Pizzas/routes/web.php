<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PizzaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('mainp');

Route::view('/login', 'login')->name('login');

Route::view('/register', 'register')->name('register');
Route::view('/nosotros', 'nosotros')->name('nosotros');
Route::view('/contacto', 'contacto')->name('contacto');



Route::post('/validar-registro', [LoginController::class, 'register'])->name('validar-registro');
Route::post('/inicia-sesion', [LoginController::class, 'login'])->name('inicia-sesion');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    // Ruta para la página de pizzas (ver todas las pizzas)
    Route::get('/pizzas', [PizzaController::class, 'index'])->name('pizzas.index');
    
    // Ruta para agregar una pizza
    Route::post('/pizzas', [PizzaController::class, 'store'])->name('pizzas.store');
    
    // Ruta para eliminar una pizza
    Route::delete('/pizzas/{pizza}', [PizzaController::class, 'destroy'])->name('pizzas.destroy');
    
    // Ruta para actualizar una pizza
    Route::put('/pizzas/{pizza}', [PizzaController::class, 'update'])->name('pizzas.update');

    
});


