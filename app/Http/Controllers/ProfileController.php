<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
            'email' => 'required|string|max:255|email:rfc,dns|unique:users,email,' . $user->id . ',id,deleted_at,NULL',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:users,phone,' . $user->id . ',id,deleted_at,NULL',
            'password' => '',
        ]);
        DB::transaction(function () use ($request, $user) {
            $params = $request->only(['username', 'email', 'name']);
            // jika password diganti
            if ($request->input('password')) $params['password'] = bcrypt($request->input('password'));
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
        });
        return redirect()->back()->with('success', 'Update Profil Sukes');
    }

}
