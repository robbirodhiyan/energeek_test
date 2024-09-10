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
Route::post('/todo', [IndexController::class, 'store'])->name('todo.store'); // Menyimpan user dan tugas baru
Route::put('/todo/{id}', [IndexController::class, 'update'])->name('todo.update'); // Memperbarui tugas
Route::delete('/todo/{id}', [IndexController::class, 'destroy'])->name('todo.destroy'); // Menghapus tugas
