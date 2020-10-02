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
    'prefix' => 'admin',
    'namespace' => 'Admin'
], function() {
    Route::get('home', [\App\Http\Controllers\Admin\CommonController::class, 'dashboard'])->name('home');

    Route::group([
        'prefix' => 'settings',
        'as' => 'settings.'
    ], function() {
        Route::get('menu', [\App\Http\Controllers\Admin\CommonController::class, 'menu'])->name('menu');

        Route::get('plugins/active/{module:hash}', [\App\Http\Controllers\Admin\PluginController::class, 'active'])->name('plugins.active');
        Route::resource('plugins', 'PluginController');
    });

    Route::crud('user', \App\Http\Controllers\Admin\UserController::class);
});
