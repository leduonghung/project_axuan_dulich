<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\DashboardController;

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
    return view('welcome');
});
Route::prefix('admin')->middleware(['admin','locale']) ->group(base_path('routes/backendRoutes.php'));

Route::prefix('admin')->group(function(){
    Route::get('/',[AuthController::class, 'index'])->name('auth.admin')->middleware('login');
    Route::post('/',[AuthController::class, 'login'])->name('auth.login');
});
