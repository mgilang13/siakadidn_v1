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
    Route::name('tahfidz.')->prefix('/tahfidz')->group(function () {
        Route::get('halaqah/{id}', 'TahfidzController@halaqah')->name('halaqah');
        // Route::get('report.parent/{id}', 'TahfidzController@reportParent')->name('report.parent');
        Route::get('list-halaqah', 'TahfidzController@listHalaqah')->name('list-halaqah');
        Route::get('list-santri', 'TahfidzController@listSantri')->name('list-santri');
        Route::get('add-notes/{id}', 'TahfidzController@addNotes')->name('add-notes');
        Route::get('show-member/{halaqah}', 'TahfidzController@showMember')->name('show-member');
        Route::get('report-murid/{id}', 'TahfidzController@reportMurid')->name('report-murid');
        Route::get('show-json/{id}', 'TahfidzController@showJson')->name('show-json');
        
        Route::name('report.')->prefix('/report')->group(function() {
            Route::get('parent/{id}', 'TahfidzController@reportParent')->name('parent');
            Route::get('smp', 'TahfidzController@reportKepalaTahfidzSMP')->name('smp');
            Route::get('smk', 'TahfidzController@reportKepalaTahfidzSMK')->name('smk');
            Route::get('foundation', 'TahfidzController@reportFoundation')->name('foundation');
        });
    });
    Route::resource('tahfidz', 'TahfidzController');

    // Ref Menu 
    Route::name('ref.')->prefix('/ref')->namespace('Ref')->group(function() {
        
        // Teacher Menu
        Route::name('teacher.')->prefix('/teacher')->group(function() {
            Route::get('show-json/{id}', 'RefTeacherController@showJson')->name('show-json');
        });
        Route::resource('teacher', 'RefTeacherController');

        // Orang tua / wali murid
        Route::name('parent.')->prefix('/parent')->group(function() {
            Route::get('show-json/{id}', 'RefParentsController@showJson')->name('show-json');
        });
        Route::resource('parent', 'RefParentsController');
        
        //Tahun ajaran
        Route::name('schoolyear.')->prefix('/schoolyear')->group(function() {
            Route::get('show-json/{id}', 'RefSchoolYearController@showJson')->name('show-json');
        });
        Route::resource('schoolyear', 'RefSchoolYearController');
        
        // Subject Menu
        Route::name('subject.')->prefix('/subject')->group(function() {
            Route::get('show-json/{id}', 'RefSubjectController@showJson')->name('show-json');
        });
        Route::resource('subject', 'RefSubjectController');

        Route::name('halaqah.')->prefix('/halaqah')->group(function() {
            Route::get('show/add/{halaqah}', 'RefHalaqahController@addMember')->name('show.add');
            Route::patch('show/add/process/{id}', 'RefHalaqahController@addMemberProcess')->name('show.add.process');
        });

        // Halaqah Menu
        Route::name('halaqah.')->prefix('/halaqah')->group(function() {
            Route::get('show-json/{id}', 'RefHalaqahController@showJson')->name('show-json');
        });
        Route::resource('halaqah', 'RefHalaqahController');

        // Student Menu
        Route::name('student.')->prefix('/student')->group(function() {
            Route::get('show-json/{id}', 'RefStudentController@showJson')->name('show-json');
        });
        Route::resource('student', 'RefStudentController');
    });

    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::patch('/profile', 'ProfileController@updateProcess')->name('profile.update.process');
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