<?php

namespace App\Http\Controllers;

use App\Model\Target\Target;
use App\Model\Target\TargetCategory;
use App\Model\Target\TargetSubCategory;

use DateInterval;

use App\Model\Manage\MgtClass;
use App\Model\Manage\MgtClassDetail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Model\Ref\RefClassroom;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use Response;

class TargetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id_user = Auth::user()->id;

        $targets = Target::with(['target_category'])->where('id_student', $id_user)->get();
        $target_categories = TargetCategory::with(['target_sub_category'])->get();
        $target_category = TargetCategory::all();
        $target_subcategory = TargetSubCategory::all();

        foreach($targets as $target) {
            if($target->duration != null) {
                $duration = $target->duration;
                $readable_time = new DateInterval($duration);
                $target->duration = $readable_time->format("%H:%I:%S");
            }
        }

        $target_all = Target::with(['target_category', 'target_subcategory'])->get();
        
        foreach($target_all as $ta) {
            if($ta->duration != null) {
                $duration = $ta->duration;
                $readable_time = new DateInterval($duration);
                $ta->duration = $readable_time->format("%H:%I:%S");
            }
        }
        
        $target_sub_categories = TargetSubCategory::all();

        $target_sub_categories = json_encode($target_sub_categories);

        $teachedClass = DB::table('mgt_teachers as mt')
                            ->join('mgt_teacher_classes as mtc', 'mtc.id_mgt_teacher', '=', 'mt.id')
                            ->join('classrooms as c', 'c.id', '=', 'mtc.id_class')
                            ->where('mt.id_teacher', $id_user)
                            ->select('c.name as className', 'mtc.id_class as id', 'c.id_level as idLevel')
                            ->get();

        $teachedStudents = [];
        
        foreach($teachedClass as $tc) {
            $teachedStudent = MgtClass::with(['mgt_class_detail.user_detail', 'schoolyear' => function($query) {
                $query->where('status', "1");
            }])->where('id_class', $tc->id)->first();

            array_push($teachedStudents, $teachedStudent);
        }
        
        $teachedStudents = json_encode($teachedStudents);

    return view('target.index', compact('targets', 'target_categories', 'target_all', 'teachedClass', 'teachedStudents', 'target_sub_categories', 'target_category', 'target_subcategory'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $target_categories = TargetCategory::with(['target_sub_category' => function($query){
            $id = Auth::user()->id;
            
            $detail_class = MgtClassDetail::where('id_student', $id)->with(['mgt_class.classroom'])->first();
            
            $id_level = $detail_class->mgt_class->classroom->id_level;

            $query->select('id','id_category', 'name', 'id_level')->where('id_level', $id_level);
        }])->get();

        $id_student = Auth::user()->id;
        $class = MgtClassDetail::where('id_student', $id_student)->with(['mgt_class.schoolyear' => function($query) {
            $query->select('id', 'name', 'status')->where('status', "1");
        }])->first();

        $id_class = $class->mgt_class->id_class;

        return view('target.murid.create', compact('target_categories', 'id_student', 'id_class'));
    }

    /**q
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'id_student' => '',
            'id_class' => '',
            'id_category' => '',
            'id_subcategory' => '',
            'name' => '',
            'jumlah' => '',
            'location' => '',
            'description' => '',
            'duration' => '',
            'youtube_link' => '',
            'image_link' => '',
            'repo_link' => '',
            'demo_link' => '',
            'total_hafalan' => '',
            'status' => ''
        ]);

        $target = Target::create($validateData);

        // $youtube_link = $request->input('youtube_link');
        if($target->youtube_link != null) {
            $youtube_link = $target->youtube_link;

            $detail_video = self::getDetailVideo($youtube_link);
            $duration = $detail_video->contentDetails->duration;
            $target->duration = $duration;
            $target->save();
            
            $title_video = $detail_video->snippet->title;
            $target->name = $title_video;
            $target->save();
        }
        
        if($request->file('image_link')) {
            $image = $request->file('image_link');
            $image_ext = "." . pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
            $upload_path =  env('UPLOAD_TARGET');

            // Original Image
            $image_target = "image_target_".$target->id.$image_ext;
            Storage::disk('public')->putFileAs($upload_path, $image, $image_target);

            $target->image_link = $upload_path."/".$image_target;
            $target->save();
        }
        
        $classroom = RefClassroom::find($target->id_class);
        $category = TargetCategory::find($target->id_category);
        $subcategory = TargetSubCategory::find($target->id_subcategory);

        $filename_repo = $target->name."_project-mentah";
        $filename_demo = $target->name."_project-jadi";

        // save to "Target" Folder
        $path_in_drive = "1iv-dsCkKJmzRIYmQ-pIHNOynE8yvAgQT";
        
        // Inisisasi project file
        $project_repo = $request->file('repo_file');
        $project_demo = $request->file('demo_file');

        // Jika SMP
        if($classroom->id_level = 3) {

            // save to "SMP" Folder
            $path_in_drive .= "/1cCpAcJJZGmpUmeC848NgIbTSkHoVvGOI";
            if($category->name == "IT") {

                // save to "IT" folder
                $path_in_drive .= "/1T6oFOTzmaMg7HzHBnFQIdVIi12R3MBsB";
                if($subcategory->name == "Android") {
                    
                    // save to "Android" Folder
                    $path_in_drive .= "/1St-PkxlEo3mzSTJeYTWKlW2fzvIZvmMW";
                    
                    $repo_ext = ".".pathinfo($project_repo->getClientOriginalName(), PATHINFO_EXTENSION);
                    $demo_ext = ".".pathinfo($project_demo->getClientOriginalName(), PATHINFO_EXTENSION);
                    
                    $filename_repo .= $repo_ext;
                    $filename_demo .= $demo_ext;
                 
                    $project_repo->storePubliclyAs($path_in_drive, $filename_repo, "google");
                    $project_demo->storePubliclyAs($path_in_drive, $filename_demo, "google");
                }
            }
        }

        return redirect()->route('target.index')->with('success', 'Tambah Target Sukses');
    }

    public function categoryStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => ''
        ]);
        TargetCategory::create($request->only(['name', 'amount']));
        
        return redirect()->route('target.index')->with('success', 'Tambah Kategori Target Sukses');
    }

    public function subCategoryStore(Request $request)
    {
        $validateData = $request->validate([
            'id_category' => 'required',
            'name' => 'required|string|max:255',
            'amount' => ''
        ]);
        
        TargetSubCategory::create($validateData);
        
        return redirect()->route('target.index')->with('success', 'Tambah Sub-Kategori Target Sukses');
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
    public function update(Request $request, Target $target)
    {
        $request->validate([
            'status' => ''
        ]);

        $params = $request->only(['status']);
        $target->update($params);
    }

    public function updateTarget(Request $request) {
        $status = $request->input('status');
        $status_all = $request->input('status_all');
        $status_all = json_decode($status_all);
        foreach($status_all as $s) {
            $target = Target::find($s->id);
            $target->status = $s->status;
            $target->save();
        }

        return redirect()->route('target.index')->with('success', 'Ubah Target Sukses');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function categoryDelete(Request $request, $id)
    {
        $target_category = TargetCategory::findOrFail($id);
        $target_subcategory = TargetSubCategory::where('id_category', $id);

        $target_category->delete();
        $target_subcategory->delete();

        $request->session()->flash('success', 'Hapus Kategory Target Sukses');
    }

    public function subCategoryDelete(Request $request, $id)
    {
        $target_subcategory = TargetSubCategory::findOrFail($id);
        $target_subcategory->delete();
        $request->session()->flash('success', 'Hapus Sub-Kategory Target Sukses');
    }

    public function getDetailVideo($url){

        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
        $youtube_id = $match[1];
        $data = @file_get_contents('https://youtube.googleapis.com/youtube/v3/videos?part=snippet&part=contentDetails&id='.$youtube_id.'&key=AIzaSyA2UU7k_-TfkmlyEG0DIiF-vVf54RQrFoQ');
        
        if (false===$data) return false;

        $obj = json_decode($data);
        return $obj->items[0];
    }

    public function printFile($service, $fileId) {
        dd($fileId);
    }
}
