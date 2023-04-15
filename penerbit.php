<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penerbit extends Model
{
    use HasFactory;
    // tambahkan kode untuk mapping ke table penerbit
    protected $table = 'penerbit';
}
