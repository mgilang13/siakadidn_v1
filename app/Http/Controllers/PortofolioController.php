<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\User;
use App\Model\Portofolio\Portofolio;
use App\Model\Portofolio\PortofolioType;
use App\Model\Portofolio\PortofolioImage;
use App\Model\Portofolio\PortofolioApp;

use App\Model\SupportApps;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PortofolioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $student = Auth::user();
        
        $portofolios =  Portofolio::with(['portofolio_app.support_app', 'portofolio_image', 'portofolio_type'])->get();
        // dd($portofolios);
        return view('portofolio.index', compact('student', 'portofolios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = PortofolioType::all();
        $support_apps = SupportApps::all();
        // dd($support_apps);
        return view('portofolio.create', compact('types', 'support_apps'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = Auth::user()->id;
        
        $validateData = $request->validate([
            'id_student' => '',
            'name' => 'required',
            'id_type' => '',
            'publication_link' => '',
            'repo_link' => '',
            'description' => '',
        ]);
        
        $portofolio = Portofolio::create($validateData);
        $portofolio->id_student = $id;
        $portofolio->save();
        
        $support_apps = $request->input('support_apps');

        $images = $request->file('image');

        
        foreach($images as $index => $image) {
            $image_ext = "." . pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
            $image_name = "portofolio_".$portofolio->id.$index.$image_ext;
            $upload_path =  env('UPLOAD_PORTOFOLIO').$id.$portofolio->id;

            Storage::disk('public')->putFileAs($upload_path, $image, $image_name);
            
            PortofolioImage::create([
                'id_portofolio' => $portofolio->id,
                'image' => $id.$portofolio->id."/".$image_name
            ]);
        }

        foreach($support_apps as $support_app) {
            PortofolioApp::create([
                'id_portofolio' => $portofolio->id,
                'id_support_app' => (int)$support_app
            ]);
        }

        
        
        return redirect()->route('portofolio.index')->with('success', 'Tambah Portofolio Sukses');;
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
    public function update(Request $request, $id)
    {
        //
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
}
