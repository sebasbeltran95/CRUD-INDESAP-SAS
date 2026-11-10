<?php

use App\Livewire\Jornada;
use App\Livewire\Trabajador;
use App\Livewire\Usuarios;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/',function(){ return redirect('login'); });


Auth::routes();
// Auth::routes(['register' => false]);


// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function (){
    Route::get('/trabajador', Trabajador::class)->name('trabajador');
    Route::get('/usuarios', Usuarios::class)->name('usuarios');
    Route::get('/jornada', Jornada::class)->name('jornada');
});