<?php

namespace App\Http\Controllers\Ref;

use App\Http\Controllers\Controller;
use App\Model\Ref\RefHalaqah;
use App\Model\Ref\RefStudent;
use App\Model\Ref\RefHalaqahRefStudents;

use App\Model\Core\Roles;
use App\Model\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RefHalaqahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = Roles::findOrFail(3)->users()->get();
        // $users = User::all();

        $halaqah_teacher = DB::table('halaqahs')
                                ->join('users', 'users.id', '=', 'halaqahs.id_teacher')
                                ->select('halaqahs.id', 'users.name as teacherName', 'halaqahs.name as halaqahName', 'description')
                                ->get();
        $halaqahs = RefHalaqah::all();

        return view('ref.halaqah.index', compact('users', 'halaqahs', 'halaqah_teacher'));
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
        $request->validate([
            'name' => 'required',
            'id_teacher' => '',
            'description' => ''
        ]);
        RefHalaqah::create($request->only(['name', 'id_teacher', 'description']));
        $request->session()->flash('success', 'Tambah Halaqah Sukses');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Ref\RefHalaqah  $refHalaqah
     * @return \Illuminate\Http\Response
     */
    public function show(RefHalaqah $halaqah)
    {
        
        $users = Roles::findOrFail(3)->users()->get();
        $unlisted_members = DB::table('students')
                                    ->join('users', 'users.id', '=', 'students.id_student')
                                    ->where('students.id_halaqah', NULL)
                                    ->get();

        $listed_members = DB::table('students')
                                ->join('users', 'users.id', '=', 'students.id_student')
                                ->where('students.id_halaqah', $halaqah->id)
                                ->get();
        return view('ref.halaqah.show', compact('halaqah', 'users', 'listed_members', 'unlisted_members'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Ref\RefHalaqah  $refHalaqah
     * @return \Illuminate\Http\Response
     */
    public function edit(RefHalaqah $halaqah)
    {
        $teachers = DB::table('teachers as t')
                            ->join('users as u', 'u.id', '=', 't.id_teacher')
                            ->select('u.id', 'u.name')
                            ->get();
        return view('ref.halaqah.edit', compact('halaqah', 'teachers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Ref\RefHalaqah  $refHalaqah
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RefHalaqah $halaqah)
    {
        $validateData = $request->validate([
            'name' => 'required',
            'id_teacher' => '',
            'description' => ''
        ]);
        $halaqah->update($validateData);
        return redirect()->route('ref.halaqah.index')->with('success', 'Ubah Data Halaqah Sukses');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Ref\RefHalaqah  $refHalaqah
     * @return \Illuminate\Http\Response
     */
    public function destroy(RefHalaqah $halaqah)
    {
        $halaqah->delete();

        return redirect()->route('ref.halaqah.index')->with('success', 'Hapus Data Halaqah Sukses');
    }

    public function addMember(RefHalaqah $halaqah)
    {
        $students = RefStudent::where('id_halaqah',null)->get();
        
        return view('ref.halaqah.add-member', compact('halaqah', 'students'));
    }

    public function addMemberProcess($id, Request $request)
    {
        $students = RefStudent::where('id_halaqah', null)->get();
        $halaqah = RefHalaqah::findOrFail($request->id_halaqah);

        $validateData = $request->validate([
            'id_halaqah' => 'required'
        ]);
        
        $student = RefStudent::findOrFail($id);
        $student->update($validateData);

        return redirect()->route('ref.halaqah.show.add', compact('halaqah', 'students'))->with('success', 'Update Materi Sukses');
    }

    public function showJson($id)
    {
        $halaqah = RefHalaqah::findOrFail($id);
        return $halaqah->toJson();
    }
}
