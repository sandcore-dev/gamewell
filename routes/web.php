<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StatusController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'showLoginForm'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.attempt');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/{year}/{week}', [HomeController::class, 'week'])
    ->name('week')
    ->where(
        [
            'year' => '\d{4}',
            'week' => '\d+',
        ]
    );

Route::resource('/game', GameController::class);

Route::prefix('/game/{game}')
    ->group(
        function () {
            Route::resource('/level', LevelController::class)
                ->except(['index']);

            Route::prefix('/level/{level}')
                ->group(
                    function () {
                        Route::resource('/status', StatusController::class)
                            ->except(['index']);

                        Route::prefix('/status/{status}')
                            ->group(
                                function () {
                                    Route::resource('/activity', ActivityController::class)
                                        ->except(['index', 'create', 'show']);

                                    Route::patch('/activity/{activity}/stop', [ActivityController::class, 'stop'])
                                        ->name('activity.stop');
                                }
                            );
                    }
                );
        }
    );
