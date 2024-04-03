<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\DashboardController;

Route::get('/dasboard',[DashboardController::class, 'index'])->name('admin.dashboard');
Route::get('/changeStatus',[DashboardController::class, 'changeStatus'])->name('admin.changeStatus');
Route::get('/changeStatusAll',[DashboardController::class, 'changeStatusAll'])->name('admin.changeStatusAll');

Route::get('/logout',[AuthController::class, 'logout'])->name('auth.logout');
foreach (glob(__DIR__. '/backend/*.php') as $router_files){
    Route::prefix(pathinfo($router_files)['filename'])->group("$router_files");
}