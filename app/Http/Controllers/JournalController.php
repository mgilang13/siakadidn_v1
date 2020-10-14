<?php

namespace App\Http\Controllers;

use App\Model\Journal;
use App\Model\JournalDetail;
use App\Model\JournalAttendance;
use App\Model\JournalFeedback;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Model\User;
use App\Model\FeedbackTreat;

use App\Model\Manage\MgtSchedule;

use App\Model\Ref\RefSchoolYear;
use App\Model\Ref\RefSemester;
use App\Model\Ref\RefDay;
use App\Model\Ref\RefClassroom;
use App\Model\Ref\RefMatter;
use App\Model\Ref\RefMatterDetail;
use App\Model\Ref\RefSubject;
use App\Model\Ref\RefLevelDetail;

use App\Model\Manage\MgtClass;
use App\Model\Manage\MgtClassDetail;

use App\Services\JournalService;

class JournalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $qClass = $request->query('id_class');
        
        $start_date = $request->query('start_date');
        
        if($start_date == null){
            $start_date = date('Y-m-d',strtotime("-1 week"));
        } else {
            $start_date = $request->query('start_date');
        }

        $end_date = $request->query('end_date');

        if($end_date == null) {
            $end_date = date('Y-m-d');
        } else {
            $end_date = $request->query('end_date');
        }

        $students = DB::select('call journal_summary_class(?, ?, ?)', array($qClass, $start_date, $end_date));
        
        $id_user = Auth::user()->id;
       

        $teachedClass = DB::table('mgt_teachers as mt')
                            ->join('mgt_teacher_classes as mtc', 'mtc.id_mgt_teacher', '=', 'mt.id')
                            ->join('classrooms as c', 'c.id', '=', 'mtc.id_class')
                            ->where('mt.id_teacher', $id_user)
                            ->select('c.name as className', 'mtc.id_class as id')
                            ->get();

        return view('journal.index', compact('teachedClass', 'students', 'qClass', 'start_date', 'end_date'));
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
        
        $id_teacher = Auth::user()->id;

        $validateData = $request->validate([
            'id_schedule' => 'required',
            'id_matter' => 'required',
            'result' => '',
            'obstacle' => '',
            'solution' => '',
            'note' => '',
            'teaching_date' => ''
            ]);
        
        $journal = Journal::create($validateData);
        $journal->id_teacher = $id_teacher;
        $journal->save();

        $journal_attendances = $request->input('status');
        $journal_details = $request->input('journal_details');

        if($journal_attendances != null) {
            foreach($journal_attendances as $index => $journal_attendance) {
                JournalAttendance::create([
                    'id_journal' => $journal->id,
                    'id_student' => $index,
                    'status' => $journal_attendance
                ]);
            }
        }

        if($journal_details != null) {
            foreach($journal_details as $journal_detail) {
                if($journal_detail != null) {
                    JournalDetail::create([
                        'id_journal' => $journal->id,
                        'id_matter_detail' => $journal_detail
                    ]);
                }
            }
                
        }

        return redirect()->route('journal.index')->with('success', 'Tambah Jurnal Sukses');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $journals = Journal::with(['teacher', 'matter', 'journal_feedback', 'journal_attendance.user', 'journal_detail.matter_detail' => function($query) {
            $query->select('id', 'name');
        }])->where('id_schedule', $id)->get();

        $schedule = DB::table('mgt_schedules as ms')
                        ->join('subjects as s', 's.id', '=', 'ms.id_subject')
                        ->join('matters as m', 'm.id_subject', '=', 'ms.id_subject')
                        ->join('days as d', 'd.id', '=', 'ms.id_day')
                        ->where('ms.id', $id)
                        ->select('s.name as name', 'm.name as matterName', 'd.name as dayName', 'ms.*')
                        ->first();
       
        return view('journal.show', compact('journals', 'schedule'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function edit(Journal $journal)
    {
        $tanggal_sekarang = date('Y-m-d');
        $matters = RefMatter::all();
        $studentClass = DB::table('journals as j')
                            ->join('mgt_schedules as ms', 'ms.id', '=', 'j.id_schedule')
                            ->join('mgt_classes as mc', 'mc.id_class', '=', 'ms.id_class')
                            ->join('mgt_class_details as mcd', 'mc.id', '=', 'mcd.id_mgt_class')
                            ->join('users as u', 'u.id', '=', 'mcd.id_student')
                            ->select('u.id as id', 'u.name as name')
                            ->where('j.id', $journal->id)
                            ->get();
        
        
        return view('journal.edit', compact('journal', 'tanggal_sekarang', 'matters', 'studentClass'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Journal $journal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Journal $journal)
    {
        DB::transaction(function () use ($journal) {
            $journalAttendance = JournalAttendance::where('id_journal', $journal->id);
            if($journalAttendance) {
                $journalAttendance->delete();
            }

            $journalDetail = JournalDetail::where('id_journal', $journal->id);
            if($journalDetail) {
                $journalDetail->delete();
            }

            $journalFeedback = JournalFeedback::where('id_journal', $journal->id);
            if($journalFeedback){
                $journalFeedback->delete();
            }

            $journal->delete();
        });
        
        return redirect()->route('journal.show', $journal->id_schedule);
    }

    public function teacherSchedule($id, JournalService $journalService)
    {
        $id_teacher = Auth::user()->id;

        $idClass = $id;
        $idSchoolYear = RefSchoolYear::where('status', '1')->value('id');
        $idSemester = RefSemester::where('status','1')->value('id');

        $teacher = User::findOrFail($id_teacher);
        $classroom = RefClassroom::findOrFail($idClass);

        $journal_schedules = $journalService->generateJournalService($idSchoolYear, $idSemester, $idClass);
      
        $days = RefDay::all();

        $tanggal_sekarang = date('Y-m-d');

        $studentClass = DB::table('mgt_classes as mc')
                            ->join('mgt_class_details as mcd', 'mc.id', '=', 'mcd.id_mgt_class')
                            ->join('users as u', 'u.id', '=', 'mcd.id_student')
                            ->select('u.id as id', 'u.name as name')
                            ->where('mc.id_class', $idClass)
                            ->get();
                            
        $matters = RefMatter::all();
        $matter_details = RefMatterDetail::all();


        return view('journal.teacher-schedule', compact('teacher', 'journal_schedules', 'days', 'classroom', 'tanggal_sekarang', 'studentClass', 'matters', 'matter_details'));
    }

    public function listSubMatter($id)
    {
        $matter_detail = DB::table('matter_details')->where('id_matter', $id)->get();
        return $matter_detail->toJson();
    }

    public function listMatter($matter)
    {
        $arrayMatter = explode(",", $matter);
        $idSubject = $arrayMatter[0];
        $idLevel = $arrayMatter[1];
        $matters = DB::table('matters')->where('id_subject', $idSubject)->where('id_level', $idLevel)->get();
        return $matters->toJson();
    }

    public function feedbackStore(Request $request)
    {
        JournalFeedback::create([
            'id_journal' => $request->input('id_journal'),
            'id_student' => Auth::user()->id,
            'feedback_option' => $request->input('feedback_option'),
            'note' => $request->input('note')
        ]);

        return redirect()->route('dashboard')->with('success', 'Syukron atas feedback-nya :)');
    }

    public function showJson($id)
    {
        $journal = Journal::findOrFail($id);
        return $journal->toJson();
    }

    public function journalDetailResponse(Request $request)
    {
        $id_matter = $request->id_matter;

        $matter_details = DB::table('matter_details')
                            ->select('id as idSubMatter', 'name as nameSubMatter')
                            ->where('id_matter', $id_matter)
                            ->get();
        return response()->json([
            'matter_details' => $matter_details
        ]);
    }

    public function reportAbsensiStudent(Request $request, User $student)
    {

        $subjects = RefSubject::all();

        $grade_data = $request->query('grade');
        $id_subject = $request->query('id_subject');
        $id_subject = (int)$id_subject;

        $grade_array = explode(", ", $grade_data);
        
        $grade = (int)$grade_array[0];
        $id_level = isset($grade_array[1]) ? (int)$grade_array[1] : null;
        $id_level_detail = isset($grade_array[2]) ? (int)$grade_array[2] : null;

        $start_date = $request->query('start_date');

        if($start_date == null){
            $start_date = date('Y-m-d',strtotime("-1 week"));
        } else {
            $start_date = $request->query('start_date');
        }

        $end_date = $request->query('end_date');

        if($end_date == null) {
            $end_date = date('Y-m-d');
        } else {
            $end_date = $request->query('end_date');
        }

        $absensi_detail = DB::table('vw_journal_absensi_siswa')
                                ->where('id_student', $student->id)
                                ->whereBetween('teaching_date', array($start_date, $end_date))
                                ->get();


        $absensi = DB::select('call journal_absensi_siswa(?, ?, ?)', array($student->id, $start_date, $end_date));
        $absensi_total = DB::select('call journal_absensi_siswa_total(?, ?, ?)', array($student->id, $start_date, $end_date));
        
        return view('journal.report.absensi-student', compact('subjects', 'start_date', 'end_date', 'student', 'absensi', 'absensi_total', 'grade', 'id_level', 'id_level_detail','id_subject', 'absensi_detail'));
    }

    public function reportFeedbackStudent(Request $request, User $student) {
        
        $start_date = $request->query('start_date');

        if($start_date == null){
            $start_date = date('Y-m-d',strtotime("-1 week"));
        } else {
            $start_date = $request->query('start_date');
        }

        $end_date = $request->query('end_date');

        if($end_date == null) {
            $end_date = date('Y-m-d');
        } else {
            $end_date = $request->query('end_date');
        }

        $feedback_detail = DB::table('vw_journal_feedback_siswa')
                                ->where('id_student', $student->id)
                                ->whereBetween('teaching_date', array($start_date, $end_date))
                                ->get();

        $feedback = DB::select('call journal_feedback_siswa(?, ?, ?)', array($student->id, $start_date, $end_date));

        $feedback_total = DB::select('call journal_feedback_siswa_total(?, ?, ?)', array($student->id, $start_date, $end_date));

        return view('journal.report.feedback-student', compact('start_date', 'end_date', 'student', 'feedback_detail', 'feedback', 'feedback_total'));
    }
    public function reportFeedbackClass(Request $request) {
        $grade = $request->query('grade');
        $id_level = $request->query('id_level');
        $id_level_detail = $request->query('id_level_detail');
        $id_subject = $request->query('id_subject');
        
        $start_date = $request->query('start_date');

        if($start_date == null){
            $start_date = date('Y-m-d',strtotime("-1 week"));
        } else {
            $start_date = $request->query('start_date');
        }

        $end_date = $request->query('end_date');

        if($end_date == null) {
            $end_date = date('Y-m-d');
        } else {
            $end_date = $request->query('end_date');
        }
        $subjects = RefSubject::all();
        $level_details = RefLevelDetail::all();

        
        $feedback_class = DB::select('call journal_feedback_class(?, ?, ?, ?, ?, ?)', array($grade, $id_level, $id_level_detail, $id_subject, $start_date, $end_date));
       
        return view('journal.report.feedback-class', compact('feedback_class', 'subjects', 'grade', 'id_level', 'id_level_detail', 'id_subject', 'start_date', 'end_date', 'level_details'));
    }

    public function reportAbsensiClass(Request $request) {
        
        $grade = $request->query('grade');
        $id_level = $request->query('id_level');
        $id_level_detail = $request->query('id_level_detail');
        $id_subject = $request->query('id_subject');
        
        $start_date = $request->query('start_date');

        if($start_date == null){
            $start_date = date('Y-m-d',strtotime("-1 week"));
        } else {
            $start_date = $request->query('start_date');
        }

        $end_date = $request->query('end_date');

        if($end_date == null) {
            $end_date = date('Y-m-d');
        } else {
            $end_date = $request->query('end_date');
        }
        $subjects = RefSubject::all();
        $level_details = RefLevelDetail::all();

        
        $absensi_class = DB::select('call journal_absensi_class(?, ?, ?, ?, ?, ?)', array($grade, $id_level, $id_level_detail, $id_subject, $start_date, $end_date));
        
        return view('journal.report.absensi-class', compact('absensi_class', 'subjects', 'grade', 'id_level', 'id_level_detail', 'id_subject', 'start_date', 'end_date', 'level_details'));
    }

    public function feedbackTreat(Request $request, User $student) 
    {
        FeedbackTreat::create([
            'id_journal_feedback' => $request->input('id_journal_feedback'),
            'description' => $request->input('description')
        ]);
        return redirect()->route('journal.report.feedback-student', $student->id);
    }
}
