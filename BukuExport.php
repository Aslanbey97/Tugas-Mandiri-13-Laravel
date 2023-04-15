<?php

namespace App\Exports;

use App\Models\buku;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class BukuExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $ar_buku = DB::table('buku')
            ->join('pengarang', 'pengarang.id', '=', 'buku.idpengarang')
            ->join('penerbit', 'penerbit.id', '=', 'buku.idpenerbit')
            ->join('kategori', 'kategori.id', '=', 'buku.idkategori')
            ->select(
                'buku.isbn',
                'buku.judul',
                'buku.tahun_cetak',
                'buku.stok',
                'pengarang.nama',
                'penerbit.nama AS pen',
                'kategori.nama AS kat'
            )
            ->get();
        return $ar_buku;
    }
    public function headings(): array
    {
        return [
            'ISBN', 'Judul', 'Tahun Cetak', 'Stok',
            'Pengarang', 'Penerbit', 'Kategori'
        ];
    }
}
