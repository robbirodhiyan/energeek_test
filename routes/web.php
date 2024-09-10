<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [IndexController::class, 'index'])->name('todo.index'); // Menampilkan halaman to-do list
Route::post('/tasks', [IndexController::class, 'store'])->name('todo.store'); // Menyimpan user dan tugas baru
Route::put('/tasks/{id}', [IndexController::class, 'update'])->name('todo.update'); // Memperbarui tugas
Route::delete('/tasks/{id}', [IndexController::class, 'destroy'])->name('todo.destroy'); // Menghapus tugas
