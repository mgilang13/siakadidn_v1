<?php

namespace App\Http\Controllers\Ref;
use App\Http\Controllers\Controller;

use App\Model\Ref\RefLevel;
use App\Model\Ref\RefLevelDetail;

use Illuminate\Http\Request;


class RefLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $levels = RefLevel::all();
        $level_details = RefLevelDetail::all();

        return view('ref.level.index', compact('levels', 'level_details'));
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
            'abbr' => '',
        ]);
        RefLevel::create($request->only(['name', 'abbr']));
        
        $request->session()->flash('success', 'Tambah Jenjang Pendidikan Sukses');
    }

    public function levelDetailStore(Request $request)
    {
        // validasi     
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => '',
        ]);
        RefLevelDetail::create($request->only(['name', 'address']));
        
        $request->session()->flash('success', 'Tambah Detail Jenjang Sukses');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function show(Level $level)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function edit(RefLevel $level)
    {
        return view('ref.level.edit', compact('level'));
    }

    public function levelDetailEdit(RefLevelDetail $level_detail)
    {
        return view('ref.level.detail.edit', compact('level_detail'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RefLevel $level)
    {
        $validateData = $request->validate([
            'name' => 'required',
            'abbr' => ''
        ]);
        $level->update($validateData);
        return redirect()->route('ref.level.index')->with('success', 'Ubah Jenjang Pendidikan Sukses');
    }

    public function levelDetailUpdate(Request $request, RefLevelDetail $level_detail)
    {
        $validateData = $request->validate([
            'name' => 'required',
            'address' => ''
        ]);
        $level_detail->update($validateData);
        return redirect()->route('ref.level.index')->with('success', 'Ubah Detail Jenjang Sukses');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function destroy(RefLevel $level)
    {
        $level->delete();

        return redirect()->route('ref.level.index')->with('success', 'Hapus Jenjang Pendidikan Sukses');
    }

    public function levelDetailDestroy(RefLevelDetail $level_detail)
    {
        $level_detail->delete();

        return redirect()->route('ref.level.index')->with('success', 'Hapus Detail Jenjang Sukses');
    }

    public function showJson($id)
    {
        $level = RefLevel::findOrFail($id);
        return $level->toJson();
    }

    public function detailShowJson($id)
    {
        $level_detail = RefLevelDetail::findOrFail($id);
        return $level_detail->toJson();
    }
}
