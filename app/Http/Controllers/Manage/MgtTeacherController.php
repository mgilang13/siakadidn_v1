<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;

use App\Model\Ref\RefTeacher;
use App\Model\Ref\RefLevel;
use App\Model\Ref\RefLevelDetail;
use App\Model\Ref\RefSchoolYear;

use App\Model\Manage\MgtTeacher;
use App\Model\Manage\MgtTeacherClass;
use App\Model\Manage\MgtTeacherMatter;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MgtTeacherController extends Controller
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

        $levels = RefLevel::all();
        $level_details = RefLevelDetail::all();

        // $teachers = DB::table('users as u')
        //                 ->join('teachers as t', 't.id_teacher', '=', 'u.id')
        //                 ->get();
        $teachers = DB::select('select * from teachersView');

        $managedTeachers = DB::table('mgt_teachers as mt')
                                ->join('users as u', 'u.id', '=', 'mt.id_teacher')
                                ->join('teachers as t', 't.id_teacher', '=', 'mt.id_teacher')
                                ->where('mt.id_level', 'like', '%'.$qLevel.'%')
                                ->where('mt.id_level_detail', 'like', '%'.$qLevelDt.'%')
                                ->select('mt.id as idMT', 'u.*', 't.*')
                                ->get();
       $mgtTeacherClass = null;

        return view('manage.teacher.index', compact('qLevel', 'qLevelDt','teachers', 'levels', 'level_details', 'managedTeachers', 'mgtTeacherClass'));
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
            'id_teacher' => 'required',
            'id_level' => '',
            'id_level_detail' => ''
        ]);

        MgtTeacher::create($validateData);
        return redirect()->route('manage.teacher.index')->with('Success', 'Tambah Manajemen Guru Sukses');
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

        $levels = RefLevel::all();
        $level_details = RefLevelDetail::all();

        // $teachers = DB::table('users as u')
        //                 ->join('teachers as t', 't.id_teacher', '=', 'u.id')
        //                 ->get();
        $teachers = DB::select('select * from teachersView');
                        
        $managedTeachers = DB::table('mgt_teachers as mt')
                                ->join('users as u', 'u.id', '=', 'mt.id_teacher')
                                ->join('teachers as t', 't.id_teacher', '=', 'mt.id_teacher')
                                ->where('mt.id_level', 'like', '%'.$qLevel.'%')
                                ->where('mt.id_level_detail', 'like', '%'.$qLevelDt.'%')
                                ->select('mt.id as idMT', 'u.*', 't.*')
                                ->get();
    
        $mgtTeacherClass = DB::table('mgt_teacher_classes as mtc')
                                ->join('classrooms as c', 'c.id', '=', 'mtc.id_class')
                                ->join('mgt_teachers as mt', 'mt.id', '=', 'mtc.id_mgt_teacher')
                                ->join('levels as l', 'l.id', '=', 'c.id_level')
                                ->join('level_details as ld', 'ld.id', '=', 'c.id_level_detail')
                                ->select('mtc.id_mgt_teacher as id', 'c.name as className', 'l.abbr as levelAbbr', 'ld.name as levelDetailName')
                                ->where('mtc.id_mgt_teacher', $id)
                                ->get();

        return view('manage.teacher.index', compact('id', 'qLevel', 'qLevelDt','teachers', 'levels', 'level_details', 'managedTeachers', 'mgtTeacherClass'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(MgtTeacher $teacher)
    {
        $teachers = DB::table('users as u')
                        ->join('teachers as t', 't.id_teacher', '=', 'u.id')
                        ->get();
        
        $levels = RefLevel::all();
        $level_details = RefLevelDetail::all();

        return view('manage.teacher.edit', compact('teachers', 'levels', 'level_details', 'teacher'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MgtTeacher $teacher)
    {
        $validateData = $request->validate([
            'id_teacher' => 'required',
            'id_level' => '',
            'id_level_detail' => ''
        ]);

        $teacher->update($validateData);
        return redirect()->route('manage.teacher.index')->with('Success', 'Ubah Manajemen Guru Sukses');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showJson($id)
    {
        $mgtteacher = MgtTeacher::findOrFail($id);
        return $mgtteacher->toJson();
    }

    public function destroy(MgtTeacher $teacher)
    {
        $teacher->delete();

        return redirect()->route('manage.teacher.index')->with('success', 'Hapus Data Sukses');
    }

    public function addClass($id)
    {
        $classrooms = DB::table('classrooms as c')
                        ->join('levels as l', 'l.id', '=', 'c.id_level')
                        ->join('level_details as ld', 'ld.id', 'c.id_level_detail')
                        ->select('c.id as idClass', 'c.name as className', 'l.abbr as levelAbbr', 'ld.name as levelDetailName')
                        ->get();

        return view('manage.teacher.add-class', compact('classrooms', 'id'));
    }
    
    public function addClassStore(Request $request)
    {
        $id_classrooms = $request->input('id_class');
        $id_mgt_teacher = $request->input('id_mgt_teacher');
        
        if($id_classrooms != null){
            foreach($id_classrooms as $id_classroom) {
                MgtTeacherClass::create([
                    'id_mgt_teacher' => $id_mgt_teacher,
                    'id_class' => $id_classroom,
                ]);
            }
        }
        return redirect()->route('manage.teacher.show', $id_mgt_teacher);
    }

    public function addMatter($id)
    {
        $matters = DB::table('matters as m')
                        ->join('subjects as s', 's.id', '=', 'm.id_subject')
                        ->select('m.id as idMatter', 'm.name as matterName', 's.name as subjectName')
                        ->get();
        return view('manage.teacher.add-matter', compact('matters', 'id'));
    }
    
    public function addMatterStore(Request $request)
    {
        $id_matters = $request->input('id_matter');
        $id_mgt_teacher = $request->input('id_mgt_teacher');
        
        if($id_matters != null){
            foreach($id_matters as $id_matter) {
                MgtTeacherMatter::create([
                    'id_mgt_teacher' => $id_mgt_teacher,
                    'id_matter' => $id_matter,
                ]);
            }
        }
        return redirect()->route('manage.teacher.show', $id_mgt_teacher);
    }
}
