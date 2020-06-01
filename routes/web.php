<?php

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

Auth::routes([
    'register' => false,
    'reset' => false,
    'confirm' => false,
    'verify' => false,
]);

Route::get('/', 'HomeController@index')->name('home');
Route::get('/{year}/{week}', 'HomeController@week')->name('week')->where(['year' => '\d{4}', 'week' => '\d+']);

Route::resource('/games', 'GameController');
