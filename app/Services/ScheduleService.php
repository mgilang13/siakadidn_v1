<?php

namespace App\Services;

use App\Model\Manage\MgtSchedule;
use App\Model\Ref\RefDay;
use App\Model\Ref\RefStudyTime;
use Illuminate\Support\Facades\DB;

class ScheduleService
{
    public function generateScheduleService($qSchoolYear, $qSemester, $qLevel, $qLevelDetail, $qGrade, $qClass) {
        $scheduleData = [];
        $days = RefDay::all();
        $schedules = DB::table('mgt_schedules as ms')
                        ->leftJoin('subjects as s', 's.id', '=', 'ms.id_subject')
                        ->leftJoin('classrooms as c', 'c.id', '=', 'ms.id_class')
                        ->leftJoin('semesters as se', 'se.id', '=', 'ms.id_semester')
                        ->leftJoin('school_years as sch', 'sch.id', '=', 'ms.id_schoolyear')
                        ->select('ms.*', 'c.id_level', 'c.id_level_detail', 'c.grade', 's.name as subjectName')                    
                        ->get();
                        
        $studytimes = RefStudyTime::all();
        foreach($studytimes as $studytime) {
            $textStudyTime = $studytime->name;
            $scheduleData[$textStudyTime] = [];
            
            foreach($days as $index => $day) {
                
                $schedule = $schedules->where('id_day', $index)
                                        ->where('id_studytime_start', $studytime->start)
                                        ->where('id_schoolyear', (int)$qSchoolYear)
                                        ->where('id_semester', (int)$qSemester)
                                        ->where('id_class', (int)$qClass)
                                        ->first();
                                        
                if(isset($schedule)) {
                    array_push($scheduleData[$textStudyTime], [
                        'id' => $schedule->id,
                        'subjectName' => $schedule->subjectName,
                        'rowspan' => (($schedule->id_studytime_end - $schedule->id_studytime_start) + 1)
                    ]);
                }
                
                else if(!$schedules->where('id_day', $index)->where('id_studytime_start', '<', $studytime->start)->where('id_studytime_end', '>=', ($studytime->end)-1)->where('id_schoolyear', (int)$qSchoolYear)->where('id_semester', (int)$qSemester)->where('id_level', (int)$qLevel)->where('id_level_detail', (int)$qLevelDetail)->where('grade', (int)$qGrade)->where('id_class', (int)$qClass)->count()) {
                    array_push($scheduleData[$textStudyTime], 1);
                } else {
                    array_push($scheduleData[$textStudyTime], 0);
                }
            }
        }

        return $scheduleData;
    }
}