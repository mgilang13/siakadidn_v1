<?php

namespace App\Http\Controllers\Ref;

use App\Http\Controllers\Controller;
use App\Model\Ref\RefMatter;
use App\Model\Ref\RefMatterDetail;
use App\Model\Ref\RefSubject;
use App\Model\Ref\RefLevel;


use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class RefMatterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $matter_details = null;
        $matter_show = null;

        $q = $request->query('q') ?: '';
        $qLevel = $request->query('id_level') ?: '';
        $qSubject = $request->query('id_subject') ?: '';

        $matters = DB::table('matters')
                        ->join('subjects', 'matters.id_subject', '=', 'subjects.id')
                        ->select('matters.*', 'subjects.id as subjectID', 'subjects.name as subjectName', 'subjects.description as subjectDesc')
                        ->where('matters.name', 'like', '%'.$q.'%')
                        ->where('matters.id_level','like', '%'.$qLevel)
                        ->where('matters.id_subject', 'like', '%'.$qSubject)
                        ->paginate(20);
        
        $levels = RefLevel::all();
        $subjects = RefSubject::all();

        $matters->currentTotal = ($matters->currentPage() - 1) * $matters->perPage() + $matters->count();
        $matters->startNo = ($matters->currentPage() - 1) * $matters->perPage() + 1;
        $matters->no = ($matters->currentPage() - 1) * $matters->perPage() + 1;
        
        $subjects = RefSubject::all();
        return view('ref.matter.index', compact('matters', 'subjects', 'matter_details', 'matter_show', 'q', 'levels', 'qLevel', 'qSubject'));
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
            'id_level' => '',
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
    public function show(Request $request, RefMatter $matter)
    {
        $q = $request->query('q') ?: '';
        $qLevel = $request->query('id_level') ?: '';
        $qSubject = $request->query('id_subject') ?: '';

        $matter_details = DB::table('matter_details as md')
                            ->join('matters as m', 'm.id', '=', 'md.id_matter')
                            ->where('md.id_matter', $matter->id)
                            ->select('md.name as name', 'md.id as id', 'md.seq')
                            ->orderBy('md.seq', 'asc')
                            ->get();
        // dd($matter_details);
        $matters = DB::table('matters')
                        ->join('subjects', 'matters.id_subject', '=', 'subjects.id')
                        ->select('matters.*', 'subjects.id as subjectID', 'subjects.name as subjectName', 'subjects.description as subjectDesc')
                        ->where('matters.name', 'like', '%'.$q.'%')
                        ->where('matters.id_level', 'like', '%'.$qLevel)
                        ->where('matters.id_subject','like', '%'.$qSubject)
                        ->paginate(20);

        $matters->currentTotal = ($matters->currentPage() - 1) * $matters->perPage() + $matters->count();
        $matters->startNo = ($matters->currentPage() - 1) * $matters->perPage() + 1;
        $matters->no = ($matters->currentPage() - 1) * $matters->perPage() + 1;
    
        $levels = RefLevel::all();
        $subjects = RefSubject::all();

        $matter_show = $matter;

        return view('ref.matter.index', compact('matter_show', 'matters', 'subjects', 'matter_details', 'q', 'levels', 'qLevel', 'qSubject'));
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

    public function matterSubStore(Request $request)
    {
        $validateData = $request->validate([
            'id_matter' => '',
            'name' => '',
            'seq' => ''
        ]);
        RefMatterDetail::create($validateData);
        $request->session()->flash('success', 'Tambah Sub Materi Sukses');
    }

    public function matterSubUpdate(Request $request, RefMatterDetail $matter_detail)
    {
        // validasi
        $validateData = $request->validate([
            'name' => 'required|string|max:255',
            'seq' => ''
        ]);

        $matter_detail->update($validateData);
        $request->session()->flash('success', 'Ubah Sub Materi Sukses');
    }

    public function matterSubDelete(Request $request, RefMatterDetail $matter_detail) {
        $matter_detail->delete();
        $request->session()->flash('success', 'Hapus Sub Materi Sukses');
    }
}
