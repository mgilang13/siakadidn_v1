<?php

namespace App\Http\Controllers\Ref;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Ref\RefStudyTime;

class RefStudyTimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $studytimes = RefStudyTime::all();

        return view('ref.studytime.index', compact('studytimes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ref.studytime.create');
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
            'start_time' => '',
            'end_time' => '',
            'information' => '',
        ]);

        RefStudyTime::create($validateData);

        return redirect()->route('ref.studytime.index')->with('success', 'Tambah Jam Pelajaran Sukses');
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
    public function edit(RefStudyTime $studytime)
    {
        return view('ref.studytime.edit', compact('studytime'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RefStudyTime $studytime)
    {
        $validateData = $request->validate([
            'name' => 'required',
            'start_time' => '',
            'end_time' => '',
            'information' => '',
        ]);

        $studytime->update($validateData);

        return redirect()->route('ref.studytime.index')->with('success', 'Ubah Jam Pelajaran Sukses');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(RefStudyTime $studytime)
    {
        $studytime->delete();
        return redirect()->route('ref.studytime.index')->with('success', 'Hapus Jam Pelajaran Sukses');
    }

    public function showJson($id)
    {
        $studytime = RefStudyTime::findOrFail($id);

        return $studytime->toJson();
    }
}
