<?php

use App\Http\Controllers\TemplateFormularioController;
use Illuminate\Support\Facades\Route;

Route::controller(TemplateFormularioController::class)->name('templates.')->prefix('/templates')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/{tipo}', 'tipo')->name('tipo');
    Route::get('/{tipo}/novo', 'create')->name('create');
    Route::post('/{tipo}', 'store')->name('store');
    Route::get('/{templateFormulario}/editar', 'edit')->name('edit');
    Route::patch('/{templateFormulario}', 'update')->name('update');
    Route::delete('/{templateFormulario}', 'destroy')->name('destroy');
});
