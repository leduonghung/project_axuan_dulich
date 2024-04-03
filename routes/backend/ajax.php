<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Ajax\LocationController;


Route::get('/location/index',[LocationController::class, 'getLocation'])->name('ajax.location.index');
// Route::post('/user/delete/{id}',[UserController::class, 'destroy'])->name('ajax.user.deleteUser');