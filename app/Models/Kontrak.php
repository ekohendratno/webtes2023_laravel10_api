<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kontrak extends Model
{
    use HasFactory;
    protected $table = 'kontrak';
    protected $fillable = ['pegawai_id', 'kontrak_tanggal_mulai', 'kontrak_tanggal_selesai'];
}
