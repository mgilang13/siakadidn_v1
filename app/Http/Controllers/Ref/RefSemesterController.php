<?php

namespace App\Http\Controllers\Ref;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Ref\RefSemester;

class RefSemesterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $semesters = RefSemester::all();

        return view('ref.semester.index', compact('semesters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ref.semester.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required',
            'information' => '',
            'status' => 'required'
        ]);

        RefSemester::create($validateData);
        return redirect()->route('ref.semester.index')->with('success', 'Tambah Semester Sukses');
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
    public function edit(RefSemester $semester)
    {
        return view('ref.semester.edit', compact('semester'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RefSemester $semester)
    {
        $validateData = $request->validate([
            'name' => 'required',
            'information' => '',
            'status' => 'required'
        ]);

        $semester->update($validateData);
        return redirect()->route('ref.semester.index')->with('success', 'Ubah Semester Sukses');
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
