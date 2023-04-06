<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use DB;

use App\Models\JabatanPegawai;
use App\Http\Resources\PegawaiResource;

class JabatanController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all datas
        $data = DB::table('jabatan_pegawai')
            ->select('*')
            ->join('pegawai', 'pegawai.pegawai_id', '=', 'jabatan_pegawai.pegawai_id')
            ->paginate(10);

        //return collection of datas as a resource
        return new PegawaiResource(true, 'List Data', $data);
    }

    public function store(Request $request)
    {
        Schema::disableForeignKeyConstraints();

        //define validation rules
        $validator = Validator::make($request->all(), [
            'jabatan'     => 'required',
            'gaji'   => 'required'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        //create data
        $data = JabatanPegawai::create([
            'pegawai_id'     => $request->id_pegawai,
            'jabatan_pegawai_jabatan'     => $request->jabatan,
            'jabatan_pegawai_gaji'   => $request->gaji
        ]);


        $data = DB::table('jabatan_pegawai')
            ->select('*')
            ->join('pegawai', 'pegawai.pegawai_id', '=', 'jabatan_pegawai.pegawai_id')
            ->where('jabatan_pegawai_id', $data->id)->get()->first();
        //return response
        return new PegawaiResource(true, 'Data Berhasil Ditambahkan!', $data);
    }

    /**
     * show
     *
     * @param  mixed $data
     * @return void
     */
    public function show($id)
    {
        //find data by ID
        $data = JabatanPegawai::where('jabatan_pegawai_id', $id)->get()->first();

        //return single data as a resource
        return new PegawaiResource(true, 'Detail Data!', $data);
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $data
     * @return void
     */
    public function update(Request $request, $id)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'jabatan'     => 'required',
            'gaji'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //find data by ID
        $data = JabatanPegawai::where('jabatan_pegawai_id', $id);

        //update data without image
        $data->update([
            'pegawai_id'     => $request->id_pegawai,
            'jabatan_pegawai_jabatan'     => $request->jabatan,
            'jabatan_pegawai_gaji'   => $request->gaji
        ]);


        $data = DB::table('jabatan_pegawai')
            ->select('*')
            ->join('pegawai', 'pegawai.pegawai_id', '=', 'jabatan_pegawai.pegawai_id')
            ->where('jabatan_pegawai_id', $id)->get()->first();

        //return response
        return new PegawaiResource(true, 'Data Berhasil Diubah!', $data);
    }

    /**
     * destroy
     *
     * @param  mixed $data
     * @return void
     */
    public function destroy($id)
    {
        Schema::disableForeignKeyConstraints();

        //find data by ID
        $data = JabatanPegawai::where('jabatan_pegawai_id', $id);

        //delete data
        $data->delete();

        //return response
        return new PegawaiResource(true, 'Data Berhasil Dihapus!', null);
    }
}
