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

Route::prefix('/games/{game}')
    ->group(
        function () {
            Route::resource('/levels', LevelController::class)
                ->parameter('level', 'level:id')
                ->except(['index']);

            Route::prefix('/levels/{level}')
                ->group(
                    function () {
                        Route::resource('/statuses', StatusController::class)
                            ->parameter('status', 'status:id')
                            ->except(['index']);

                        Route::prefix('/statuses/{status}')
                            ->group(
                                function () {
                                    Route::resource('/activities', ActivityController::class)
                                        ->parameter('activity', 'activity:id')
                                        ->except(['index', 'create', 'show']);

                                    Route::put('/activities/{activity:id}/stop', [ActivityController::class, 'stop'])
                                        ->name('activities.stop');
                                }
                            );
                    }
                );
        }
    );
