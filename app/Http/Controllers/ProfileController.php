<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Storage;
use Image;

class ProfileController extends Controller
{

    /**
     * Show the application profile.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('profile');
    }

    /**
     * updateProcess
     *
     * @return redirect
     */
    public function updateProcess(Request $request)
    {
        // set user
        $user = Auth::user();
        // validasi
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $user->id . ',id,deleted_at,NULL',
            'email' => '',
            'name' => 'required|string|max:255',
            'phone' => '',
            'password' => '',
        ]);
        DB::transaction(function () use ($request, $user) {
            $params = $request->only(['username', 'email', 'name', 'phone']);
            // jika password diganti
            if ($request->input('password')) $params['password'] = bcrypt($request->input('password'));
            $user->update($params);

            // Jika update gambar
            $old_image_large_name = $user->image_large;
            $old_image_medium_name = $user->image_medium;
            $old_image_small_name = $user->image_small;

            if ($request->file('image')) {
                $image = $request->file('image');
                $image_ext = "." . pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
                $upload_path = env('UPLOAD_USER').$user->id;
                
                // Original Size Image
                $image_ori = "image_ori_".$user->id.$image_ext;
                Storage::disk('public')->putFileAs($upload_path, $image, $image_ori);
                
                 // Tentukan gambar yang mau di-resize, gambar ori yg filname-nya sama otomatis akan terhapus
                $resize_image = Image::make(public_path('storage/'.env('UPLOAD_USER').$user->id."/".$image_ori));
                
                 // Large Image
                $image_lg = "image_lg_".$user->id."_".date('YmdHis').$image_ext;
                $resize_image->resize(1024, null, function($constraint) {
                    $constraint->aspectRatio();
                });
                $resize_image->save(storage_path('app/public/'.env('UPLOAD_USER').$user->id."/".$image_lg));
                
                // Update DB
                $user->image_large = $upload_path."/".$image_lg;
                $user->save();
                
                // Hapus gambar lama
                Storage::disk('public')->delete($old_image_large_name);

                // Medium Image
                $image_md = "image_md_".$user->id."_".date('YmdHis').$image_ext;
                $resize_image->resize(512, null, function($constraint) {
                    $constraint->aspectRatio();
                });
                $resize_image->save(storage_path('app/public/'.env('UPLOAD_USER').$user->id."/".$image_md));

                $user->image_medium = $upload_path . "/" . $image_md;
                $user->save();

                Storage::disk('public')->delete($old_image_medium_name);

                // Small Image
                $image_sm = "image_sm_".$user->id."_".date('YmdHis').$image_ext;
                $resize_image->resize(128, null, function($constraint) {
                    $constraint->aspectRatio();
                });
                $resize_image->save(storage_path('app/public/'.env('UPLOAD_USER').$user->id."/".$image_sm));

                $user->image_small = $upload_path . "/" . $image_sm;
                $user->save();

                Storage::disk('public')->delete($old_image_small_name);
            }
        });
        return redirect()->route('profile')->with('success', 'Ubah Data Profil Sukses');
    }

}
