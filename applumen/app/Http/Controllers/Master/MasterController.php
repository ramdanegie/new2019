<?php
/**
 * Created by IntelliJ IDEA.
 * User: Egie Ramdan
 * Date: 20/02/2019
 * Time: 08.20
 */

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Model\Master\Pegawai_M;
use App\Model\Master\PegawaiM;
use App\Model\Standar\LoginUser_S;
use App\Model\Master\Produk_M;
use Illuminate\Http\Request;
use App\Traits\Core;
use App\Traits\JsonResponse;
use Illuminate\Support\Facades\DB;

class  MasterController extends Controller
{
	use Core;

	public function getAlamat (Request $request)
	{
		$data = DB::table('alamat_m')
			->select('*')
			->where ('statusenabled',true)
			->orderBy('alamat')
			->get();

		$result['code'] = 200;
		$result['data'] = $data;
		$result['as'] = "ramdanegie";

		return response()->json($result);
	}
	public function saveAlamat (Request $request)
	{
		DB::beginTransaction();
		try{
		$idMax = LoginUser_S::max('id') + 1;
		if($request['idUser'] == null){
			$log = new LoginUser_S();
			$log->id = $idMax;
			$log->statusenabled = true;
		}else{
			$log = LoginUser_S::where('id',$request['idUser'])->first();
		}
		if(isset($request['kataSandi'])){
			$log->katasandi= $request['kataSandi'];
		}
		$log->namauser= $request['namaUser'];
		$log->objectpegawaifk= $request['pegawai']['id'];
		$log->objectkelompokuserfk= $request['kdKelompokUser'];
		$log->save();

			$transStatus = 'true';
		} catch (\Exception $e) {
		$transStatus = 'false';
		}
		if ($transStatus == 'true') {
			$transMessage = "Simpan Pegawai";
			DB::commit();
			$result = array(
				'status' => 200,
				'message' => $transMessage,
				'as' => 'ramdanegie',
			);
		} else {
			$transMessage = "Terjadi Kesalahan saat menyimpan data";
			DB::rollBack();
			$result = array(
				'status' => 500,
				'message'  => $transMessage,
				'as' => 'ramdanegie',
			);
		}
		return response()->json($result,$result['status']);
	}
	public function getDaftarPegawai (Request $request)
	{
		$data = DB::table('pegawai_m as pg')
			->leftJoin('alamat_m as alm','alm.id','=','pg.alamatfk')
			->leftJoin('jeniskelamin_m as jk','jk.id','=','pg.jeniskelaminfk')
			->select('pg.*','alm.alamat','alm.provinsi','alm.kota','alm.kabupaten','alm.kecamatan',
				'jk.jeniskelamin')
			->where ('pg.statusenabled',true)
			->orderBy('pg.namalengkap')
			->get();

		$result['code'] = 200;
		$result['data'] = $data;
		$result['as'] = "ramdanegie";

		return response()->json($result);
	}
	public function savePegawai (Request $request)
	{
		DB::beginTransaction();
		try{
			$idMax = Pegawai_M::max('id') + 1;
			if($request['idPegawai'] == null){
				$log = new Pegawai_M();
				$log->id = $idMax;
				$log->statusenabled = true;
			}else{
				$log = Pegawai_M::where('id',$request['idPegawai'])->first();
			}
			$log->namalengkap= $request['namaLengkap'];
			$log->namapanggilan= $request['namaPanggilan'];
			$log->nohp= $request['noHp'];
			$log->notlp= $request['noTlp'];
			$log->alamatfk= $request['kdAlamat'];
			$log->jeniskelaminfk= $request['kdJenisKelamin'];
			$log->tgllahir= $request['tglLahir'];
			$log->save();

			$transStatus = 'true';
		} catch (\Exception $e) {
			$transStatus = 'false';
		}
		if ($transStatus == 'true') {
			$transMessage = "Sukses";
			DB::commit();
			$result = array(
				'status' => 200,
				'message' => $transMessage,
				'as' => 'ramdanegie',
			);
		} else {
			$transMessage = "Terjadi Kesalahan saat menyimpan data";
			DB::rollBack();
			$result = array(
				'status' => 500,
				'message'  => $transMessage,
				'as' => 'ramdanegie',
			);
		}
		return response()->json($result,$result['status']);
	}
	public function getCombo (Request $request)
	{
		$alamat = DB::table('alamat_m')
			->select('*')
			->where ('statusenabled',true)
			->orderBy('alamat')
			->get();
		$jk = DB::table('jeniskelamin_m')
			->select('*')
			->where ('statusenabled',true)
			->orderBy('id')
			->get();

		$result['code'] = 200;
		$result['data'] = array(
			'alamat' => $alamat,
			'jeniskelamin' => $jk,
		);
		$result['as'] = "ramdanegie";

		return response()->json($result);
	}
	public function deletePegawai (Request $request)
	{
		DB::beginTransaction();
		try{
			Pegawai_M::where('id',$request['idPegawai'])->update(
				[ 'statusenabled' =>  false]
			);
			$transStatus = 'true';
		} catch (\Exception $e) {
			$transStatus = 'false';
		}
		if ($transStatus == 'true') {
			$transMessage = "Hapus Pegawai";
			DB::commit();
			$result = array(
				'status' => 200,
				'message' => $transMessage,
				'as' => 'ramdanegie',
			);
		} else {
			$transMessage = "Terjadi Kesalahan";
			DB::rollBack();
			$result = array(
				'status' => 500,
				'message'  => $transMessage,
				'as' => 'ramdanegie',
			);
		}
		return response()->json($result,$result['status']);
	}

