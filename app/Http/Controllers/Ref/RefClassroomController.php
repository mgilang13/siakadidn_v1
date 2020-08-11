<?php

namespace App\Http\Controllers\Ref;

use App\Http\Controllers\Controller;

use App\Model\User;
use App\Model\Core\Roles;
use App\Model\Ref\RefLevel;
use App\Model\Ref\RefLevelDetail;
use App\Model\Ref\RefClassroom;
use App\Model\Ref\RefTeacher;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RefClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = DB::table('users')
                        ->join('teachers', 'users.id', '=', 'teachers.id_teacher')
                        ->join('roles_users', 'users.id', '=', 'roles_users.users_id')
                        ->where('roles_users.roles_id', 3)
                        ->get();                        

        $levels = RefLevel::all();
        $level_details = RefLevelDetail::all();

        $classrooms = DB::table('classrooms')
                                ->leftJoin('users', 'users.id', '=', 'classrooms.id_teacher')
                                ->leftJoin('teachers', 'teachers.id_teacher', '=', 'classrooms.id_teacher')
                                ->leftJoin('levels', 'classrooms.id_level', '=', 'levels.id')
                                ->leftJoin('level_details', 'classrooms.id_level_detail', '=', 'level_details.id')
                                ->select('classrooms.id', 'teachers.*', 'users.name as teacherName', 'classrooms.name as className', 'description', 
                                            'levels.name as namaLevel','levels.abbr as abbrevation', 
                                            'level_details.name as namaLevelDetail')->get();

        // $classrooms = DB::table('classrooms')->where('id', '!=', 40)->get();
        return view('ref.classroom.index', compact('classrooms', 'users', 'levels', 'level_details'));
    }

    public function showJson($id)
    {
        $classroom = RefClassroom::findOrFail($id);
        return $classroom->toJson();
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
     *required
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required',
            'id_teacher' => '',
            'id_level' => '',
            'id_level_detail' => '',
            'description' => ''
        ]);

        RefClassroom::create($validateData);
        $request->session()->flash('success', 'Tambah Kelas Sukses');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function show(Classroom $classroom)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function edit(RefClassroom $classroom)
    {
        $teachers = DB::table('users')
                            ->join('teachers', 'users.id', '=', 'teachers.id_teacher')
                            ->join('roles_users', 'users.id', '=', 'roles_users.users_id')
                            ->where('roles_users.roles_id', 3)
                            ->get();

        $levels = RefLevel::all();
        $level_details = RefLevelDetail::all();

        return view('ref.classroom.edit', compact('classroom', 'teachers', 'levels', 'level_details'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\RefClassroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RefClassroom $classroom)
    {
        $validateData = $request->validate([
            'name' => 'required',
            'id_teacher' => '',
            'id_level' => '',
            'id_level_detail' => '',
            'description' => ''
        ]);

       $users = DB::table('users')
                        ->join('teachers', 'users.id', '=', 'teachers.id_teacher')
                        ->join('roles_users', 'users.id', '=', 'roles_users.users_id')
                        ->where('roles_users.roles_id', 3)
                        ->get();

        $levels = RefLevel::all();
        $level_details = RefLevelDetail::all();

        $classrooms = DB::table('classrooms')
                                ->leftJoin('users', 'users.id', '=', 'classrooms.id_teacher')
                                ->leftJoin('teachers', 'teachers.id_teacher', '=', 'classrooms.id_teacher')
                                ->leftJoin('levels', 'classrooms.id_level', '=', 'levels.id')
                                ->leftJoin('level_details', 'classrooms.id_level_detail', '=', 'level_details.id')
                                ->select('classrooms.id', 'teachers.*', 'users.name as teacherName', 'classrooms.name as className', 'description', 
                                            'levels.name as namaLevel','levels.abbr as abbrevation', 
                                            'level_details.name as namaLevelDetail')->get();

        $classroom->update($validateData);
        return redirect()->route('ref.classroom.index', compact('classrooms', 'users', 'levels', 'level_details'))->with('success', 'Ubah Data Guru Sukses');
        // return view('ref.classroom.index', compact('classrooms', 'users', 'levels', 'level_details'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function destroy(RefClassroom $classroom)
    {
        $classroom->delete();

        return redirect()->route('ref.classroom.index')->with('success', 'Hapus Data Kelas Sukses');
    }
}
