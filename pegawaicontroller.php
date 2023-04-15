<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\pegawai;

class pegawaicontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //dapatkan seluruh data pegawai dengan query builder
        $ar_pegawai = DB::table('pegawai')->get();
        //arahkan ke halaman baru dengan menyertakan data pegawai(compact)
        //di resources/views/pegawai/index.blade.php
        return view('pegawai.index',compact('ar_pegawai'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        ////mengarahkan ke hal form input
        return view('pegawai.form_pegawai');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //1. proses validasi data
        $validasi = $request->validate(
        [
            'nip'=>'required|unique:pegawai|numeric',
            'nama'=>'required|max:50',
            'alamat'=>'required',
            'email'=>'required|max:50|regex:/(.+)@(.+)\.(.+)/i',
        ],
        // menampilkan pesan kesalahane
        [
            'nip.required'=>'NIP Wajib di Isi',
            'nip.unique'=>'NIP Tidak Boleh Sama',
            'nip.numeric'=>'Harus Berupa Angka',
            'nama.required'=>'Nama Wajib di Isi',
            'alamat.required'=>'Alamat Wajib di Isi',
            'email.required'=>'Email Wajib di Isi',
            'email.regex'=>'Harus berformat email',
        ],
        );
            //2. proses input data tangkap request dari form input
            DB::table('pegawai')->insert(
        [
            'nip'=>$request->nip,
            'nama'=>$request->nama,
            'alamat'=>$request->alamat,
            'email'=>$request->email,
        ]
    );
    //2.landing page
    return redirect('/pegawai');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