    public function getMasterProduk (Request $request)
    {
        $data = DB::table('produk_m as pr')
            ->leftJoin('detailjenisproduk_m as djp', 'djp.id', '=', 'pr.detailjenisprodukfk')
            ->leftJoin('satuanstandard_m as ss', 'ss.id', '=', 'pr.satuanstandardfk')
            ->select('pr.*', 'djp.id as djpid', 'djp.detailjenisproduk', 'djp.jenisprodukfk', 'ss.id as ssis', 'ss.satuanstandard')
            ->where ('pr.statusenabled',true)
            ->orderBy('id');
        if (isset($request['namaproduk']) && $request['namaproduk']!="" && $request['namaproduk'] != "undefined"){
            $data = $data->where('pr.namaproduk','>=', $request['namaproduk']);
        }
        if (isset($request['id']) && $request['id']!="" && $request['id'] != "undefined"){
            $data = $data->where('pr.id','>=', $request['id']);
        }
        $data = $data->get();
        $result = array(
            'status' => 200,
            'data' => $data,
            'as' => "{ng-SitepuMan}"
        );
        return response()->json($result);
    }
    public function saveMasterProduk (Request $request)
    {
        DB::beginTransaction();
        try{
            $idMax = Produk_M ::max('id') + 1;
            if($request['id'] == null){
                $log = new Produk_M();
                $log->id = $idMax;
                $log->statusenabled = true;
            }else{
                $log = Produk_m::where('id',$request['id'])->first();
            }
            $log->namaproduk= $request['namaProduk'];
            $log->kdexternal= $request['kdExternal'];
            $log->detailjenisprodukfk= $request['detailJenisProduk'];
            $log->satuanstandardfk= $request['satuanStandard'];
            $log->statusenabled= $request['statusEnabled'];
            $log->save();

            $transStatus = 'true';
        } catch (\Exception $e) {
            $transStatus = 'false';
        }
        if ($transStatus == 'true') {
            $transMessage = "Sukses";
            DB::commit();
            $result = array(
                'status' => 200,
                'message' => $transMessage,
                'as' => '{ng-SitepuMan}',
            );
        } else {
            $transMessage = "Terjadi Kesalahan saat menyimpan data";
            DB::rollBack();
            $result = array(
                'status' => 500,
                'message'  => $transMessage,
                'as' => '{ng-SitepuMan}',
            );
        }
        return response()->json($result,$result['status']);
    }
    public function deleteProduk (Request $request)
    {
        DB::beginTransaction();
        try{
            Produk_M::where('id',$request['id'])->update(
                [ 'statusenabled' =>  false]
            );
            $transStatus = 'true';
        } catch (\Exception $e) {
            $transStatus = 'false';
        }
        if ($transStatus == 'true') {
            $transMessage = "Hapus Produk";
            DB::commit();
            $result = array(
                'status' => 200,
                'message' => $transMessage,
                'as' => '{ng-SitepuMan}',
            );
        } else {
            $transMessage = "Terjadi Kesalahan";
            DB::rollBack();
            $result = array(
                'status' => 500,
                'message'  => $transMessage,
                'as' => '{ng-SitepuMan}',
            );
        }
        return response()->json($result,$result['status']);
    }
}