<?php

namespace App\Http\Controllers\Ref;

use App\Http\Controllers\Controller;

use App\Model\Ref\RefDay;

use Illuminate\Http\Request;

class RefDayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $days = RefDay::all();

        return view('ref.day.index', compact('days'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ref.day.create');
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
            'name' => 'required'
        ]);

        RefDay::create($validateData);
        return redirect()->route('ref.day.index')->with('success', 'Tambah Hari Sukses');
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
    public function edit(RefDay $day)
    {
        return view('ref.day.edit',compact('day'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RefDay $day)
    {
        $validateData = $request->validate([
            'name' => 'required'
        ]);

        $day->update($validateData);
        return redirect()->route('ref.day.index')->with('success', 'Ubah Hari Sukses');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(RefDay $day)
    {
        $day->delete();

        return redirect()->route('ref.day.index')->with('success', 'Hapus Hari Sukses');
    }

    public function showJson($id)
    {
        $day = RefDay::findOrFail($id);

        return $day->toJson();
    }
}
