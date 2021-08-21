<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
Route::get('/set-language/{locale}', [LanguageController::class, 'setLocale']);

Route::post('/auth/{provider}', [UserController::class, 'socialSignUp']);
Route::get('/auth/{provider}/callback', [UserController::class, 'handleCallback'])->where('provider', '.*');

Route::get('/{view?}', [HomeController::class, 'index'])->where('view', '(.*)')->name('scaneroo.index');