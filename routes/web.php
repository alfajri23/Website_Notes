<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route::get('/',function(){
//     return view ('welcome');
// });

Route::get('/cek', function () {
    auth()->user()->assignRole('user');
    // if(auth()->user()->hasRole('user')){
    //     return 'berhasil';
    // }
});

Auth::routes();

Route::group(['middleware' => ['auth']], function(){
    //Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/',livewire\Notes::class);
    Route::get('/team/{id}',livewire\TeamNotes::class);
});

//Route::get('/kirim_email', [App\Http\Controllers\SendNotify::class, 'kirim']);
