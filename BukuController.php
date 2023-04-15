<?php

namespace App\Http\Controllers;

use DB;
use PDF;
use App\Models\Buku;
use App\Exports\BukuExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $keyword = $request->get('keyword');
        $ar_buku = DB::table('buku')
            ->join('pengarang', 'pengarang.id', '=', 'buku.idpengarang')
            ->join('penerbit', 'penerbit.id', '=', 'buku.idpenerbit')
            ->join('kategori', 'kategori.id', '=', 'buku.idkategori')
            ->select(
                'buku.*',
                'pengarang.nama',
                'penerbit.nama AS pen',
                'kategori.nama AS kat'
            )
            ->where('isbn', 'like', '%' . $keyword . '%')
            ->orWhere('judul', 'like', '%' . $keyword . '%')
            ->orWhere('stok', 'like', '%' . $keyword . '%')
            ->orWhere('pengarang.nama', 'like', '%' . $keyword . '%')
            ->orWhere('penerbit.nama', 'like', '%' . $keyword . '%')
            ->orWhere('kategori.nama', 'like', '%' . $keyword . '%')
            ->simplePaginate(5);

        return view('buku.index', compact('ar_buku'));
    }

    public function bukuPDF()
    {
        $ar_buku = DB::table('buku')
            ->join('pengarang', 'pengarang.id', '=', 'buku.idpengarang')
            ->join('penerbit', 'penerbit.id', '=', 'buku.idpenerbit')
            ->join('kategori', 'kategori.id', '=', 'buku.idkategori')
            ->select('buku.*', 'pengarang.nama', 'penerbit.nama AS pen', 'kategori.nama AS kat')
            ->get();
        $pdf = PDF::loadView('buku.bukupdf', ['ar_buku' => $ar_buku]);

        return $pdf->download('dataBuku.pdf');
    }

    public function bukucsv()
    {
        return Excel::download(new BukuExport, 'buku.csv');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //mengarahkan ke halaman form input buku
        return view('buku.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //proses input data, tangkap request dari form buku
        DB::table('buku')->insert(
            [
                'isbn' => $request->isbn,
                'judul' => $request->judul,
                'tahun_cetak' => $request->tahun_cetak,
                'stok' => $request->stok,
                'idpengarang' => $request->idpengarang,
                'idpenerbit' => $request->idpenerbit,
                'idkategori' => $request->idkategori
            ]
        );
        //landing page
        return redirect('/buku');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //menampilkan detail buku
        $ar_buku = DB::table('buku')
            ->join('pengarang', 'pengarang.id', '=', 'buku.idpengarang')
            ->join('penerbit', 'penerbit.id', '=', 'buku.idpenerbit')
            ->join('kategori', 'kategori.id', '=', 'buku.idkategori')
            ->select('buku.*', 'pengarang.nama', 'penerbit.nama AS pen', 'kategori.nama AS kat')
            ->where('buku.id', '=', $id)->get();
        return view('buku.show', compact('ar_buku'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //mengarahkan ke halaman form edit buku
        $data = DB::table('buku')
            ->where('id', '=', $id)->get();
        return view('buku.form_edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //proses edit data lama, tangkap request dari form edit buku
        DB::table('buku')->where('id', '=', $id)->update(
            [
                'isbn' => $request->isbn,
                'judul' => $request->judul,
                'tahun_cetak' => $request->tahun_cetak,
                'stok' => $request->stok,
                'idpengarang' => $request->idpengarang,
                'idpenerbit' => $request->idpenerbit,
                'idkategori' => $request->idkategori
            ]
        );
        //Landing Page
        return redirect('/buku' . '/' . $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //menghapus data
        DB::table('buku')->where('id', $id)->delete();
        return redirect('/buku');
    }
}
