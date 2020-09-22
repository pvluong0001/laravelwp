<?php

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

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false
]);

Route::group([
    'middleware' => 'auth',
    'prefix' => 'admin'
], function() {
    Route::get('home', [\App\Http\Controllers\Admin\CommonController::class, 'dashboard'])->name('home');

    Route::group([
        'prefix' => 'settings',
        'as' => 'settings.'
    ], function() {
        Route::get('menu', [\App\Http\Controllers\Admin\CommonController::class, 'menu'])->name('menu');

        Route::get('plugins', [\App\Http\Controllers\Admin\CommonController::class, 'plugins'])->name('plugins.index');
        Route::post('plugins', [\App\Http\Controllers\Admin\CommonController::class, 'createPlugin'])->name('plugins.create');
    });
});
