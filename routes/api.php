<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\DatabaseTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [AuthController::class, 'login']);

Route::post('users/{user}/watch', [UserController::class, 'watch'])
    ->middleware(['auth:sanctum', DatabaseTransaction::class])
    ->can('manage', 'user');

Route::post('users/{user}/comment', [UserController::class, 'comment'])
    ->middleware(['auth:sanctum', DatabaseTransaction::class])
    ->can('manage', 'user');

Route::get('users/{user}/achievements', [UserController::class, 'achievements'])
    ->middleware('auth:sanctum')
    ->can('manage', 'user');
