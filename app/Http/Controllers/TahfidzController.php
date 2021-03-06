<?php

namespace App\Http\Controllers;

use App\Model\Tahfidz;
use App\Model\User;
use App\Model\Ref\RefHalaqah;
use App\Model\Ref\RefStudent;
use App\Model\Ref\RefParents;
use App\Model\Soorah;
use App\Model\Ref\RefClassroom;
use App\Model\Ref\RefLevel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;
use PDF;

use Carbon\Carbon;

class TahfidzController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::user()->id;

        $halaqah = RefHalaqah::where('id_teacher', $id)->get()->first();
        
        return view('tahfidz.index', compact('halaqah'));
    }

    public function listHalaqah()
    {
        $halaqahs = DB::table('halaqahs')
                                ->join('users', 'users.id', '=', 'halaqahs.id_teacher')
                                ->select('halaqahs.id', 'users.name as teacherName', 'halaqahs.name as halaqahName', 'description')
                                ->get();
        return view('tahfidz.list-halaqah', compact('halaqahs'));
    }

    public function listSantri(Request $request)
    {
        $q = $request->query('q') ?: '';
        
        $user_students = DB::table('users')
                        ->where('users.name', 'like', '%'.$q.'%')
                        ->join('students', 'students.id_student', '=', 'users.id')
                        ->join('halaqahs', 'halaqahs.id', '=', 'students.id_halaqah')
                        ->select('*', 'users.name as santriName', 'halaqahs.name as halaqahName')
                        ->paginate(20);
        
        $user_students->currentTotal = ($user_students->currentPage() - 1) * $user_students->perPage() + $user_students->count();
        $user_students->startNo = ($user_students->currentPage() - 1) * $user_students->perPage() + 1;
        $user_students->no = ($user_students->currentPage() - 1) * $user_students->perPage() + 1;
        
        return view('tahfidz.list-santri', compact('q', 'user_students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
            'id_student' => '',
            'id_halaqah' => '',
            'id_teacher' => '',
            'tanggal_setor' => '',
            'deposit_time' => '',
            'soorah_start' => '', 
            'soorah_end' => '', 
            'verse_start' => '', 
            'verse_end' => '',
            'type' => '',
            'assessment' => '',
            'line' => '',
            'page' => '',
            'absen' => '',
            'note' => '' 
        ]);
        
        $tahfidz_note = Tahfidz::create($validateData);
        
        return redirect()->route('tahfidz.show', $tahfidz_note->id_student)->with('success', 'Tambah Catatan Hafalan  sukses');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Tahfidz  $tahfidz
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = RefStudent::findOrFail($id);
        
        // $tahfidzs1 = DB::table('tahfidzs')->where('id_student', $id)->orderBy('tanggal_setor', 'desc')->paginate(20);
        $tahfidzs = Tahfidz::where('id_student', $id)->orderBy('tanggal_setor', 'desc')->paginate(20);
       
        $teacher = DB::table('students as s')
                        ->join('halaqahs as h', 'h.id', '=', 's.id_halaqah')
                        ->join('users as u', 'u.id', '=', 'h.id_teacher')
                        ->where('s.id_student', $id)
                        ->get();

        $tahfidzs->currentTotal = ($tahfidzs->currentPage() - 1) * $tahfidzs->perPage() + $tahfidzs->count();
        $tahfidzs->startNo = ($tahfidzs->currentPage() - 1) * $tahfidzs->perPage() + 1;
        $tahfidzs->no = ($tahfidzs->currentPage() - 1) * $tahfidzs->perPage() + 1;

        $soorahs = Soorah::all();
        
        $tahfidz_total_ziyadah = DB::select('call tahfidz_total(?, ?)', array($id, 'ziyadah'));
        $tahfidz_total_murajaah = DB::select('call tahfidz_total(?, ?)', array($id, 'murajaah'));
        
        // Untuk membuat grafik
        $tahfidz_report_ziyadah = DB::select('call tahfidz_report(?, ?)', array($id, 'ziyadah'));
        
        $tgl_bln_ziyadah = array();
        $total_line_ziyadah = array();
        foreach($tahfidz_report_ziyadah as $tc){
            array_push($tgl_bln_ziyadah, $tc->tgl_bln);
            array_push($total_line_ziyadah, $tc->total_line);
        }

        $tahfidz_report_murajaah = DB::select('call tahfidz_report(?, ?)', array($id, 'murajaah'));
        
        $tgl_bln_murajaah = array();
        $total_line_murajaah = array();
        foreach($tahfidz_report_murajaah as $tc){
            array_push($tgl_bln_murajaah, $tc->tgl_bln);
            array_push($total_line_murajaah, $tc->total_line);
        }

        $tahfidz_absensi = DB::select('call tahfidz_absensi_bu(?)', array($id));
        
        $tahfidz_absensi = $tahfidz_absensi[0];

        $soorah_name = array();
        foreach($tahfidzs as $tahfidz){
            foreach($soorahs as $soorah) {
                if($tahfidz->soorah_start == $soorah->id) {
                    $tahfidz->soorah_start = $soorah->name;
                }
                if ($tahfidz->soorah_end == $soorah->id){
                    $tahfidz->soorah_end = $soorah->name;
                }
            }
        }
        
        return view('tahfidz.show', compact('student', 'tahfidzs', 'tahfidz_total_ziyadah', 'tahfidz_total_murajaah', 'tgl_bln_ziyadah', 'total_line_ziyadah', 'tgl_bln_murajaah', 'total_line_murajaah', 'tahfidz_absensi', 'teacher'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Tahfidz  $tahfidz
     * @return \Illuminate\Http\Response
     */
    public function edit(Tahfidz $tahfidz)
    {
        $student = RefStudent::findOrFail($tahfidz->id_student);
        $halaqah = RefHalaqah::findOrFail($tahfidz->id_halaqah);
        $soorahs = Soorah::all()->sortByDesc('order');
        $tanggal_sekarang = date('Y-m-d');

        return view('tahfidz.edit', compact('tahfidz', 'student', 'halaqah', 'soorahs', 'tanggal_sekarang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Tahfidz  $tahfidz
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tahfidz $tahfidz)
    {
        $validateData = $request->validate([
            'id_student' => '',
            'id_halaqah' => '',
            'id_teacher' => '',
            'tanggal_setor' => '',
            'deposit_time' => '',
            'soorah_start' => '', 
            'soorah_end' => '', 
            'verse_start' => '', 
            'verse_end' => '',
            'type' => '',
            'assessment' => '',
            'line' => '',
            'page' => '',
            'absen' => '',
            'note' => ''
        ]);

        DB::transaction(function () use ($tahfidz, $request, $validateData) {
            $tahfidz->update($validateData);
            if(empty($request->input('page'))) {
                $tahfidz->page = 0;
                $tahfidz->save();
            }
        });

        return redirect()->route('tahfidz.show', $tahfidz->id_student)->with('success', 'Ubah Catatan sukses');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Tahfidz  $tahfidz
     * @return \Illuminate\Http\Response
     */
    public function showJson($id)
    {
        $tahfidz = Tahfidz::findOrFail($id);
        return $tahfidz->toJson();
    }

    public function destroy(Tahfidz $tahfidz)
    {   
        $id_student = $tahfidz->id_student;
        
        DB::transaction(function () use ($tahfidz) {
            $tahfidz->delete();
        });

        return redirect()->route('tahfidz.show', $id_student)->with('success', 'Hapus Catatan Sukses');
    }

    public function showMember(RefHalaqah $halaqah)
    {
        $listed_members = DB::table('students')
                                ->join('users', 'users.id', '=', 'students.id_student')
                                ->where('students.id_halaqah', $halaqah->id)
                                ->get();
                                // dd($listed_members);
        return view('tahfidz.show-member', compact('listed_members', 'halaqah'));
    }

    public function halaqahPreview(RefHalaqah $halaqah) {
        $listed_members = DB::table('students as s')
                                ->join('users as u', 'u.id', '=', 's.id_student')
                                ->where('s.id_halaqah', $halaqah->id)
                                ->select('u.id')
                                ->get();
        foreach($listed_members as $index => $value){
            $id = $value->id;

            $student = RefStudent::findOrFail($id);
            $tahfidzs = Tahfidz::where('id_student', $id)->orderBy('tanggal_setor', 'desc')->paginate(20);
            
            $teacher = DB::table('students as s')
                        ->join('halaqahs as h', 'h.id', '=', 's.id_halaqah')
                        ->join('users as u', 'u.id', '=', 'h.id_teacher')
                        ->where('s.id_student', $id)
                        ->get();
                        
            $tahfidzs->currentTotal = ($tahfidzs->currentPage() - 1) * $tahfidzs->perPage() + $tahfidzs->count();
            $tahfidzs->startNo = ($tahfidzs->currentPage() - 1) * $tahfidzs->perPage() + 1;
            $tahfidzs->no = ($tahfidzs->currentPage() - 1) * $tahfidzs->perPage() + 1;

            $soorahs = Soorah::all();
        
            $tahfidz_total_ziyadah = DB::select('call tahfidz_total(?, ?)', array($id, 'ziyadah'));
            $tahfidz_total_murajaah = DB::select('call tahfidz_total(?, ?)', array($id, 'murajaah'));
            
            // Untuk membuat grafik
            $tahfidz_report_ziyadah = DB::select('call tahfidz_report(?, ?)', array($id, 'ziyadah'));
            
            $tgl_bln_ziyadah = array();
            $total_line_ziyadah = array();
            foreach($tahfidz_report_ziyadah as $tc){
                array_push($tgl_bln_ziyadah, $tc->tgl_bln);
                array_push($total_line_ziyadah, $tc->total_line);
            }

            $tahfidz_report_murajaah = DB::select('call tahfidz_report(?, ?)', array($id, 'murajaah'));
            
            $tgl_bln_murajaah = array();
            $total_line_murajaah = array();
            foreach($tahfidz_report_murajaah as $tc){
                array_push($tgl_bln_murajaah, $tc->tgl_bln);
                array_push($total_line_murajaah, $tc->total_line);
            }

            $tahfidz_absensi = DB::select('call tahfidz_absensi_bu(?)', array($id));
            
            $tahfidz_absensi = $tahfidz_absensi[0];

            $soorah_name = array();
            foreach($tahfidzs as $tahfidz){
                foreach($soorahs as $soorah) {
                    if($tahfidz->soorah_start == $soorah->id) {
                        $tahfidz->soorah_start = $soorah->name;
                    }
                    if ($tahfidz->soorah_end == $soorah->id){
                        $tahfidz->soorah_end = $soorah->name;
                    }
                }
            }

        }
        dd('hai');

        // $tahfidzs1 = DB::table('tahfidzs')->where('id_student', $id)->orderBy('tanggal_setor', 'desc')->paginate(20);
       
        
    
        
    }

    public function addNotes($id)
    {
        $student = RefStudent::findOrFail($id);
        $halaqah = RefHalaqah::findOrFail($student->id_halaqah);
        $soorahs = Soorah::all()->sortByDesc('order');
        $tanggal_sekarang = date('Y-m-d');
        // dd($tanggal_sekarang);
        return view('tahfidz.add-notes', compact('student', 'halaqah', 'soorahs', 'tanggal_sekarang'));
    }
    
    public function halaqah($id)
    {
        $halaqah = RefHalaqah::where('id_teacher', $id)->get()->first();
        
        $listed_members = DB::table('students')
                                ->join('users', 'users.id', '=', 'students.id_student')
                                ->where('students.id_halaqah', $halaqah->id)
                                ->get();

        return view('tahfidz.show-member', compact('listed_members', 'halaqah'));
    }


    // Laporan-laporan
    
    // Laporan SMP
    public function reportKepalaTahfidzSMP(Request $request)
    {
        $qGrade = $request->query('grade');
        $qClass = $request->query('id_class');
        
        $qTeacher = $request->query('id_teacher');
        $qHalaqah = $request->query('id_halaqah');
        
        $past_date_check = $request->input('past_date_check');
        
        $present_date = $request->query('present_date');
        $present_date_check = $request->input('present_date_check');

        if ($present_date == null and $present_date_check == null) {
            $present_date = date('Y-m-d');
        } else if ($present_date == null and $present_date_check != null) {
            $present_date = $present_date_check;
        } 
        else {
            $present_date = $request->query('present_date');
        }
        
        $past_date = $request->query('past_date');
        $past_date_check = $request->input('past_date_check');

        if($past_date == null and $past_date_check == null){
            $past_date = date('Y-m-d',strtotime("-1 week"));
        } else if($past_date == null and $past_date_check != null) {
            $past_date = $past_date_check;
        }
         else {
            $past_date = $request->query('past_date');
        }

        $dataPerKelas = DB::select('call tahfidz_reportclass(?, ?, ?)', array(3, $past_date, $present_date));
        if($qGrade == null && $qClass == null) {
            $dataPerHalaqah = DB::select('call tahfidz_reportmuhafidzhead(?, ?, ?)', array(3, $past_date, $present_date));
         } else {
             $dataPerHalaqah = DB::select('call tahfidz_reportkelas(?, ?, ?, ?)', array($qClass, $qGrade, $past_date, $present_date));
         }

         $class = RefClassroom::where('id_level', 3)->get();
         $grade = RefClassroom::select('grade')->where('grade', '<=', 9)->groupBy('grade')->get();
         
         if($qHalaqah != null) {
             $halaqah = RefHalaqah::find($qHalaqah);
         } else {
             $halaqah = null;
         }

        $check_tahfidz = DB::select('call tahfidz_reportmuhafidzsantri(?, ?, ?)', array($qTeacher, $past_date_check, $present_date_check));
     
         return view('tahfidz.report.smp', compact('past_date_check','present_date_check', 'qGrade', 'qClass', 'qHalaqah', 'halaqah', 'check_tahfidz', 'class', 'grade', 'past_date','present_date', 'dataPerKelas', 'dataPerHalaqah'));
    }


     // Laporan SMK
     public function reportKepalaTahfidzSMK(Request $request)
     {
        $qGrade = $request->query('grade');
        $qClass = $request->query('id_class');
        
        $qTeacher = $request->query('id_teacher');
        $qHalaqah = $request->query('id_halaqah');
        
        $past_date_check = $request->input('past_date_check');
        
        $present_date = $request->query('present_date');
        $present_date_check = $request->input('present_date_check');

        if ($present_date == null and $present_date_check == null) {
            $present_date = date('Y-m-d');
        } else if ($present_date == null and $present_date_check != null) {
            $present_date = $present_date_check;
        } 
        else {
            $present_date = $request->query('present_date');
        }
        
        $past_date = $request->query('past_date');
        $past_date_check = $request->input('past_date_check');

        if($past_date == null and $past_date_check == null){
            $past_date = date('Y-m-d',strtotime("-1 week"));
        } else if($past_date == null and $past_date_check != null) {
            $past_date = $past_date_check;
        }
         else {
            $past_date = $request->query('past_date');
        }

        $dataPerKelas = DB::select('call tahfidz_reportclass(?, ?, ?)', array(4, $past_date, $present_date));
        if($qGrade == null && $qClass == null) {
            $dataPerHalaqah = DB::select('call tahfidz_reportmuhafidzhead(?, ?, ?)', array(4, $past_date, $present_date));
         } else {
             $dataPerHalaqah = DB::select('call tahfidz_reportkelas(?, ?, ?, ?)', array($qClass, $qGrade, $past_date, $present_date));
         }

         $class = RefClassroom::where('id_level', 3)->get();
         $grade = RefClassroom::select('grade')->where('grade', '>=', 9)->groupBy('grade')->get();
         
         if($qHalaqah != null) {
             $halaqah = RefHalaqah::find($qHalaqah);
         } else {
             $halaqah = null;
         }

        $check_tahfidz = DB::select('call tahfidz_reportmuhafidzsantri(?, ?, ?)', array($qTeacher, $past_date_check, $present_date_check));
     
         return view('tahfidz.report.smk', compact('past_date_check','present_date_check', 'qGrade', 'qClass', 'qHalaqah', 'halaqah', 'check_tahfidz', 'class', 'grade', 'past_date','present_date', 'dataPerKelas', 'dataPerHalaqah'));
     }

     public function detailStudent(Request $request, $id_level){
        $qClass = $request->query('id_class');
        $qGrade = $request->query('grade');

        $class = RefClassroom::where('id_level', $id_level)->get();
        $grade = RefClassroom::select('grade')->where('id_level', $id_level)->groupBy('grade')->get();
        
        $detailStudent = DB::select('call tahfidz_reportdetail_student(?, ?)', array($qGrade, $qClass));
        
        $gradeSelected = null;

        if($qGrade == null) {
            $gradeSelected = RefClassroom::select('grade')->where('id_level', $id_level)->groupBy('grade')->first();
            $detailStudent = DB::select('call tahfidz_reportdetail_student(?, ?)', array($gradeSelected->grade, $qClass));
        }

        return view('tahfidz.report.detail-student', compact('detailStudent', 'gradeSelected', 'qClass','qGrade', 'class','grade', 'id_level'));
     }

     public function reportFoundation(Request $request)
     {
        $present_date = date('Y-m-d');
        $past_date = $request->query('past_date');

        if($past_date == null){
            $past_date = date('Y-m-d',strtotime("-1 week"));
        } else {
            $past_date = $request->query('past_date');
        }
        $dataFoundation = DB::select('call tahfidz_reportfoundation(?, ?)', array($past_date, $present_date));

        return view('tahfidz.report.foundation', compact('past_date','present_date', 'dataFoundation'));
     }

    public function reportMurid($id)
    {
        $student = RefStudent::findOrFail($id);
        
        return view('tahfidz.report-murid', compact('laporan_tahfidz_murid'));
    }

    public function reportParent($id)
    {
        $id_student = RefParents::where('id_parents', $id)->value('id_student');
        return $this->show($id_student);
        
    }

    public function tahfidzCheck(RefHalaqah $halaqah) {
        // id halaqah
        $tahfidz_check = DB::select('call tahfidz_check(?)', array($halaqah->id));

        return response()->json([
            'tahfidz_check' => $tahfidz_check
        ]);
    }

    public function tahfidzPrint(Request $request, User $student) {        
        $teacher = DB::table('students as s')
                        ->join('halaqahs as h', 'h.id', '=', 's.id_halaqah')
                        ->join('users as u', 'u.id', '=', 'h.id_teacher')
                        ->where('s.id_student', $student->id)
                        ->get();
        $image64 = $request->imageurl;

        $soorahs = Soorah::all();
        
        $tahfidz_total_ziyadah = DB::select('call tahfidz_total(?, ?)', array($student->id, 'ziyadah'));
        $tahfidz_total_murajaah = DB::select('call tahfidz_total(?, ?)', array($student->id, 'murajaah'));
        
        // Untuk membuat grafik
        $tahfidz_report_ziyadah = DB::select('call tahfidz_report(?, ?)', array($student->id, 'ziyadah'));
        
        $tgl_bln_ziyadah = array();
        $total_line_ziyadah = array();
        foreach($tahfidz_report_ziyadah as $tc){
            array_push($tgl_bln_ziyadah, $tc->tgl_bln);
            array_push($total_line_ziyadah, $tc->total_line);
        }

        $tahfidz_report_murajaah = DB::select('call tahfidz_report(?, ?)', array($student->id, 'murajaah'));
        
        $tgl_bln_murajaah = array();
        $total_line_murajaah = array();
        foreach($tahfidz_report_murajaah as $tc){
            array_push($tgl_bln_murajaah, $tc->tgl_bln);
            array_push($total_line_murajaah, $tc->total_line);
        }

        $tahfidz_absensi = DB::select('call tahfidz_absensi_bu(?)', array($student->id));
        
        $tahfidz_absensi = $tahfidz_absensi[0];

        $tahfidzs = DB::table('tahfidzs')->where('id_student', $student->id)->get();
        
        $soorahs = Soorah::all();
        $soorah_name = array();
        foreach($tahfidzs as $tahfidz){
            foreach($soorahs as $soorah) {
                if($tahfidz->soorah_start == $soorah->id) {
                    $tahfidz->soorah_start = $soorah->name;
                }
                if ($tahfidz->soorah_end == $soorah->id){
                    $tahfidz->soorah_end = $soorah->name;
                }
            }
        }

        $pdf = PDF::loadView('tahfidz.tahfidz-pdf', compact('image64', 'student', 'tahfidzs', 'tahfidz_total_ziyadah', 'tahfidz_total_murajaah', 'tgl_bln_ziyadah', 'total_line_ziyadah', 'tgl_bln_murajaah', 'total_line_murajaah', 'tahfidz_absensi', 'teacher'));

        // return $pdf->download('laporan-tahfidz-pdf');
        return $pdf->stream();
    }

}
