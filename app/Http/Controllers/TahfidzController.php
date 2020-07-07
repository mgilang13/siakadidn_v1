<?php

namespace App\Http\Controllers;

use App\Model\Tahfidz;
use Illuminate\Http\Request;

class TahfidzController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tahfidz.index');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Tahfidz  $tahfidz
     * @return \Illuminate\Http\Response
     */
    public function show(Tahfidz $tahfidz)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Tahfidz  $tahfidz
     * @return \Illuminate\Http\Response
     */
    public function edit(Tahfidz $tahfidz)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Tahfidz  $tahfidz
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tahfidz $tahfidz)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Tahfidz  $tahfidz
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tahfidz $tahfidz)
    {
        //
    }
}
