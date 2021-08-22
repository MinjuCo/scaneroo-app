<?php

use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ObjectController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

Route::get('/languages/{type}', [LanguageController::class, 'index']);
Route::get('/check-username/{username}', [UserController::class, 'checkUsername']);
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/object/detect-labels', [ObjectController::class, 'scanObject']);
Route::post('/user/update/{id}', [UserController::class, 'update']);
Route::get('/user/badges/{id}', [UserController::class, 'getBadges']);
