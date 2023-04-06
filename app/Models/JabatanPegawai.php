<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JabatanPegawai extends Model
{
    use HasFactory;
    protected $table = 'jabatan_pegawai';
    protected $fillable = ['pegawai_id', 'jabatan_pegawai_jabatan', 'jabatan_pegawai_gaji'];
}
