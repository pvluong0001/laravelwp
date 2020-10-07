<?php

Route::group(['prefix' => 'builder', 'middleware' => ['web', 'auth']], function() {
    Route::get('/', [\Lit\Core\Http\Controllers\BuilderController::class, 'index'])->name('builder.index');
    Route::get('/{table}', [\Lit\Core\Http\Controllers\BuilderController::class, 'table'])->name('builder.table');
    Route::post('/{table}', [\Lit\Core\Http\Controllers\BuilderController::class, 'store'])->name('builder.store');
});
