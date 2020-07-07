<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Model\Core\Roles;
use App\Model\Core\RolesUsers;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

use Image;

class UsersController extends Controller
{

    /**
     * tampilan index
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $q = $request->query('q') ?: '';
        $rs_user = User::where('name', 'like', '%'.$q.'%')
                        ->orWhere('email', 'like', '%'.$q.'%')
                        // ->orWhere('phone', 'like', '%'.$q.'%')
                        ->orderBy('name', 'asc')
                        ->paginate(20);
        $rs_user->currentTotal = ($rs_user->currentPage() - 1) * $rs_user->perPage() + $rs_user->count();
        $rs_user->startNo = ($rs_user->currentPage() - 1) * $rs_user->perPage() + 1;
        $rs_user->no = ($rs_user->currentPage() - 1) * $rs_user->perPage() + 1;
        return view('core.users.index', compact('rs_user', 'q'));
    }

    /**
     * tampilan tambah user
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function add(Request $request)
    {
        $rs_role = Roles::all();
        return view('core.users.add', compact('rs_role'));
    }

    /**
     * proses tambah user
     *
     * @return void
     */
    public function addProcess(Request $request)
    {
        // validasi
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,NULL,id,deleted_at,NULL',
            'email' => 'required|string|max:255|email:rfc,dns|unique:users,email,NULL,id,deleted_at,NULL',
            'phone' => 'required|string|max:20|unique:users,phone,NULL,id,deleted_at,NULL',
            'name' => 'required|string|max:255',
            'password' => 'required|string',
            'gender' => 'required|in:l,p',
            'role' => 'exists:roles,id',
            'image' => '',
            'birth_place' => '',
            'birth_date' => '',
            'address' => ''
        ]);
        DB::transaction(function () use ($request) {
            $params = $request->only(['username', 'email', 'name', 'phone', 'gender', 'birth_place', 'birth_date', 'address']);
            $params['password'] = bcrypt($request->input('password'));
            $user = User::create($params);

            // jika upload foto
            if ($request->file('image')) {
                // new image
                $image = $request->file('image');
                $image_ext = "." . pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
                $upload_path =  env('UPLOAD_TEACHER').$user->id;

                
                // Original Image
                $image_ori = "image_ori_".$user->id.$image_ext;
                Storage::disk('public')->putFileAs($upload_path, $image, $image_ori);
                
                $resize_image = Image::make(public_path('storage/'.env('UPLOAD_TEACHER').$user->id."/".$image_ori));
                
                // Large Image
                $image_lg = "image_lg_".$user->id."_".date('YmdHis').$image_ext;
                $resize_image->resize(1024, null, function($constraint) {
                    $constraint->aspectRatio();
                });
                $resize_image->save(storage_path('app/public/'.env('UPLOAD_TEACHER').$user->id."/".$image_lg));

                $user->image_large = $upload_path . "/" . $image_lg;
                $user->save();

                // Medim Image
                $image_md = "image_md_".$user->id."_".date('YmdHis').$image_ext;
                $resize_image->resize(512, null, function($constraint) {
                    $constraint->aspectRatio();
                });
                $resize_image->save(storage_path('app/public/'.env('UPLOAD_TEACHER').$user->id."/".$image_md));

                $user->image_medium = $upload_path . "/" . $image_md;
                $user->save();

                // Small Image
                $image_sm = "image_sm_".$user->id."_".date('YmdHis').$image_ext;
                $resize_image->resize(128, null, function($constraint) {
                    $constraint->aspectRatio();
                });
                $resize_image->save(storage_path('app/public/'.env('UPLOAD_TEACHER').$user->id."/".$image_sm));

                $user->image_small = $upload_path . "/" . $image_sm;
                $user->save();
            }
            // role
            $params = [ 'roles_id' => $request->input('role'), 'users_id' => $user->id ];
            RolesUsers::create($params);
        });
        return redirect()->route('core.users')->with('success', 'Tambah User Sukes');
    }

    /**
     * tampilan edit user
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(Request $request, User $user)
    {
        $rs_role = Roles::all();
        return view('core.users.edit', compact('user', 'rs_role'));
    }

    /**
     * proses edit user
     *
     * @return void
     */
    public function editProcess(Request $request, User $user)
    {
        // validasi
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' .$user->id. ',id,deleted_at,NULL',
            'email' => 'required|string|max:255|email:rfc,dns|unique:users,email,' .$user->id. ',id,deleted_at,NULL',
            // 'phone' => 'required|string|max:20|unique:users,phone,' .$user->id. ',id,deleted_at,NULL',
            'name' => 'required|string|max:255',
            'password' => '',
            'role' => 'exists:roles,id',
        ]);
        DB::transaction(function () use ($request, $user) {
            $params = $request->only(['username', 'email', 'name', 'status']);
            // jika password diganti
            if($request->input('password')) $params['password'] = bcrypt($request->input('password'));
            $user->update($params);
            // jika upload foto
            if ($request->file('image')) {
                // delete old image
                $old_image = $user->image;
                // new image
                $image = $request->file('image');
                $image_name = "." . pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
                $image_name = "profile_" . $user->id . "_" . date('YmdHis') . $image_name;
                // upload gambar
                $upload_path = "profile";
                if (Storage::disk('public')->putFileAs($upload_path, $image, $image_name)) {
                    // delete old image
                    Storage::disk('public')->delete($old_image);
                    // update db
                    $user->image = $upload_path . "/" . $image_name;
                    $user->save();
                }
            }
            // role
            $params = ['roles_id' => $request->input('role')];
            $where = ['users_id' => $user->id];
            RolesUsers::updateOrCreate($where, $params);
        });
        return redirect()->route('core.users')->with('success', 'Ubah User Sukes');
    }

    /**
     * tampilan hapus user
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function delete(Request $request, User $user)
    {
        return view('core.users.delete', compact('user'));
    }

    /**
     * proses hapus user
     *
     * @return void
     */
    public function deleteProcess(Request $request, User $user)
    {
        // jika ada foto
        if ($user->image) {
            // delete image
            Storage::disk('public')->delete($user->image);
        }
        if ($user->delete()) {
            return redirect()->route('core.users')->with('success', 'Hapus User Sukes');
        } else {
            return redirect()->route('core.users')->with('error', 'Hapus User Gagal');
        }
        
    }

}
