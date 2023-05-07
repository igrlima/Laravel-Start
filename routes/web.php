<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasswordController;

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

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['middleware' => ['guest']], function() {
    /**
     * Login Routes
     */

    Route::get('/login', [LoginController::class, 'show'])->name('login.show');
    Route::post('/login', [LoginController::class, 'login'])->name('login');

});

Route::group(['middleware' => ['auth']], function() {
    /**
     * Logout Routes
     */
    Route::post('/logout', [LogoutController::class, 'perform'])->name('logout');
});

Route::controller(UsersController::class)->group(function () 
{
    Route::group(['middleware' => ['permission:users']], function () {
        Route::get('/users', 'index')->name('users');
        Route::get('/users/destroy', 'destroy')->name('users.destroy')->middleware(['permission:users.destroy']);
        Route::any('/users/edit', 'edit')->name('users.edit')->middleware(['permission:users.edit']);
        Route::any('/users/create', 'create')->name('users.create')->middleware(['permission:users.create']);
    });
});

Route::group(['middleware' => ['permission:roles']], function () {
    Route::controller(RolesController::class)->group(function () 
    {
        Route::get('/roles', 'index')->name('roles');
        Route::any('/roles/create', 'create')->name('roles.create')->middleware(['permission:roles.create']);
        Route::any('/roles/edit', 'edit')->name('roles.edit')->middleware(['permission:roles.edit']);
    }
    );
});

Route::controller(PasswordController::class)->group(function () 
{
    Route::get('/password', 'index')->name('password');
    Route::post('/password', 'update')->name('password.upd');
});

// require __DIR__.'/auth.php';
