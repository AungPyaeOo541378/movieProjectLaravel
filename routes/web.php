<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;

// for user 
Route::redirect('/', '/user/userShowMainPage');
Route::get('/change-language/{lang}', [MovieController::class, 'changeLanguage'])->name('changeLanguage');
Route::get('/user/userShowMainPage', [MovieController::class, 'userShowMainPage'])->name('userShowMainPage');
Route::get('/user/userDetails/{id}', [MovieController::class, 'userShowDetails'])->name('userShowDetails');
Route::get('search', [MovieController::class, 'search'])->name('search');

//for admin
Route::get('/admin/movie', [MovieController::class, 'movieList'])->name('adminMovieList');
Route::post('createMovie', [MovieController::class, 'createMovie'])->name('createMovie');
Route::get('deleteMovie/{id}', [MovieController::class, 'deleteMovie'])->name('deleteMovie');
Route::get('details/{id}', [MovieController::class, 'details'])->name('details');
Route::get('updatePage/{id}', [MovieController::class, 'updatePage'])->name('updatePage');
Route::post('update', [MovieController::class, 'update'])->name('update');


