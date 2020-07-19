<?php

namespace App\Http\Controllers\Ref;

use App\Http\Controllers\Controller;
use App\Model\Ref\RefSubject;
use Illuminate\Http\Request;

class RefSubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects = RefSubject::all();
        foreach($subjects as $subject) {
            if($subject->subject == "it") {
                $subject->subject = "Komputer dan Informatika";
            } else if ($subject->subject == "din") {
                $subject->subject = "Ilmu Agama";
            } else {
                $subject->subject = "Bahasa Inggris";
            }
        }
        return view('ref.subject.index', compact('subjects'));
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
            'subject' => '',
            'description' => '',
        ]);
        RefSubject::create($request->only(['name', 'subject', 'description']));
        
        $request->session()->flash('success', 'Tambah Materi Sukses');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function edit(RefSubject $subject)
    {
        return view('ref.subject.edit', compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RefSubject $subject)
    {
        // validasi
        $validateData = $request->validate([
            'name' => 'required|string|max:255',
            'subject' => '',
            'description' => '',
        ]);
        $subject->update($validateData);

        return redirect()->route('ref.subject.index')->with('success', 'Ubah Materi Pelajaran berhasil!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(RefSubject $subject)
    {
        $subject->delete();
        return redirect()->route('ref.subject.index')->with('success', 'Hapus Materi Pelajaran berhasil!');
    }

    public function showJson($id)
    {
        $subject = RefSubject::findOrFail($id);
        return $subject->toJson();
    }
}
