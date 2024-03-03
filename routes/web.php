<?php

use App\Http\Controllers\Auth\SetPasswordController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsersController;
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

Route::get('/', [IndexController::class, "index"])->name('index');

Route::get('/dashboard', [IndexController::class, "dashboard"])->middleware(['auth', 'verified'])->name('dashboard');

Route::controller(ProfileController::class)->middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::controller(SetPasswordController::class)->group(function () {
    Route::get('/confirm-password/{ulid}', 'show')->name('page.password');
    Route::post('/set-password', 'setPassword')->name('set.password');
});

Route::controller(UsersController::class)->middleware(['auth', 'verified'])->prefix("/users")->group(function () {
    Route::get("/", "index")->middleware('filterPagination')->name("users.index");
    Route::get("/create", "create")->name("users.create");
    Route::post("/store", "store")->name("users.store");
    Route::get("/edit/{id}", "edit")->name("users.edit");
    Route::post("/update", "update")->name("users.update");
    Route::get("/delete/{id}", "destroy")->name("users.delete");
});
