<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Ref\RefSchoolYear;
use App\Model\Ref\RefSemester;
use App\Model\Ref\RefClassroom;
use App\Model\Ref\RefMatter;
use App\Model\Ref\RefStudyTime;
use App\Model\Ref\RefDay;
use App\Model\Ref\RefSubject;

use App\Model\Ref\RefLevel;
use App\Model\Ref\RefLevelDetail;

use App\Model\Manage\MgtSchedule;

use Illuminate\Support\Facades\DB;

use App\Services\ScheduleService;


class MgtScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, ScheduleService $scheduleService)
    {
        $qSchoolYear = $request->query('id_schoolyear');
        $qSemester = $request->query('id_semester');
        $qLevel = $request->query('id_level');
        $qLevelDetail = $request->query('id_level_detail');
        $qGrade = $request->query('grade');
        $qClass = $request->query('id_class');
        
        $schedules = $scheduleService->generateScheduleService($qSchoolYear, $qSemester, $qLevel, $qLevelDetail, $qGrade, $qClass);
        
        $schoolyears = RefSchoolYear::all();
        $semesters = RefSemester::all();
        $classrooms = RefClassroom::all();

        $classroomGrade = DB::table('classrooms')
                            ->select('grade')
                            ->distinct()
                            ->get();
        $days = RefDay::all();
        $days2 = RefDay::all();

        $studytimes = RefStudyTime::all();

        $className = RefClassroom::find($qClass);

        $level_details = RefLevelDetail::all();
        $levels = RefLevel::all();

        $matters = RefMatter::all();

        $teacherByClasses = DB::table('mgt_teachers as mt')
                                ->join('users as u', 'u.id', '=', 'mt.id_teacher')
                                ->join('mgt_teacher_classes as mtc', 'mtc.id_mgt_teacher', '=', 'mt.id')
                                ->where('mtc.id_class', $qClass)
                                ->select('u.id as teacherID', 'u.name as teacherName')
                                ->get();

        $teachers = DB::table('users as u')->join('teachers as t', 't.id_teacher', '=', 'u.id')->get();
        
        $subjects = RefSubject::all();

        return view('manage.schedule.index', compact('qSchoolYear', 'qSemester', 'qLevelDetail', 'qLevel', 'qGrade', 'qClass', 'classroomGrade', 'schedules', 'schoolyears', 'semesters', 'classrooms', 'levels', 'level_details','className', 'days', 'days2', 'studytimes', 'matters', 'teachers', 'teacherByClasses', 'subjects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function subjectByTeacher(Request $request)
    {
        $id_teacher = $request->id_teacher;
        $subjectByTeacher = DB::table('teacher_subjects as ts')
                                ->join('subjects as s', 's.id', '=', 'ts.id_subject')
                                ->select('s.id as subjectID', 's.name as subjectName')
                                ->where('ts.id_teacher', $id_teacher)
                                ->get();
        return response()->json([
            'subjectByTeacher' => $subjectByTeacher
        ]);
    }

    
    public function create()
    {
        $schoolyears = RefSchoolYear::all();
        $semesters = RefSemester::all();
        $classrooms = DB::table('classrooms as c')
                        ->join('levels as l', 'l.id', '=','c.id_level')
                        ->join('level_details as ld', 'ld.id', '=','c.id_level_detail')
                        ->select('c.id as idClass','c.name as className', 'l.abbr as levelAbbr', 'ld.name as levelDetailName')
                        ->get();

        $teachers = DB::table('users as u')
                        ->join('teachers as t', 't.id_teacher', '=', 'u.id')
                        ->get();
        $matters = RefMatter::all();

        $days = RefDay::all();
        $studytimes = RefStudyTime::all();

        return view('manage.schedule.create', compact('schoolyears', 'matters', 'semesters', 'teachers', 'classrooms', 'studytimes', 'days'));
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
            'id_subject' => '',
            'id_teacher' => '',
            'id_class' => '',
            'id_studytime_start' => '',
            'id_studytime_end' => '',
            'id_semester' => '',
            'id_day' => '',
            'id_schoolyear' => ''
        ]);

        MgtSchedule::create($validateData);

        return redirect()->route('manage.schedule.index')->with('Success', 'Tambah Jadwal Pelajaran Sukses');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MgtSchedule $schedule)
    {
        $validateData = $request->validate([
            'id_subject' => '',
            'id_teacher' => '',
            'id_class' => '',
            'id_studytime_start' => '',
            'id_studytime_end' => '',
            'id_semester' => '',
            'id_day' => '',
            'id_schoolyear' => ''
        ]);

        $schedule->update($validateData);
        
        $request->session()->flash('success', 'Ubah Jadwal Sukses');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(MgtSchedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('manage.schedule.index');
    }

    public function levelResponse(Request $request)
    {
        $id = $request->id_level_detail;
        $levels = DB::table('classrooms as c')
                        ->join('levels as l', 'l.id', '=', 'c.id_level')
                        ->where('c.id_level_detail', $id)
                        ->select('l.abbr as levelName', 'l.id as id')
                        ->distinct()
                        ->get();
        return response()->json([
            'levels' => $levels
        ]);
    }

    public function gradeResponse(Request $request)
    {
        $id = $request->id_level;
        $classroomGrade = DB::table('classrooms')
                            ->select('grade as gradeName', 'grade as gradeID')
                            ->where('id_level', $id)
                            ->distinct()
                            ->get();
        return response()->json([
            'grades' => $classroomGrade
        ]);
    }

    public function classResponse(Request $request)
    {
        $grade = $request->grade;
        $classroom = DB::table('classrooms')
                            ->select('id as idClass', 'name as nameClass')
                            ->where('grade', $grade)
                            ->get();
        return response()->json([
            'classroom' => $classroom
        ]);
    }

    public function showJson($id)
    {
        $schedule = MgtSchedule::findOrFail($id);
        return $schedule->toJson();
    }


}
