<?php

namespace App\Http\Controllers\Ref;

use App\Http\Controllers\Controller;
use App\Model\Ref\RefMatter;
use App\Model\Ref\RefSubject;


use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class RefMatterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $matters = DB::table('matters')
                                ->join('subjects', 'matters.id_subject', '=', 'subjects.id')
                                ->select('matters.*', 'subjects.id as subjectID', 'subjects.name as subjectName', 'subjects.description as subjectDesc')
                                ->get();

        $subjects = RefSubject::all();

        return view('ref.matter.index', compact('matters', 'subjects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validasi     
        $request->validate([
            'name' => 'required|string|max:255',
            'id_subject' => '',
            'description' => '',
        ]);
        RefMatter::create($request->only(['name', 'id_subject', 'description']));
        
        $request->session()->flash('success', 'Tambah Materi Sukses');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\matter  $matter
     * @return \Illuminate\Http\Response
     */
    public function show(matter $matter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\matter  $matter
     * @return \Illuminate\Http\Response
     */
    public function edit(RefMatter $matter)
    {
        $subjects = RefSubject::all();
        return view('ref.matter.edit', compact('matter', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\matter  $matter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RefMatter $matter)
    {
        // validasi
        $validateData = $request->validate([
            'name' => 'required|string|max:255',
            'id_subject' => '',
            'description' => '',
        ]);
        $matter->update($validateData);

        return redirect()->route('ref.matter.index')->with('success', 'Ubah Materi Pelajaran berhasil!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\matter  $matter
     * @return \Illuminate\Http\Response
     */
    public function destroy(RefMatter $matter)
    {
        $matter->delete();
        return redirect()->route('ref.matter.index')->with('success', 'Hapus Materi Pelajaran berhasil!');
    }

    public function showJson($id)
    {
        $matter = RefMatter::findOrFail($id);
        return $matter->toJson();
    }
}
