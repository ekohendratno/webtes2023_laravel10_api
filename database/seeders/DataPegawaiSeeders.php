<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataPegawaiSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Data Seeder untuk Tabel Pegawai
        DB::table('pegawai')->insert([
            ['pegawai_id' => 1, 'pegawai_nama' => 'John Doe', 'pegawai_alamat' => 'Jl. Sudirman No. 123', 'pegawai_tanggal_lahir' => '1990-01-01'],
            ['pegawai_id' => 2, 'pegawai_nama' => 'The Lo', 'pegawai_alamat' => 'Jl. Sudirman No. 123', 'pegawai_tanggal_lahir' => '1990-01-01'],
            ['pegawai_id' => 3, 'pegawai_nama' => 'Bob Smith', 'pegawai_alamat' => 'Jl. Gatot Subroto No. 789', 'pegawai_tanggal_lahir' => '1995-03-03'],
            ['pegawai_id' => 4, 'pegawai_nama' => 'Smith', 'pegawai_alamat' => 'Jl. Gatot Subroto No. 789', 'pegawai_tanggal_lahir' => '1995-03-03'],
        ]);

        // Data Seeder untuk Tabel Jabatan Pegawai
        DB::table('jabatan_pegawai')->insert([
            ['jabatan_pegawai_id' => 1, 'pegawai_id' => 1, 'jabatan_pegawai_jabatan' => 'Manager', 'jabatan_pegawai_gaji' => 10000000],
            ['jabatan_pegawai_id' => 2, 'pegawai_id' => 2, 'jabatan_pegawai_jabatan' => 'Supervisor', 'jabatan_pegawai_gaji' => 8000000],
            ['jabatan_pegawai_id' => 3, 'pegawai_id' => 3, 'jabatan_pegawai_jabatan' => 'Staff', 'jabatan_pegawai_gaji' => 5000000],
            ['jabatan_pegawai_id' => 4, 'pegawai_id' => 4, 'jabatan_pegawai_jabatan' => 'Staff', 'jabatan_pegawai_gaji' => 5000000],
        ]);

        // Data Seeder untuk Tabel Kontrak
        DB::table('kontrak')->insert([
            ['kontrak_id' => 1, 'pegawai_id' => 1, 'kontrak_tanggal_mulai' => '2022-01-01', 'kontrak_tanggal_selesai' => '2022-12-31'],
            ['kontrak_id' => 2, 'pegawai_id' => 2, 'kontrak_tanggal_mulai' => '2022-03-01', 'kontrak_tanggal_selesai' => '2022-08-31'],
            ['kontrak_id' => 3, 'pegawai_id' => 3, 'kontrak_tanggal_mulai' => '2022-04-01', 'kontrak_tanggal_selesai' => '2022-09-30'],
        ]);
    }
}
