<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use DB;

use App\Http\Resources\PegawaiResource;
use App\Models\Kontrak;

class KontakController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all datas
        $data = DB::table('kontrak')
            ->select('*')
            ->join('pegawai', 'pegawai.pegawai_id', '=', 'kontrak.pegawai_id')
            ->paginate(10);

        //return collection of datas as a resource
        return new PegawaiResource(true, 'List Data', $data);
    }

    public function store(Request $request)
    {

        //define validation rules
        $validator = Validator::make($request->all(), [
            'id_pegawai'     => 'required',
            'tanggal_mulai'   => 'required',
            'tanggal_selesai'   => 'required'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        //create data
        $data = Kontrak::create([
            'pegawai_id'   => $request->id_pegawai,
            'kontrak_tanggal_mulai'     => $request->tanggal_mulai,
            'kontrak_tanggal_selesai'   => $request->tanggal_selesai,
        ]);


        $data = DB::table('kontrak')
            ->select('*')
            ->join('pegawai', 'pegawai.pegawai_id', '=', 'kontrak.pegawai_id')
            ->where('kontrak_id', $data->id)->get()->first();
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
        $data = Kontrak::where('kontrak_id',$id)->get()->first();

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
            'pegawai_id'   => $request->id_pegawai,
            'kontrak_tanggal_mulai'     => $request->tanggal_mulai,
            'kontrak_tanggal_selesai'   => $request->tanggal_selesai,
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //find data by ID
        $data = Kontrak::where('kontrak_id',$id);

        //update data without image
        $data->update([
            'pegawai_id'   => $request->id_pegawai,
            'kontrak_tanggal_mulai'     => $request->tanggal_mulai,
            'kontrak_tanggal_selesai'   => $request->tanggal_selesai,
        ]);

        $data = DB::table('kontrak')
            ->select('*')
            ->join('pegawai', 'pegawai.pegawai_id', '=', 'kontrak.pegawai_id')
            ->where('kontrak_id', $id)->get()->first();
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

        //find data by ID
        $data = Kontrak::where('kontrak_id',$id);

        //delete data
        $data->delete();

        //return response
        return new PegawaiResource(true, 'Data Berhasil Dihapus!', null);
    }
}
