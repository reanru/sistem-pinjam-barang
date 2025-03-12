<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class PeminjamanBarang extends Model
{
    use HasFactory;
    use Uuid;

    public $timestamps = true;
    protected $table = "peminjaman_barang";
    protected $fillable = [
        'id','user_id','barang_id','no_hp','kode_barang','nama_barang','mulai','selesai','deskripsi','status'
    ];
}
