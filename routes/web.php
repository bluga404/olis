<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

Route::get('/', [BookController::class, 'index'])->name('books.index');

Route::post('/borrow', [BookController::class, 'borrow'])->name('books.borrow');

Route::post('/return/{loan}', [BookController::class, 'return'])->name('books.return');

