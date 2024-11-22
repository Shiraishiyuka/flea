<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\FleaController;


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

Route::match(['get', 'post'], '/', [FleaController::class, 'home'])->name('home_route');

Route::get('/login', [LoginController::class, 'login'])->name('login.show');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::post('/mypage', [FleaController::class, 'mypage'])->name('mypage');


Route::get('/address', function () {
    return view('address');
});

Route::get('/sell', function () {
    return view('sell');
});