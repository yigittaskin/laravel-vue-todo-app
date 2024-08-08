<?php

use App\Http\Controllers\API\TodoController;

Route::apiResource('todos', TodoController::class);

