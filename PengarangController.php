<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Pengarang;

class PengarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //dapatkan seluruh data pengarang dengan query builder
        $ar_pengarang = DB::table('pengarang')->simplePaginate(5);
        //arahkan ke halaman baru dengan menyertakan data pengarang(compact)
        //di resources/views/pengarang/index.blade.php
        return view('pengarang.index', compact('ar_pengarang'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // mengarahkan ke hal form input pengarang
        return view('pengarang.form');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'hp' => 'required',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        //menyimpan file ke dalam server
        $fileName = '';
        if ($request->hasFile('foto')) {
            $fileName = $request->nama . '.' . $request->foto->extension();
            $request->foto->move(public_path('images'), $fileName);
        }

        //proses input data, tangkap request dari form pengarang
        DB::table('pengarang')->insert([
            'nama' => $request->nama,
            'email' => $request->email,
            'hp' => $request->hp,
            'foto' => '/images/' . $fileName
        ]);

        //landing page
        return redirect('/pengarang');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ar_pengarang = DB::table('pengarang')->where('pengarang.id', '=', $id)->get();
        return view('pengarang.show', compact('ar_pengarang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //mengarahkan ke halaman form edit pengarang
        $data = DB::table('pengarang')
            ->where('id', '=', $id)->get();
        return view('pengarang.form_edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //proses edit data lama, tangkap request dari form edit pengarang
        DB::table('pengarang')->where('id', '=', $id)->update(
            [
                'nama' => $request->nama,
                'email' => $request->email,
                'hp' => $request->hp,
                'foto' => $request->foto
            ]
        );

        // //proses upload,dicek ketika edit data ada upload file/tidak
        // if(!empty($request->foto)){
        //     //ambil isi kolom foto lalu hapus file fotonya di folder images
        //     $foto = DB::table('pengarang')->select('foto')
        //     ->where('id','=',$id)->get();
        //     foreach($foto as $f){
        //     $namaFile = $f->foto;
        //     }
        //     File::delete(public_path('images/'.$namaFile));
        //     //proses upload file baru
        //     $request->validate([
        //     'foto' => 'image|mimes:jpg,jpeg,png,giff|max:2048',
        //     ]);
        //     $fileName = $request->nama.'.'.$request->foto->extension();
        //     //$fileName = $request->nama.'.jpg';
        //     $request->foto->move(public_path('images'), $fileName);
            
        // }  
        // else{
        //     //ambil isi kolom foto lalu hapus file fotonya difolder images
        //     $foto = DB::table('pengarang')->select('foto')
        //     ->where('id','=',$id)->get();
        //     foreach($foto as $f){
        //     $namaFile = $f->foto;
        //     }
        //     $fileName = $namaFile;
        // }

        //Landing Page
        return redirect('/pengarang' . '/' . $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $foto = DB::table('pengarang')->select('foto')
        ->where('id','=',$id)->get();
        foreach($foto as $f){
        $namaFile = $f->foto;
        }
        File::delete(public_path('images/'.$namaFile));

        //menghapus data
        DB::table('pengarang')->where('id', $id)->delete();
        return redirect('/pengarang');
    }
}
