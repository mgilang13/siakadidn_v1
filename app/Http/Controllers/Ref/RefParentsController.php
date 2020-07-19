<?php

namespace App\Http\Controllers\Ref;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Model\Ref\RefParents;
use App\Model\User;
use App\Model\Ref\RefStudent;
use App\Model\Core\RolesUsers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Image;

class RefParentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parents = DB::table('users as a')
                            ->join('parents as b', 'b.id_student', '=', 'a.id')
                            ->join('users as c', 'c.id', '=', 'b.id_parents')
                            ->select('b.id_parents', 'a.name as namasiswa', 'c.name as namaorangtua')
                            ->get();

        return view('ref.parent.index', compact('parents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $students = DB::table('users')
                        ->join('students', 'students.id_student', '=', 'users.id')
                        ->get();

        return view('ref.parent.create', compact('students'));
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
            'id_student' => '',
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
                'id_student' => 'required'
            ]);

            $id = $user->id;
            RefParents::create([
                'id_parents' => $id,
                'id_student' => request('id_student')
            ]);

            $params = [ 'roles_id' => $request->input('role'), 'users_id' => $user->id ];
            RolesUsers::create($params);
        });
        return redirect()->route('ref.parent.index')->with('success', 'Tambah Orang Tua Sukses');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Ref\Parents  $parents
     * @return \Illuminate\Http\Response
     */
    public function show(Parents $parents)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Ref\Parents  $parents
     * @return \Illuminate\Http\Response
     */
    public function edit(RefParents $parent)
    {
        $students = DB::table('users')
                        ->join('students', 'students.id_student', '=', 'users.id')
                        ->get();
        return view('ref.parent.edit', compact('parent', 'students'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Ref\Parents  $parents
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RefParents $parent)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,'.$parent->user->id,'NULL,id,deleted_at,NULL',
            'email' => 'required|string|max:255|email:rfc,dns|unique:users,email,'.$parent->user->id, 'NULL,id,deleted_at,NULL',
            'phone' => 'required|string|max:20|unique:users,phone,'.$parent->user->id, 'NULL,id,deleted_at,NULL',
            'name' => 'required|string|max:255',
            'password' => '',
            'gender' => 'required|in:l,p',
            'id_subject' => '',
            'role' => '',
            'image' => '',
            'birth_place' => '',
            'birth_date' => '',
            'address' => ''
        ]);
        DB::transaction(function () use ($parent, $request) {
            $params = $request->only(['username', 'email', 'phone', 'name', 'gender', 'birth_place', 'birth_date', 'address']);
            $params['password'] = bcrypt($request->input('password'));
            $parent->user->update($params);
            // update materi pelajaran
            $params = $request->only(['id_student']);
            $parent->update($params);

            // Jika update gambar
            $old_image_large_name = $parent->user->image_large;
            $old_image_medium_name = $parent->user->image_medium;
            $old_image_small_name = $parent->user->image_small;
            if ($request->file('image')) {
                $image = $request->file('image');

                $image_ext = "." . pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
                $upload_path = env('UPLOAD_USER').$parent->user->id;

                // Original Size Image
                $image_ori = "image_ori_".$parent->user->id.$image_ext;
                Storage::disk('public')->putFileAs($upload_path, $image, $image_ori);

                 // Tentukan gambar yang mau di-resize, gambar ori yg filname-nya sama otomatis akan terhapus
                 $resize_image = Image::make(public_path('storage/'.env('UPLOAD_USER').$parent->user->id."/".$image_ori));

                 // Large Image
                $image_lg = "image_lg_".$parent->user->id."_".date('YmdHis').$image_ext;
                $resize_image->resize(1024, null, function($constraint) {
                    $constraint->aspectRatio();
                });
                $resize_image->save(storage_path('app/public/'.env('UPLOAD_USER').$parent->user->id."/".$image_lg));
                // Update DB
                $parent->user->image_large = $upload_path."/".$image_lg;
                $parent->user->save();
                // Hapus gambar lama
                Storage::disk('public')->delete($old_image_large_name);

                // Medium Image
                $image_md = "image_md_".$parent->user->id."_".date('YmdHis').$image_ext;
                $resize_image->resize(512, null, function($constraint) {
                    $constraint->aspectRatio();
                });
                $resize_image->save(storage_path('app/public/'.env('UPLOAD_USER').$parent->user->id."/".$image_md));

                $parent->user->image_medium = $upload_path . "/" . $image_md;
                $parent->user->save();

                Storage::disk('public')->delete($old_image_medium_name);

                // Small Image
                $image_sm = "image_sm_".$parent->user->id."_".date('YmdHis').$image_ext;
                $resize_image->resize(512, null, function($constraint) {
                    $constraint->aspectRatio();
                });
                $resize_image->save(storage_path('app/public/'.env('UPLOAD_USER').$parent->user->id."/".$image_sm));

                $parent->user->image_small = $upload_path . "/" . $image_sm;
                $parent->user->save();

                Storage::disk('public')->delete($old_image_small_name);
            }
        });
        return redirect()->route('ref.parent.index')->with('success', 'Ubah Data Orang Tua Sukses');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Ref\Parents  $parents
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $parent = RefParents::findOrFail($id);
        
        DB::transaction(function() use ($parent) {
            $parent->user->delete();
            Storage::disk('public')->deleteDirectory('user/'.$parent->user->id);
        });
        return redirect()->route('ref.parent.index')->with('success', 'Hapus Data Orang Tua berhasil!');
    }

    public function showJson($id)
    {
        $parent = RefParents::findOrFail($id);
        return $parent->user->toJson();
    }
}
