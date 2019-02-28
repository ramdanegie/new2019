<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/


//header('Access-Control-Allow-Origin: *');
//header('Access-Control-Allow-Methods: *');
//header('Access-Control-Max-Age: 3600');


$router->get('/versi', function () use ($router) {
    return $router->app->version();
});

$router->get('/', function () use ($router) {
	return 'Uhuy Berhasil';
});
$router->group(['prefix' => 'service'/*, 'middleware' => 'auth'*/], function ($app) {

	/* Example */
	$app->group(['prefix' => 'master/'/*, 'middleware' => 'auth2'*/], function ($app) {
		/** AgamaM */
		$app->get('agama/get-agama', 'ExampleController@getAgama');

		/** Alamat*/
		$app->get('alamat/get', 'Master\AlamatController@getAlamat');
		$app->post('alamat/save', 'Master\AlamatController@saveAlamat');
		$app->post('alamat/delete', 'Master\AlamatController@deleteAlamat');

		/** Customer*/
		$app->get('customer/get', 'Master\CustomerController@get');
		$app->post('customer/save', 'Master\CustomerController@save');
		$app->post('customer/delete', 'Master\CustomerController@delete');

		/** Detail Jenis Produk*/
		$app->get('detailjenisproduk/get', 'Master\DetailJenisProdukController@get');
		$app->post('detailjenisproduk/save', 'Master\DetailJenisProdukController@save');
		$app->post('detailjenisproduk/delete', 'Master\DetailJenisProdukController@delete');

		/** Jenis Kelamin*/
		$app->get('jeniskelamin/get', 'Master\JenisKelaminController@get');
		$app->post('jeniskelamin/save', 'Master\JenisKelaminController@save');
		$app->post('jeniskelamin/delete', 'Master\JenisKelaminController@delete');

		/**  Jenis Produk*/
		$app->get('jenisproduk/get', 'Master\JenisProdukController@get');
		$app->post('jenisproduk/save', 'Master\JenisProdukController@save');
		$app->post('jenisproduk/delete', 'Master\JenisProdukController@delete');

		/**  Jenis Transaksi*/
		$app->get('jenistransaksi/get', 'Master\JenisTransaksiController@get');
		$app->post('jenistransaksi/save', 'Master\JenisTransaksiController@save');
		$app->post('jenistransaksi/delete', 'Master\JenisTransaksiController@delete');

		/**  Kelompok Produk*/
		$app->get('kelompokproduk/get', 'Master\KelompokProdukController@get');
		$app->post('kelompokproduk/save', 'Master\KelompokProdukController@save');
		$app->post('kelompokproduk/delete', 'Master\KelompokProdukController@delete');

		/**  Kode Generatye */
		$app->get('kodegenerate/get', 'Master\KodeGenerateController@get');
		$app->post('kodegenerate/save', 'Master\KodeGenerateController@save');
		$app->post('kodegenerate/delete', 'Master\KodeGenerateController@delete');

		/** Kelompok User*/
		$app->get('kelompokuser/get-all', 'Master\KelompokUserController@getAll');
		$app->post('kelompokuser/save-kelompokuser', 'Master\KelompokUserController@saveKelompokUser');
		$app->post('kelompokuser/delete-kelompokuser', 'Master\KelompokUserController@deleteKelompokUser');

		/** PegawaiM*/
		$app->get('pegawai/get-pegawai-by-nama/{nama}', 'Master\PegawaiController@getPegawaiByNama');

		/** PegawaiM*/
		$app->get('loginuser/get-daftar-login-user', 'Master\LoginUserController@getDaftarLoginUser');
		$app->post('loginuser/save-login-user', 'Master\LoginUserController@saveLoginUser');
		$app->post('loginuser/delete-login-user', 'Master\LoginUserController@deleteLoginUser');

        /** Produk*/
        $app->get('produk/get-master-produk', 'Master\MasterController@getMasterProduk');
        $app->post('produk/save-master-produk', 'Master\MasterController@saveMasterProduk');
        $app->post('produk/delete-master-produk', 'Master\MasterController@deleteProduk');

		/** Master*/
		$app->get('pegawai/get-daftar-pegawai', 'Master\MasterController@getDaftarPegawai');
		$app->post('pegawai/save-pegawai', 'Master\MasterController@savePegawai');
		$app->get('get-combo', 'Master\MasterController@getCombo');
		$app->post('pegawai/delete-pegawai', 'Master\MasterController@deletePegawai');

		/**  Satuan*/
		$app->get('satuanstandar/get', 'Master\SatuanStandarController@get');
		$app->post('satuanstandar/save', 'Master\SatuanStandarController@save');
		$app->post('satuanstandar/delete', 'Master\SatuanStandarController@delete');

		/**  Supplier*/
		$app->get('supplier/get', 'Master\SupplierController@get');
		$app->post('supplier/save', 'Master\SupplierController@save');
		$app->post('supplier/delete', 'Master\SupplierController@delete');

		/**  Toko*/
		$app->get('toko/get', 'Master\TokoController@get');
		$app->post('toko/save', 'Master\TokoController@save');
		$app->post('toko/delete', 'Master\TokoController@delete');


	});

	$app->group(['prefix' => 'transaksi/'/*, 'middleware' => 'auth2'*/], function ($app) {
		/** Penerimaan Barang */
		$app->get('penerimaan/get-list-data', 'Transaksi\PenerimaanBarangController@getListCombo');
		$app->post('penerimaan/save-penerimaan', 'Transaksi\PenerimaanBarangController@savePenerimaan');
		$app->get('penerimaan/get-daftar-penerimaan', 'Transaksi\PenerimaanBarangController@getDaftarPenerimaanSuplier');
		$app->post('penerimaan/delete-penerimaan', 'Transaksi\PenerimaanBarangController@hapusPenerimaan');
	});

	/* Master */
	$app->group(['prefix' => 'setting/','middleware' => 'auth2'], function ($app) {
		$app->get('menu','Core\MenuController@getMenu');
		$app->get('profile/{KdProfile}','Core\MenuController@profile');
	});

    /* Auth */
    $app->group(['prefix' => 'auth/'], function ($app) {
        $app->post('sign-in', 'Core\LoginController@signIn');
	    $app->post('sign-out', 'Core\LoginController@signOut');
	    $app->get('change-password', 'Core\LoginController@changePassword');
    });

});

