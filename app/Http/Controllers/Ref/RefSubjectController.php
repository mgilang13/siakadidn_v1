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
        return view('ref.subject.index');
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
    public function edit(Subject $subject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject $subject)
    {
        // validasi
        $request->validate([
            'name' => 'required|string|max:255',
            'subject' => '',
            'description' => '',
        ]);
        $subject->update($request->only(['name', 'subject', 'description']));
        $request->session()->flash('success', 'Ubah Materi Sukses');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();
        $request->session()->flash('success', 'Hapus Materi Sukses');
    }
}
