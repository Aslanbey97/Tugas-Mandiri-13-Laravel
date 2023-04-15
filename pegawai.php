<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pegawai extends Model
{
    use HasFactory;
    // tambahkan kode untuk mapping ke table pegawai
    protected $table = 'pegawai';
}
