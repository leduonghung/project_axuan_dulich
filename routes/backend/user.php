<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\UserController;

// Route::get('/',[UserController::class, 'index'])->name('admin.user');
// Route::get('/create',[UserController::class, 'create'])->name('admin.user.create');
// Route::post('/store',[UserController::class, 'store'])->name('admin.user.store');
// Route::post('/update/{id}',[UserController::class, 'update'])->name('admin.user.update')->where('id', '[0-9]+');
// Route::post('/destroy/{id}',[UserController::class, 'destroy'])->name('admin.user.destroy')->where('id', '[0-9]+');

Route::controller(UserController::class)->name('admin.user')->group(function () {
    Route::get('/', 'index');
    Route::get('/create', 'create')->name('.create');
    Route::post('/store', 'store')->name('.store');
    Route::get('/edit/{id}', 'edit')->name('.edit')->where('id', '[0-9]+');
    Route::post('/update/{id}', 'update')->name('.update')->where('id', '[0-9]+');
    Route::delete('/delete/{id}', 'destroy')->name('.delete')->where('id', '[0-9]+');
    Route::get('loadAjax', 'loadAjax')->name('.loadAjax')->where('id', '[0-9]+');
});