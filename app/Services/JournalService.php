<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Model\Ref\RefDay;
use App\Model\Ref\RefStudyTime;

class JournalService
{
    public function generateJournalService($idSchoolYear, $idSemester, $idClass) {
        $journalData = [];
        $days = RefDay::all();
        $journal_schedules = DB::table('mgt_schedules as ms')
                        ->leftJoin('classrooms as c', 'c.id', '=', 'ms.id_class')
                        ->leftJoin('subjects as s', 's.id', '=', 'ms.id_subject')
                        ->leftJoin('semesters as se', 'se.id', '=', 'ms.id_semester')
                        ->leftJoin('school_years as sch', 'sch.id', '=', 'ms.id_schoolyear')
                        ->select('ms.*', 's.name as subjectName', 's.id as idSubject')                    
                        ->get();
        $studytimes = RefStudyTime::all();
        
        foreach($studytimes as $studytime) {
            $textStudyTime = $studytime->name;
            $journalData[$textStudyTime] = [];
            
            foreach($days as $index => $day) {
                
                $journal_schedule = $journal_schedules->where('id_day', $index)
                                        ->where('id_studytime_start', $studytime->name)
                                        ->where('id_schoolyear', $idSchoolYear)
                                        ->where('id_semester', $idSemester)
                                        ->where('id_class', $idClass)
                                        ->first();

                if($journal_schedule) {
                    array_push($journalData[$textStudyTime], [
                        'idSchedule' => $journal_schedule->id,
                        'idSubject' => $journal_schedule->idSubject,
                        'subjectName' => $journal_schedule->subjectName,
                        'rowspan' => ($journal_schedule->id_studytime_end - $journal_schedule->id_studytime_start)+1
                    ]);
                }
                else if(!$journal_schedules->where('id_day', $index)->where('id_studytime_start', '<', $studytime->name)->where('id_studytime_end', '>=', $studytime->name)->count()) {
                    array_push($journalData[$textStudyTime], 1);
                } else {
                    array_push($journalData[$textStudyTime], 0);
                }
            }
        }

        return $journalData;
    }
}