<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;

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



Route::get('/tasks', [TaskController::class, 'index']);
Route::post('/tasks', [TaskController::class, 'store']);
Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);

Route::get('/categories', [CategoryController::class, 'index']);

Route::get('/users', [UserController::class, 'index']); // Get all users
Route::post('/users', [UserController::class, 'store']); // Create a new user
Route::get('/users/{id}', [UserController::class, 'show']); // Get user by id
Route::put('/users/{id}', [UserController::class, 'update']); // Update user by id
Route::delete('/users/{id}', [UserController::class, 'destroy']); // Delete user by id (soft delete)
