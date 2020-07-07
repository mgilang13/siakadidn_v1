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
Auth::routes(['register' => false]);

Route::get('/', function () {
    if (Auth::guard()->check()) {
        return redirect()->route('dashboard');
    } else {
        return view('auth.login');
    }
})->name('index');

Route::get('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');

Route::middleware(['auth', 'core'])->group(function () {

    // Tahfidz Menu 
    // Route::name('tahfidz.')->prefix('/tahfidz')->group(function () {

    // });
    Route::resource('tahfidz', 'TahfidzController');

    // Ref Menu 
    Route::name('ref.')->prefix('/ref')->namespace('Ref')->group(function() {
        Route::resource('teacher', 'RefTeacherController');
        Route::resource('subject', 'RefSubjectController');
    });

    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::put('/profile', 'ProfileController@updateProcess')->name('profile.update.process');
    Route::get('/template', 'TemplateController@index')->name('template');
    
    Route::name('core.')->prefix('/core')->namespace('Core')->group(function () {
        Route::get('menu', 'MenuController@index')->name('menu');
        Route::post('menu/add', 'MenuController@addProcess')->name('menu.add.process');
        Route::put('menu/edit/{routes}', 'MenuController@editProcess')->name('menu.edit.process');
        Route::delete('menu/delete/{routes}', 'MenuController@deleteProcess')->name('menu.delete.process');

        Route::get('roles', 'RolesController@index')->name('roles');
        Route::post('roles/add', 'RolesController@addProcess')->name('roles.add.process');
        Route::put('roles/edit/{roles}', 'RolesController@editProcess')->name('roles.edit.process');
        Route::delete('roles/delete/{roles}', 'RolesController@deleteProcess')->name('roles.delete.process');
        Route::get('roles/routes/{roles}', 'RolesController@routes')->name('roles.routes');
        Route::put('roles/routes/{roles}', 'RolesController@routesUpdateProcess')->name('roles.routes.update.process');

        Route::get('users', 'UsersController@index')->name('users');
        Route::get('users/add', 'UsersController@add')->name('users.add');
        Route::post('users/add', 'UsersController@addProcess')->name('users.add.process');
        Route::get('users/edit/{user}', 'UsersController@edit')->name('users.edit');
        Route::put('users/edit/{user}', 'UsersController@editProcess')->name('users.edit.process');
        Route::get('users/delete/{user}', 'UsersController@delete')->name('users.delete');
        Route::delete('users/delete/{user}', 'UsersController@deleteProcess')->name('users.delete.process');
    });
});