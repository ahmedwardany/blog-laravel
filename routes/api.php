<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SubscriberController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('register', [RegisterController::class, 'register']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/subscriber', [SubscriberController::class, 'getSubscriberData']);
    Route::post('/subscribers', [SubscriberController::class, 'create']); // Create a subscriber
    Route::put('/subscribers/{id}', [SubscriberController::class, 'update']); // Update a subscriber
    Route::delete('/subscribers/{id}', [SubscriberController::class, 'delete']); // Delete a subscriber
    Route::get('/subscribers', [SubscriberController::class, 'search']); // Search subscribers
    Route::get('/subscribers/{id}', [SubscriberController::class, 'show']);
    
    //  blogs
    Route::get('/blogs', [BlogController::class, 'index']);
    Route::get('/blogs/{id}', [BlogController::class, 'show']);
    Route::post('/blogs', [BlogController::class, 'store']);
    Route::post('/blogs/{id}', [BlogController::class, 'update']);
    Route::delete('/blogs/{id}', [BlogController::class, 'destroy']);
});
