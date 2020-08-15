<?php

namespace App\Http\Controllers\Ref;

use App\Http\Controllers\Controller;
use App\Model\Ref\RefSchoolYear;
use Illuminate\Http\Request;

class RefSchoolYearController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schoolyears = RefSchoolYear::all();

        return view('ref.schoolyear.index', compact('schoolyears'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ref.schoolyear.create');
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
            'semester' => 'required',
            'status' => 'required'
        ]);

        RefSchoolYear::create($validateData);
        return redirect()->route('ref.schoolyear.index')->with('success', 'Tambah Tahun Ajaran Sukses');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Ref\SchoolYear  $schoolYear
     * @return \Illuminate\Http\Response
     */
    public function show(SchoolYear $schoolYear)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Ref\SchoolYear  $schoolYear
     * @return \Illuminate\Http\Response
     */
    public function edit(RefSchoolYear $schoolyear)
    {
        return view('ref.schoolyear.edit', compact('schoolyear'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Ref\SchoolYear  $schoolYear
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RefSchoolYear $schoolyear)
    {
        $validateData = $request->validate([
            'name' => 'required',
            'semester' => 'required',
            'status' => 'required'
        ]);

        $schoolyear->update($validateData);
        return redirect()->route('ref.schoolyear.index')->with('success', 'Ubah Tahun Ajaran Sukses');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Ref\SchoolYear  $schoolYear
     * @return \Illuminate\Http\Response
     */
    public function destroy(RefSchoolYear $schoolyear)
    {
        $schoolyear->delete();

        return redirect()->route('ref.schoolyear.index')->with('success', 'Hapus Tahun Ajaran Sukses');
    }

    public function showJson($id)
    {
        $schoolyear = RefSchoolYear::findOrFail($id);

        return $schoolyear->toJson();
    }
}
