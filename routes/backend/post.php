<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\PostController;
use App\Http\Controllers\Backend\PostCatalogueController;

Route::controller(PostController::class)->name('admin.post')->group(function () {
    Route::get('/', 'index');
    Route::get('/create', 'create')->name('.create');
    Route::post('/store', 'store')->name('.store');
    Route::get('/edit/{id}', 'edit')->name('.edit')->where('id', '[0-9]+');
    Route::post('/update/{id}', 'update')->name('.update')->where('id', '[0-9]+');
    Route::delete('/delete/{id}', 'destroy')->name('.delete')->where('id', '[0-9]+');
    Route::get('loadAjax', 'loadAjax')->name('.loadAjax')->where('id', '[0-9]+');
});

Route::controller(PostCatalogueController::class)->prefix('catalogue')->name('admin.post.catalogue')->group(function () {
    Route::get('/', 'index');
    Route::get('/create', 'create')->name('.create');
    Route::post('/store', 'store')->name('.store');
    Route::get('/edit/{id}', 'edit')->name('.edit')->where('id', '[0-9]+');
    Route::post('/update/{id}', 'update')->name('.update')->where('id', '[0-9]+');
    Route::delete('/delete/{id}', 'destroy')->name('.delete')->where('id', '[0-9]+');
    Route::get('loadAjax', 'loadAjax')->name('.loadAjax')->where('id', '[0-9]+');
});