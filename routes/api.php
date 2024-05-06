<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;


Route::prefix('auth')->group(function () {
    Route::post('/login', LoginController::class);
    Route::post('/logout', LogoutController::class)->middleware('auth:sanctum');
});
Route::middleware('auth:sanctum')->post('/register', 'App\Http\Controllers\Api\UserController@register');
// Route::post('/login', 'App\Http\Controllers\AuthController@login');
// Route::get('/login', 'AuthController@login')->name('auth.login');
// Route::post('/login', 'App\Http\Controllers\AuthController@login')->name('auth.login');
// Route::get('/login', 'App\Http\Controllers\AuthController@login')->name('your.login.route');
// Route::post('/register', 'App\Http\Controllers\AuthController@register');
// Route::middleware('auth:sanctum')->post('/logout', 'App\Http\Controllers\AuthController@logout');
Route::middleware('auth:sanctum')->apiResource('/users', 'App\Http\Controllers\Api\UserController');
Route::middleware('auth:sanctum')->put('/users/current/{id}', 'App\Http\Controllers\Api\UserController@updateCurrentUser');
Route::middleware('auth:sanctum')->apiResource('/groups', 'App\Http\Controllers\Api\GroupController');
Route::middleware('auth:sanctum')->apiResource('/roles', 'App\Http\Controllers\Api\RoleController');
Route::middleware('auth:sanctum')->apiResource('/countries', 'App\Http\Controllers\Api\CountryController');
Route::middleware('auth:sanctum')->apiResource('/flight_tickets', 'App\Http\Controllers\Api\FlightTicketController');
Route::middleware('auth:sanctum')->apiResource('/tours', 'App\Http\Controllers\Api\TourController');
Route::middleware('auth:sanctum')->get('/tours/{tour}/report', 'App\Http\Controllers\Api\TourController@report');
Route::middleware('auth:sanctum')->post('/tours/{id}/duplicate', 'App\Http\Controllers\Api\TourController@duplicate');
Route::middleware('auth:sanctum')->apiResource('/bookings', 'App\Http\Controllers\Api\BookingController');
// Route::apiResource('/bookings', 'App\Http\Controllers\Api\BookingController');
Route::middleware('auth:sanctum')->apiResource('/passengers', 'App\Http\Controllers\Api\PassengerController');
Route::post('/send-message', 'App\Http\Controllers\Api\MessageController@sendMessage');
Route::middleware('auth:sanctum')->apiResource('/permissions', 'App\Http\Controllers\Api\PermissionController');

// Anton working Reminder Controller
Route::middleware('auth:sanctum')->apiResource('/reminders', 'App\Http\Controllers\Api\ReminderController');

