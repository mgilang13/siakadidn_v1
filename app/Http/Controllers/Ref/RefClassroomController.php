<?php

namespace App\Http\Controllers\Ref;

use App\Http\Controllers\Controller;

use App\Model\User;
use App\Model\Core\Roles;
use App\Model\Ref\RefLevel;
use App\Model\Ref\RefLevelDetail;
use App\Model\Ref\RefClassroom;

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
        $users = Roles::findOrFail(3)->users()->get();
        $levels = RefLevel::all();
        $level_details = RefLevelDetail::all();

        $classrooms = DB::table('classrooms')
                                ->leftJoin('users', 'users.id', '=', 'classrooms.id_teacher')
                                ->leftJoin('levels', 'classrooms.id_level', '=', 'levels.id')
                                ->leftJoin('level_details', 'classrooms.id_level_detail', '=', 'level_details.id')
                                ->select('classrooms.id', 'users.name as teacherName', 'classrooms.name as className', 'description', 
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
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit(Classroom $classroom)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Classroom $classroom)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function destroy(Classroom $classroom)
    {
        //
    }
}
