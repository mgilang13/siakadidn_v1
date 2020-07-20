<?php

namespace App\Http\Controllers\Ref;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Model\Ref\RefTeacher;
use App\Model\Ref\RefSubject;
use App\Model\User;
use App\Model\Core\Roles;
use App\Model\Core\RolesUsers;

use Illuminate\Support\Facades\Storage;
use Image;

use Illuminate\Http\Request;

class RefTeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $subjects = RefSubject::all();
        $users = Roles::findOrFail(3)->users()->get();
        $q = $request->query('q') ?: '';
        $teacher_subjects = DB::table('teachers')
                                ->join('users', 'teachers.id_teacher', '=', 'users.id')
                                ->where('users.name', 'like', '%'.$q.'%')
                                ->join('subjects', 'teachers.id_subject', '=', 'subjects.id')
                                ->select('users.id as teacherID','users.name as userName', 'subjects.name as subjectName', 'subject')
                                ->paginate(20);
        
        $teacher_subjects->currentTotal = ($teacher_subjects->currentPage() - 1) * $teacher_subjects->perPage() + $teacher_subjects->count();
        $teacher_subjects->startNo = ($teacher_subjects->currentPage() - 1) * $teacher_subjects->perPage() + 1;
        $teacher_subjects->no = ($teacher_subjects->currentPage() - 1) * $teacher_subjects->perPage() + 1;


        foreach($teacher_subjects as $ts) {
            if($ts->subject == "it") {
                $ts->subject = "Komputer dan Informatika";
            } else if ($ts->subject == "din") {
                $ts->subject = "Ilmu Agama";
            } else {
                $ts->subject = "Bahasa Inggris";
            }
        }

        return view('ref.teacher.index', compact('q', 'users', 'subjects', 'teacher_subjects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $subjects = RefSubject::all();
        return view('ref.teacher.create', compact('subjects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,NULL,id,deleted_at,NULL',
            'email' => 'required|string|max:255|email:rfc,dns|unique:users,email,NULL,id,deleted_at,NULL',
            'phone' => 'required|string|max:20|unique:users,phone,NULL,id,deleted_at,NULL',
            'name' => 'required|string|max:255',
            'password' => 'required|string',
            'gender' => 'required|in:l,p',
            'id_subject' => 'required',
            'role' => '',
            'image' => '',
            'birth_place' => '',
            'birth_date' => '',
            'address' => ''
        ]);
        DB::transaction(function () use ($request) {
            $params = $request->only(['username', 'email', 'phone', 'name', 'gender', 'birth_place', 'birth_date', 'address']);
            $params['password'] = bcrypt($request->input('password'));
            $user = User::create($params);

             // jika upload foto
             if ($request->file('image')) {
                // new image
                $image = $request->file('image');
                $image_ext = "." . pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
                $upload_path =  env('UPLOAD_USER').$user->id;

                
                // Original Image
                $image_ori = "image_ori_".$user->id.$image_ext;
                Storage::disk('public')->putFileAs($upload_path, $image, $image_ori);
                
                $resize_image = Image::make(public_path('storage/'.env('UPLOAD_USER').$user->id."/".$image_ori));
                
                // Large Image
                $image_lg = "image_lg_".$user->id."_".date('YmdHis').$image_ext;
                $resize_image->resize(1024, null, function($constraint) {
                    $constraint->aspectRatio();
                });
                $resize_image->save(storage_path('app/public/'.env('UPLOAD_USER').$user->id."/".$image_lg));

                $user->image_large = $upload_path . "/" . $image_lg;
                $user->save();

                // Medim Image
                $image_md = "image_md_".$user->id."_".date('YmdHis').$image_ext;
                $resize_image->resize(512, null, function($constraint) {
                    $constraint->aspectRatio();
                });
                $resize_image->save(storage_path('app/public/'.env('UPLOAD_USER').$user->id."/".$image_md));

                $user->image_medium = $upload_path . "/" . $image_md;
                $user->save();

                // Small Image
                $image_sm = "image_sm_".$user->id."_".date('YmdHis').$image_ext;
                $resize_image->resize(128, null, function($constraint) {
                    $constraint->aspectRatio();
                });
                $resize_image->save(storage_path('app/public/'.env('UPLOAD_USER').$user->id."/".$image_sm));

                $user->image_small = $upload_path . "/" . $image_sm;
                $user->save();
            }

            $validateStudent = $request->validate([
                'id_subject' => 'required'
            ]);

            $id = $user->id;
            RefTeacher::create([
                'id_teacher' => $id,
                'id_subject' => request('id_subject')
            ]);

            $params = [ 'roles_id' => $request->input('role'), 'users_id' => $user->id ];
            RolesUsers::create($params);
        });
        return redirect()->route('ref.teacher.index')->with('success', 'Tambah Guru Sukses');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show(Teacher $teacher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $teacher = RefTeacher::findOrFail($id);
        $subjects = RefSubject::all();
        return view('ref.teacher.edit', compact('teacher', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RefTeacher $teacher)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,'.$teacher->user->id,'NULL,id,deleted_at,NULL',
            'email' => 'required|string|max:255|email:rfc,dns|unique:users,email,'.$teacher->user->id, 'NULL,id,deleted_at,NULL',
            'phone' => 'required|string|max:20|unique:users,phone,'.$teacher->user->id, 'NULL,id,deleted_at,NULL',
            'name' => 'required|string|max:255',
            'password' => '',
            'gender' => 'required|in:l,p',
            'id_subject' => 'required',
            'role' => '',
            'image' => '',
            'birth_place' => '',
            'birth_date' => '',
            'address' => ''
        ]);

        DB::transaction(function () use ($teacher, $request) {
            $params = $request->only(['username', 'email', 'phone', 'name', 'gender', 'birth_place', 'birth_date', 'address']);
            $params['password'] = bcrypt($request->input('password'));
            $teacher->user->update($params);

            // update materi pelajaran
            $params = $request->only(['id_subject']);
            $teacher->update($params);

            // Jika update gambar
            $old_image_large_name = $teacher->user->image_large;
            $old_image_medium_name = $teacher->user->image_medium;
            $old_image_small_name = $teacher->user->image_small;

            if ($request->file('image')) {
                $image = $request->file('image');

                $image_ext = "." . pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
                $upload_path = env('UPLOAD_USER').$teacher->user->id;

                // Original Size Image
                $image_ori = "image_ori_".$teacher->user->id.$image_ext;
                Storage::disk('public')->putFileAs($upload_path, $image, $image_ori);

                 // Tentukan gambar yang mau di-resize, gambar ori yg filname-nya sama otomatis akan terhapus
                 $resize_image = Image::make(public_path('storage/'.env('UPLOAD_USER').$teacher->user->id."/".$image_ori));

                 // Large Image
                $image_lg = "image_lg_".$teacher->user->id."_".date('YmdHis').$image_ext;
                $resize_image->resize(1024, null, function($constraint) {
                    $constraint->aspectRatio();
                });
                $resize_image->save(storage_path('app/public/'.env('UPLOAD_USER').$teacher->user->id."/".$image_lg));
                // Update DB
                $teacher->user->image_large = $upload_path."/".$image_lg;
                $teacher->user->save();
                // Hapus gambar lama
                Storage::disk('public')->delete($old_image_large_name);

                // Medium Image
                $image_md = "image_md_".$teacher->user->id."_".date('YmdHis').$image_ext;
                $resize_image->resize(512, null, function($constraint) {
                    $constraint->aspectRatio();
                });
                $resize_image->save(storage_path('app/public/'.env('UPLOAD_USER').$teacher->user->id."/".$image_md));

                $teacher->user->image_medium = $upload_path . "/" . $image_md;
                $teacher->user->save();

                Storage::disk('public')->delete($old_image_medium_name);

                // Small Image
                $image_sm = "image_sm_".$teacher->user->id."_".date('YmdHis').$image_ext;
                $resize_image->resize(512, null, function($constraint) {
                    $constraint->aspectRatio();
                });
                $resize_image->save(storage_path('app/public/'.env('UPLOAD_USER').$teacher->user->id."/".$image_sm));

                $teacher->user->image_small = $upload_path . "/" . $image_sm;
                $teacher->user->save();

                Storage::disk('public')->delete($old_image_small_name);
            }
        });
        return redirect()->route('ref.teacher.index')->with('success', 'Ubah Data Guru Sukses');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $teacher = RefTeacher::findOrFail($id);
        
        DB::transaction(function() use ($teacher) {
            $teacher->user->delete();
            Storage::disk('public')->deleteDirectory('users/'.$teacher->user->id);
        });
        return redirect()->route('ref.teacher.index')->with('success', 'Hapus Data Guru berhasil!');
    }

    public function showJson($id)
    {
        $teacher = RefTeacher::findOrFail($id);
        return $teacher->user->toJson();
    }
}
