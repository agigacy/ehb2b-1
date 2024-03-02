<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
// use App\Http\Controllers\Auth\LoginController;
// use App\Http\Controllers\Auth\LogoutController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '^(?!api).*$');

// Route::get('/{any}', function () {
//     return view('welcome');
//     })->where('any', '.*');

// Route::get('/{any}', function () {
//     return view('welcome');
// })->where('any', '.*');
// Route::get('/{any}', function () {
//     return view('welcome');
// })->where('any', '^(?!api).*$');

// Route::get('/login', function () {
//     // 这里可以返回一个登录页面
// })->name('login');
// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::prefix('auth')->group(function () {
//     Route::post('/login', LoginController::class)->middleware('guest');
//     Route::post('/logout', LogoutController::class)->middleware('auth');
// });