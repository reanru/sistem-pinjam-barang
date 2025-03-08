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
}
