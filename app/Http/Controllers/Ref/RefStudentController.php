<?php

namespace App\Http\Controllers\Ref;

use App\Http\Controllers\Controller;
use App\Model\Ref\RefStudent;
use App\Model\Ref\RefHalaqah;
use App\Model\Core\Roles;
use App\Model\Core\RolesUsers;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Image;

class RefStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = Roles::findOrFail(4)->users()->orderBy('name', 'asc')->get();
        // $users = User::all();
        $halaqahs = RefHalaqah::all();
        $user_students = DB::table('users')
                        ->join('students', 'students.id_student', '=', 'users.id')
                        ->get();
        
        return view('ref.student.index', compact('users', 'user_students', 'halaqahs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $halaqahs = RefHalaqah::all();
        return view('ref.student.create', compact('halaqahs'));
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
                'id_student' => '',
                'nisn' => 'required|unique:students,nisn,NULL,id,deleted_at,NULL',
                'nis' => 'required|unique:students,nis,NULL,id,deleted_at,NULL',
                'id_halaqah' => '',
                'entry_date' => '',
                'hafalan_pra_idn' => '',
                'target_hafalan' => '',
                'father_name' => '',
                'father_job' => '',
                'mother_name' => '',
                'mother_job' => ''
            ]);
            $id = $user->id;
            RefStudent::create([
                'id_student' => $id,
                'nisn' => request('nisn'),
                'nis' => request('nis'),
                'id_halaqah' => request('id_halaqah'),
                'entry_date' => request('entry_date'),
                'hafalan_pra_idn' => request('hafalan_pra_idn'),
                'target_hafalan' => request('target_hafalan'),
                'father_name' => request('father_name'),
                'father_job' => request('father_job'),
                'mother_name' => request('mother_name'),
                'mother_job' => request('mother_job'),
            ]);
            
            $params = [ 'roles_id' => $request->input('role'), 'users_id' => $user->id ];
            RolesUsers::create($params);
        });

        
        return redirect()->route('ref.student.index')->with('success', 'Tambah Murid Sukses');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Ref\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Ref\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(RefStudent $student)
    {
        $halaqahs = RefHalaqah::all();
        return view('ref.student.edit', compact('student', 'halaqahs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Ref\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RefStudent $student)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,'.$student->user->id,'NULL,id,deleted_at,NULL',
            'email' => 'required|string|max:255|email:rfc,dns|unique:users,email,'.$student->user->id,'NULL,id,deleted_at,NULL',
            'phone' => 'required|string|max:20|unique:users,phone,'.$student->user->id,'NULL,id,deleted_at,NULL',
            'name' => 'required|string|max:255',
            'password' => '',
            'gender' => 'required|in:l,p',
            'role' => '',
            'image' => '',
            'birth_place' => '',
            'birth_date' => '',
            'address' => ''
        ]);
        DB::transaction(function () use ($student, $request) {
            $params = $request->only(['username', 'email', 'phone', 'name', 'gender', 'birth_place', 'birth_date', 'address']);
            $params['password'] = bcrypt($request->input('password'));
            $student->user->update($params);
            // update materi pelajaran
            $params = $request->only(['id_student']);
            $student->update($params);

            // Jika update gambar
            $old_image_large_name = $student->user->image_large;
            $old_image_medium_name = $student->user->image_medium;
            $old_image_small_name = $student->user->image_small;
            if ($request->file('image')) {
                $image = $request->file('image');

                $image_ext = "." . pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
                $upload_path = env('UPLOAD_USER').$student->user->id;

                // Original Size Image
                $image_ori = "image_ori_".$student->user->id.$image_ext;
                Storage::disk('public')->putFileAs($upload_path, $image, $image_ori);

                 // Tentukan gambar yang mau di-resize, gambar ori yg filname-nya sama otomatis akan terhapus
                 $resize_image = Image::make(public_path('storage/'.env('UPLOAD_USER').$student->user->id."/".$image_ori));

                 // Large Image
                $image_lg = "image_lg_".$student->user->id."_".date('YmdHis').$image_ext;
                $resize_image->resize(1024, null, function($constraint) {
                    $constraint->aspectRatio();
                });
                $resize_image->save(storage_path('app/public/'.env('UPLOAD_USER').$student->user->id."/".$image_lg));
                // Update DB
                $student->user->image_large = $upload_path."/".$image_lg;
                $student->user->save();
                // Hapus gambar lama
                Storage::disk('public')->delete($old_image_large_name);

                // Medium Image
                $image_md = "image_md_".$student->user->id."_".date('YmdHis').$image_ext;
                $resize_image->resize(512, null, function($constraint) {
                    $constraint->aspectRatio();
                });
                $resize_image->save(storage_path('app/public/'.env('UPLOAD_USER').$student->user->id."/".$image_md));

                $student->user->image_medium = $upload_path . "/" . $image_md;
                $student->user->save();

                Storage::disk('public')->delete($old_image_medium_name);

                // Small Image
                $image_sm = "image_sm_".$student->user->id."_".date('YmdHis').$image_ext;
                $resize_image->resize(512, null, function($constraint) {
                    $constraint->aspectRatio();
                });
                $resize_image->save(storage_path('app/public/'.env('UPLOAD_USER').$student->user->id."/".$image_sm));

                $student->user->image_small = $upload_path . "/" . $image_sm;
                $student->user->save();

                Storage::disk('public')->delete($old_image_small_name);
            }

            $validateStudent = $request->validate([
                'id_student' => '',
                'nisn' => '',
                'nis' => '',
                'id_halaqah' => '',
                'entry_date' => '',
                'hafalan_pra_idn' => '',
                'target_hafalan' => '',
                'father_name' => '',
                'father_job' => '',
                'mother_name' => '',
                'mother_job' => ''
            ]);
            $student->update($validateStudent);
        });
        return redirect()->route('ref.student.index')->with('success', 'Ubah Data Murid Sukses');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Ref\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = RefStudent::findOrFail($id);
        
        DB::transaction(function() use ($student) {
            $student->user->delete();
            Storage::disk('public')->deleteDirectory('users/'.$student->user->id);
        });
        return redirect()->route('ref.student.index')->with('success', 'Hapus Data Murid berhasil!');
    }

    public function showJson($id)
    {
        $student = RefStudent::findOrFail($id);
        return $student->user->toJson();
    }
}

