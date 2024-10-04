<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskUserController;
use App\Http\Controllers\NotificationController;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('tasks', TaskController::class);
    Route::apiResource('task_user', TaskUserController::class);
    Route::apiResource('notifications', NotificationController::class);
});