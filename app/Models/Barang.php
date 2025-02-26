<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class Barang extends Model
{
    use HasFactory;
    use Uuid;

    public $timestamps = true;
    protected $table = "barang";
    protected $fillable = [
        'id','kode','nama','stok','status'
    ];
}
