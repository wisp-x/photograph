<?php

use App\Http\Controllers\Admin\AlbumController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\PhotoController;
use App\Http\Controllers\IndexController;
use App\Http\Middleware\AdminAuthenticate;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [IndexController::class, 'index'])->name('home');
Route::get('photo/{id}/{hash}', [IndexController::class, 'photo'])->name('photo')->middleware('throttle:100,1');

Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'authenticate'])->middleware('throttle:30,1');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

Route::prefix('admin')->middleware(AdminAuthenticate::class)->group(function () {
    Route::get('', fn () => redirect(\route('dashboard')));
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::resource('albums', AlbumController::class);

    Route::post('photos/upload', [PhotoController::class, 'upload'])->name('photos.upload');
    Route::delete('photos/destroy', [PhotoController::class, 'destroy'])->name('photos.destroy');
});
