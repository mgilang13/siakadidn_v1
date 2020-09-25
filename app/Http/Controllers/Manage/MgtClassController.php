<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Model\Manage\MgtClass;
use App\Model\Manage\MgtClassDetail;

use App\Model\Ref\RefClassroom;
use App\Model\Ref\RefStudent;
use App\Model\Ref\RefSchoolYear;
use App\Model\Ref\RefLevel;
use App\Model\Ref\RefLevelDetail;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MgtClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $qLevel = $request->query('id_level');
        $qLevelDt = $request->query('id_level_detail');

        $mgtClassDetail = null;
        
        $managedClasses = DB::table('mgt_classes as mc')
                            ->join('school_years as sch', 'sch.id', '=', 'mc.id_schoolyear')
                            ->join('classrooms as c', 'c.id', '=', 'mc.id_class')
                            ->join('users as u', 'u.id', '=', 'mc.id_teacher' )
                            ->join('teachers as t', 't.id_teacher', '=', 'mc.id_teacher')
                            ->where('c.id_level', 'like', '%'.$qLevel.'%')
                            ->where('c.id_level_detail', 'like', '%'.$qLevelDt.'%')
                            ->select('mc.id as idMC', 'c.name as className', 'c.*', 'u.name as teacherName', 't.*', 'sch.name as schyearName')
                            ->get();

        $levels = RefLevel::all();
        $level_details = RefLevelDetail::all();

        $classrooms = DB::table('classrooms as c')
                            ->where('c.id_level', 'like', '%'.$qLevel.'%')
                            ->where('c.id_level_detail', 'like', '%'.$qLevelDt.'%')
                            ->get();

        // $teachers = DB::table('users')
        //             ->join('teachers', 'users.id', '=', 'teachers.id_teacher')
        // 
                    // ->get();
        $teachers = DB::select('select * from teachersView');

        $schoolyears = RefSchoolYear::all();
        $activeSchoolYear = DB::table('school_years')->where('status', '1')->get()->first();

        return view('manage.class.index', compact('qLevel', 'qLevelDt', 'levels', 'level_details', 'schoolyears', 'managedClasses', 'classrooms', 'teachers', 'activeSchoolYear', 'mgtClassDetail'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'id_class' => 'required',
            'id_teacher' => 'required',
            'id_schoolyear' => 'required'
        ]);

        MgtClass::create($validateData);
        return redirect()->route('manage.class.index')->with('success', 'Atur Kelas Sukses');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $qLevel = $request->query('id_level');
        $qLevelDt = $request->query('id_level_detail');

        $mgtClassDetail = DB::table('mgt_class_details as mcd')
                                ->join('users as u', 'u.id', '=', 'mcd.id_student')
                                ->where('id_mgt_class', $id)
                                ->get();

        $managedClasses = DB::table('mgt_classes as mc')
                            ->join('school_years as sch', 'sch.id', '=', 'mc.id_schoolyear')
                            ->join('classrooms as c', 'c.id', '=', 'mc.id_class')
                            ->join('users as u', 'u.id', '=', 'mc.id_teacher' )
                            ->join('teachers as t', 't.id_teacher', '=', 'mc.id_teacher')
                            ->where('c.id_level', 'like', '%'.$qLevel.'%')
                            ->where('c.id_level_detail', 'like', '%'.$qLevelDt.'%')
                            ->select('mc.id as idMC', 'c.name as className', 'u.name as teacherName', 't.*', 'sch.name as schyearName')
                            ->get();

        $class = DB::table('mgt_classes as mc')
                        ->join('classrooms as c', 'c.id', '=', 'mc.id_class')
                        ->where('mc.id', $id)
                        ->select('mc.id as idMC', 'c.id as idClass', 'c.name as className')
                        ->get()
                        ->first();
        $levels = RefLevel::all();
        $level_details = RefLevelDetail::all();

        $schoolyears = RefSchoolYear::all();

        $classrooms = RefClassroom::all();
        // $teachers = DB::table('users')
        //             ->join('teachers', 'users.id', '=', 'teachers.id_teacher') 
        //             ->get();
        $teachers = DB::select('select * from teachersView');

        $activeSchoolYear = DB::table('school_years')->where('status', '1')->get()->first();
        
        return view('manage.class.index', compact('qLevel', 'qLevelDt','levels', 'level_details', 'schoolyears', 'managedClasses', 'classrooms', 'teachers', 'activeSchoolYear', 'mgtClassDetail', 'class'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(MgtClass $class)
    {
        $classrooms = RefClassroom::all();
        $teachers = DB::table('users')
                    ->join('teachers', 'users.id', '=', 'teachers.id_teacher')
                    ->get();

        return view('manage.class.edit', compact('class', 'classrooms', 'teachers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MgtClass $class)
    {
        $validateData = $request->validate([
            'id_class' => 'required',
            'id_teacher' => 'required',
        ]);

        $class->update($validateData);
        return redirect()->route('manage.class.index')->with('success', 'Ubah Data Guru Sukses');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(MgtClass $class)
    {
        $class->delete();
        $class_detail = MgtClassDetail::where('id_mgt_class', $class->id);
        $class_detail->delete();
        
        return redirect()->route('manage.class.index')->with('success', 'Hapus Data Sukses');
    }

    public function showJson($id)
    {
        $mgtclass = MgtClass::findOrFail($id);
        return $mgtclass->toJson();
    }

    // Management of Ruang Kelas
    public function addStudent($id)
    {
        $students = DB::table('users as u')
                        ->join('students as s', 's.id_student', '=', 'u.id')
                        ->leftJoin('mgt_class_details as mcd', 'mcd.id_student', 's.id_student')
                        ->where('mcd.id_mgt_class', null)
                        ->get();
        
        return view('manage.class.add-student', compact('students', 'id'));
    }

    public function addStudentStore(Request $request)
    {
        $id_students = $request->input('id_student');
        $id_mgt_class = $request->input('id_mgt_class');
        
        if($id_students != null){
            foreach($id_students as $id_student) {
                MgtClassDetail::create([
                    'id_mgt_class' => $id_mgt_class,
                    'id_student' => $id_student,
                    'status' => 1
                ]);
            }
        }
        return redirect()->route('manage.class.show', $id_mgt_class);
    }
}
