<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class BarangPinjam extends Model
{
    use HasFactory;
    use Uuid;

    public $timestamps = true;
    protected $table = "barang_pinjam";
    protected $fillable = [
        'id','peminjaman_id','barang_id','qty'
    ];
}
