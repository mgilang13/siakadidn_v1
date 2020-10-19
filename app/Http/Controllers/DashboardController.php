<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Model\User;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        
        $id = Auth::user()->id;
        $user = User::findOrFail($id);
        $teacher_subject = DB::table('teacher_subjects as ts')->where('id_teacher', $id)->first();
        
        // Dashboard Muhafidz
        $present_date = date('Y-m-d');
        $past_date = $request->query('past_date');
        
        if($past_date == null){
            $past_date = date('Y-m-d',strtotime("-1 week"));
        } else {
            $past_date = $request->query('past_date');
        }

        $yesterday = date('Y-m-d', strtotime('yesterday'));

        $reportMuhafidz = DB::select('call tahfidz_reportmuhafidz(?, ?, ?)', array($id, $past_date, $present_date));
        $reportMuhafidzSantri = DB::select('call tahfidz_reportmuhafidzsantri(?, ?, ?)', array($id, $past_date, $present_date));
        
        // Dashboard Murid
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

        // Dashboard Admin
        $dataFoundation = DB::select('call tahfidz_reportfoundation(?, ?)', array($past_date, $present_date));
        
        $carbon = new Carbon();
        
        $journalStudents = DB::select('call feedbackStudent(?)', array($id));
        
        for($i = 0; $i<count($journalStudents); $i++) {
            $journalStudents[$i]->created_at = Carbon::parse($journalStudents[$i]->created_at)->diffForHumans();
        }

        return view('dashboard', compact('past_date','present_date', 'reportMuhafidz', 'reportMuhafidzSantri','user', 
        'tahfidz_report_murajaah', 'tahfidz_report_ziyadah', 'tgl_bln_ziyadah', 'total_line_ziyadah', 'tgl_bln_murajaah', 
        'total_line_murajaah', 'dataFoundation', 'journalStudents', 'teacher_subject'));
    }
}
