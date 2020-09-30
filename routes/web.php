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

    // Journal Menu
    Route::name('journal.')->prefix('/journal')->group(function () {
        
        Route::get('report/absensi-class', 'JournalController@reportAbsensiClass')->name('report.absensi-class');
        Route::get('report/feedback-class', 'JournalController@reportFeedbackClass')->name('report.feedback-class');
        
        Route::post('report/feedback-treat/{student}', 'JournalController@feedbackTreat')->name('report.feedback-treat');
        
        Route::get('report/absensi-student/{student}', 'JournalController@reportAbsensiStudent')->name('report.absensi-student');
        Route::get('report/feedback-student/{student}', 'JournalController@reportFeedbackStudent')->name('report.feedback-student');
        
        Route::get('sub/list/{id}', 'JournalController@listSubMatter')->name('list-submatter');
        Route::get('list/{id}', 'JournalController@listMatter')->name('list-matter');
        Route::get('teacher-schedule/{id}', 'JournalController@teacherSchedule')->name('teacher-schedule');
        Route::post('feedback/store', 'JournalController@feedbackStore')->name('feedback.store');
        Route::post('detail/response', 'JournalController@journalDetailResponse')->name('detail.response');
        Route::get('show-json/{id}', 'JournalController@showJson')->name('show-json');
    });
    Route::resource('journal', 'JournalController');
    
    // Tahfidz Menu 
    Route::name('tahfidz.')->prefix('/tahfidz')->group(function () {
        Route::get('check/{halaqah}', 'TahfidzController@tahfidzCheck')->name('check');
        Route::get('halaqah/{id}', 'TahfidzController@halaqah')->name('halaqah');
        // Route::get('report.parent/{id}', 'TahfidzController@reportParent')->name('report.parent');
        Route::get('list-halaqah', 'TahfidzController@listHalaqah')->name('list-halaqah');
        Route::get('list-santri', 'TahfidzController@listSantri')->name('list-santri');
        Route::get('add-notes/{id}', 'TahfidzController@addNotes')->name('add-notes');
        Route::get('show-member/{halaqah}', 'TahfidzController@showMember')->name('show-member');
        Route::get('report-murid/{id}', 'TahfidzController@reportMurid')->name('report-murid');
        Route::get('show-json/{id}', 'TahfidzController@showJson')->name('show-json');
        
        Route::post('print/{student}', 'TahfidzController@tahfidzPrint')->name('print');

        Route::name('report.')->prefix('/report')->group(function() {
            Route::get('parent/{id}', 'TahfidzController@reportParent')->name('parent');
            Route::get('smp', 'TahfidzController@reportKepalaTahfidzSMP')->name('smp');
            Route::get('smk', 'TahfidzController@reportKepalaTahfidzSMK')->name('smk');
            Route::get('foundation', 'TahfidzController@reportFoundation')->name('foundation');
        });
    });
    Route::resource('tahfidz', 'TahfidzController');

    // Management Menu
    Route::name('manage.')->prefix('/manage')->namespace('Manage')->group(function() {
        // Class Menu
        Route::name('class.')->prefix('/class')->group(function() {
            Route::get('show-json/{id}', 'MgtClassController@showJson')->name('show-json');
            Route::get('add-student/{idMC}', 'MgtClassController@addStudent')->name('add-student');
            Route::post('add-student/add', 'MgtClassController@addStudentStore')->name('add-student.process');
            Route::delete('detail/destroy/{id}', 'MgtClassController@detailDestroy')->name('detail.destroy');
        });
        Route::resource('class', 'MgtClassController');

        // Teacher Menu
        Route::name('teacher.')->prefix('/manage')->group(function() {
            Route::get('show-json/{id}', 'MgtTeacherController@showJson')->name('show-json');
            Route::get('add-class/{id}', 'MgtTeacherController@addClass')->name('add-class');
            Route::post('add-class/add', 'MgtTeacherController@addClassStore')->name('add-class.process');
            Route::get('add-matter/{id}', 'MgtTeacherController@addMatter')->name('add-matter');
            Route::post('add-matter/add', 'MgtTeacherController@addMatterStore')->name('add-matter.process');
        });
        Route::resource('teacher', 'MgtTeacherController');

        // Schedule
        Route::name('schedule.')->prefix('/schedule')->group(function() {
            Route::post('level/response', 'MgtScheduleController@levelResponse')->name('level.response');
            Route::post('grade/response', 'MgtScheduleController@gradeResponse')->name('grade.response');
            Route::post('class/response', 'MgtScheduleController@classResponse')->name('class.response');
            Route::post('subject/byteacher', 'MgtScheduleController@subjectByTeacher')->name('subject.byteacher');
            Route::get('show-json/{id}', 'MgtScheduleController@showJson')->name('show-json');
        });
        Route::resource('schedule', 'MgtScheduleController');
    });

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

        //Tahun ajaran
        Route::name('semester.')->prefix('/semester')->group(function() {
            Route::get('show-json/{id}', 'RefSemesterController@showJson')->name('show-json');
        });
        Route::resource('semester', 'RefSemesterController');
        
        // Matter Menu
        Route::name('matter.')->prefix('/matter')->group(function() {
            Route::get('show-json/{id}', 'RefMatterController@showJson')->name('show-json');
            Route::post('sub/store/', 'RefMatterController@matterSubStore')->name('sub.store');
        });
        Route::resource('matter', 'RefMatterController');
        
        // Subject Menu
        Route::name('subject.')->prefix('/subject')->group(function() {
            Route::get('show-json/{id}', 'RefSubjectController@showJson')->name('show-json');
        });
        Route::resource('subject', 'RefSubjectController');

        // Halaqah Menu
        Route::name('halaqah.')->prefix('/halaqah')->group(function() {
            Route::get('show-json/{id}', 'RefHalaqahController@showJson')->name('show-json');
            Route::get('show/add/{halaqah}', 'RefHalaqahController@addMember')->name('show.add');
            Route::patch('show/add/process/{id}', 'RefHalaqahController@addMemberProcess')->name('show.add.process');
        });
        Route::resource('halaqah', 'RefHalaqahController');

        // Student Menu
        Route::name('student.')->prefix('/student')->group(function() {
            Route::get('show-json/{id}', 'RefStudentController@showJson')->name('show-json');
        });
        Route::resource('student', 'RefStudentController');

        // Classroom
        Route::name('classroom.')->prefix('/classroom')->group(function() {
            Route::get('show-json/{id}', 'RefClassroomController@showJson')->name('show-json');
        });
        Route::resource('classroom', 'RefClassroomController');
        
        // Level
        Route::name('level.')->prefix('/level')->group(function() {
            Route::post('detail', 'RefLevelController@levelDetailStore')->name('detail.store');
            Route::get('detail/{level_detail}/edit', 'RefLevelController@levelDetailEdit')->name('detail.edit');
            Route::patch('detail/{level_detail}', 'RefLevelController@levelDetailUpdate')->name('detail.update');
            Route::delete('detail/{level_detail}/destroy', 'RefLevelController@levelDetailDestroy')->name('detail.destroy');
            Route::get('show-json/{id}', 'RefLevelController@showJson')->name('show-json');
            Route::get('detail/show-json/{id}', 'RefLevelController@detailShowJson')->name('detail.show-json');
        });
        Route::resource('level', 'RefLevelController');

        // Study Time
        Route::name('studytime.')->prefix('/studytime')->group(function() {
            Route::get('show-json/{id}', 'RefStudyTimeController@showJson')->name('show-json');
        });
        Route::resource('studytime', 'RefStudyTimeController');

        // Days
        Route::name('day.')->prefix('/day')->group(function() {
            Route::get('show-json/{id}', 'RefDayController@showJson')->name('show-json');
        });
        Route::resource('day', 'RefDayController');
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