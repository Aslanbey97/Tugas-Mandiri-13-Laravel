<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\datamahasantri;

class DataMahasantricontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //dapatkan seluruh data datamahasantri dengan query builder
        $ar_datamahasantri = DB::table('datamahasantri')->get();
        //arahkan ke halaman baru dengan menyertakan data datamahasantri(compact)
        //di resources/views/datamahasantri/index.blade.php
        return view('datamahasantri.index',compact('ar_datamahasantri'));

    }

    public function jurusan()
    {
        return view('jurusan.jurusan');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        ////mengarahkan ke hal form input
        return view('datamahasantri.form_datamahasantri');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //1. proses validasi data
        $validasi = $request->validate(
        [
            'nim'=>'required|unique:datamahasantri|numeric',
            'nama'=>'required|max:50',
            'jurusan'=>'required|max:50',
            'alamat'=>'required',
            'kota'=>'required',
            'provinsi'=>'required',
            'email'=>'required|max:50|regex:/(.+)@(.+)\.(.+)/i',
        ],
        // menampilkan pesan kesalahan
        [
            'nim.required'=>'NIM Wajib di Isi',
            'nim.unique'=>'NIM Tidak Boleh Sama',
            'nim.numeric'=>'Harus Berupa Angka',
            'nama.required'=>'Nama Wajib di Isi',
            'jurusan.required'=>'jurusan Wajib di Isi',
            'alamat.required'=>'Alamat Wajib di Isi',
            'kota.required'=>'kota Wajib di Isi',
            'provinsi.required'=>'provinsi Wajib di Isi',
            'email.required'=>'Email Wajib di Isi',
            'email.regex'=>'Harus berformat email',
        ],
        );
            //2. proses input data tangkap request dari form input
            DB::table('datamahasantri')->insert(
        [
            'nim'=>$request->nim,
            'nama'=>$request->nama,
            'jurusan'=>$request->jurusan,
            'alamat'=>$request->alamat,
            'kota'=>$request->kota,
            'provinsi'=>$request->provinsi,
            'email'=>$request->email,
        ]
    );
    //2.landing page
    return redirect('/datamahasantri');
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
