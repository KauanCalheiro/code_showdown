<?php

use App\Http\Controllers\UserController;

Route::post  ('/cookies', [UserController::class, 'store']);
Route::get   ('/cookies', [UserController::class, 'index']);