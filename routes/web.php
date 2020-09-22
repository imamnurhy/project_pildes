<?php

use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return redirect('login');
});

Route::get('/logout', function () {
    return "<center>Someting It's Wrong.</center>";
});

Auth::routes();

Route::prefix('home')->group(function () {
    Route::get('/', 'HomeController@index')->name('home');
});


/* MASTER INCOME */
Route::namespace('Income')->group(function () {
    Route::get('pendapatanAset/api', 'PendapatanAsetController@api')->name('pendapatanAset.api');
    Route::get('pendapatanAset/getJenisAset/{id}', 'PendapatanAsetController@getJenisAset')->name('pendapatanAset.getJenisAset');
    Route::resource('pendapatanAset', 'PendapatanAsetController');

    Route::get('pendapatanNonAset/api', 'PendapatanNonAsetController@api')->name('pendapatanNonAset.api');
    Route::get('pendapatanNonAset/getJenisAset/{id}', 'PendapatanNonAsetController@getJenisAset')->name('pendapatanNonAset.getJenisAset');
    Route::resource('pendapatanNonAset', 'PendapatanNonAsetController');

    Route::get('pendapatanRincianAset/api', 'PendapatanRincianAsetController@api')->name('pendapatanRincianAset.api');
    Route::resource('pendapatanRincianAset', 'PendapatanRincianAsetController');
});


/* MASTER JENIS ASET */
Route::namespace('JenisAset')->middleware('permission:master-jenisAset')->group(function () {
    Route::get('jenisAset', 'JenisAsetController@index')->name('jenisAset.index');
    Route::get('jenisAset/api', 'JenisAsetController@api')->name('jenisAset.api');
    Route::post('jenisAset/store', 'JenisAsetController@store')->name('jenisAset.store');
    Route::get('jenisAset/show/{id}', 'JenisAsetController@show')->name('jenisAset.show');
    Route::get('jenisAset/edit/{id}', 'JenisAsetController@edit')->name('jenisAset.edit');
    Route::patch('jenisAset/update/{id}', 'JenisAsetController@update')->name('jenisAset.update');
    Route::delete('jenisAset/delete/{id}', 'JenisAsetController@destroy')->name('jenisAset.destroy');

    Route::get('rincianJenisAset', 'RincianJenisAsetController@index')->name('rincianJenisAset.index');
    Route::get('rincianJenisAset/api', 'RincianJenisAsetController@api')->name('rincianJenisAset.api');
    Route::post('rincianJenisAset/store', 'RincianJenisAsetController@store')->name('rincianJenisAset.store');
    Route::get('rincianJenisAset/show/{id}', 'RincianJenisAsetController@show')->name('rincianJenisAset.show');
    Route::get('rincianJenisAset/edit/{id}', 'RincianJenisAsetController@edit')->name('rincianJenisAset.edit');
    Route::patch('rincianJenisAset/update/{id}', 'RincianJenisAsetController@update')->name('rincianJenisAset.update');
    Route::delete('rincianJenisAset/delete/{id}', 'RincianJenisAsetController@destroy')->name('rincianJenisAset.destroy');
});


/* MASTER ASET */
Route::group(['middleware' => ['permission:master-aset']], function () {
    Route::prefix('aset')->namespace('Aset')->name('aset.')->group(function () {
        Route::post('masuk/api', 'AsetMasukController@api')->name('masuk.api');

        Route::get('getRincian/{id}', 'AsetMasukController@getRincian')->name('masuk.getRincian');
        route::get('masuk/generateNoAset', 'AsetMasukController@generateNoAset')->name('masuk.generateNoAset');
        Route::get('masuk/{provinsi_id}/getKabupaten', 'AsetMasukController@getKabupaten')->name('masuk.getKabupaten');
        Route::get('masuk/{kabupaten_id}/getKecamatan', 'AsetMasukController@getKecamatan')->name('masuk.getKecamatan');
        Route::get('masuk/{kecamatan_id}/getKelurahan', 'AsetMasukController@getKelurahan')->name('masuk.getKelurahan');
        Route::delete('masuk/{id}/hapusBerkas', 'AsetMasukController@hapusBerkas')->name('masuk.hapusBerkas');
        Route::get('masuk/{id}/download_berkas', 'AsetMasukController@download_berkas')->name('masuk.download_berkas');
        Route::get('masuk/laporan', 'AsetMasukController@laporanPdf')->name('masuk.laporan');


        route::get('masuk/showDetail/{id}', 'AsetMasukController@showDetail')->name('masuk.showDetail');
        Route::post('masuk/storeDetailAsset', 'AsetMasukController@storeDetail')->name('masuk.storeDetailAsset');
        Route::get('masuk/editDetailAsset', 'AsetMasukController@editDetail')->name('masuk.editDetailAsset');
        Route::patch('masuk/updateDetailAsset', 'AsetMasukController@updateDetail')->name('masuk.updateDetailAsset');
        Route::delete('masuk/{id}/hapusAssetKendaraan', 'AsetMasukController@destroyAssetKendaraan')->name('masuk.destroyAssetKendaraan');

        // Detail asset
        Route::prefix('detail')->name('masuk.detail.')->group(function () {
            Route::get('show/{id}', 'AsetMasukController@showDetail')->name('show');
            Route::post('store', 'AsetMasukController@storeDetail')->name('store');
            Route::get('edit/{id}', 'AsetMasukController@editDetail')->name('edit');
            Route::patch('update/{id}', 'AsetMasukController@updateDetail')->name('update');
            Route::delete('destroy/{id}', 'AsetMasukController@destroyDetail')->name('destroy');
        });

        Route::resource('masuk', 'AsetMasukController');

        Route::get('keluar/api', 'AsetKeluarController@api')->name('keluar.api');
        Route::get('keluar/apiDetail/{tmopd_id}', 'AsetKeluarController@apiDetailAsetKeluar')->name('keluar.apiDetailAsetKeluar');
        Route::get('keluar/showDetail/{id}', 'AsetKeluarController@showDetail')->name('keluar.showDetail');
        Route::patch('keluar/{id}/updateFoto', 'AsetKeluarController@updateFoto')->name('keluar.updateFoto');
        Route::delete('keluar/deletOpd/{id}', 'AsetKeluarController@destroyOpd')->name('keluar.destroyOpd');
        Route::delete('keluar/deletOpdAset/{id}', 'AsetKeluarController@destroyOpdAset')->name('keluar.destroyOpdAset');
        Route::resource('keluar', 'AsetKeluarController');
    });
});


Route::prefix('account')->group(function () {
    Route::get('profile', 'AccountController@profile')->name('account.profile');
    Route::post('profile/updateFoto', 'AccountController@updateFoto')->name('account.updateFoto');

    Route::get('password', 'AccountController@password')->name('account.password');
    Route::patch('password', 'AccountController@updatePassword')->name('account.password');
});


/* MASTER PEGAWAI */
Route::group(['middleware' => ['permission:master-pegawai']], function () {
    Route::resource('pegawai', 'Master\PegawaiController');
    Route::get('api/pegawai', 'Master\PegawaiController@api')->name('api.pegawai');
    Route::get('getUnitkerja/{opd_id}/pegawai', 'Master\PegawaiController@getUnitkerja')->name('getUnitkerja.pegawai');
    Route::post('pegawai/getNik', 'Master\PegawaiController@getNik')->name('pegawai.getNik');
    Route::get('pegawai/{provinsi_id}/getKabupaten', 'Master\PegawaiController@getKabupaten')->name('pegawai.getKabupaten');
    Route::get('pegawai/{kabupaten_id}/getKecamatan', 'Master\PegawaiController@getKecamatan')->name('pegawai.getKecamatan');
    Route::get('pegawai/{kecamatan_id}/getKelurahan', 'Master\PegawaiController@getKelurahan')->name('pegawai.getKelurahan');
    Route::patch('pegawai/{id}/updateFoto', 'Master\PegawaiController@updateFoto')->name('pegawai.updateFoto');

    Route::resource('rumpun', 'Master\RumpunController');
    Route::get('api/rumpun', 'Master\RumpunController@api')->name('api.rumpun');

    Route::resource('opd', 'Master\OpdController');
    Route::get('api/opd', 'Master\OpdController@api')->name('api.opd');
    Route::resource('kategori', 'Master\KategoriController');
    Route::get('api/kategori', 'Master\KategoriController@api')->name('api.kategori');

    Route::resource('unitkerja', 'Master\UnitkerjaController');
    Route::get('api/unitkerja', 'Master\UnitkerjaController@api')->name('api.unitkerja');

    Route::resource('golongan', 'Master\GolonganController');
    Route::get('api/golongan', 'Master\GolonganController@api')->name('api.golongan');

    Route::resource('eselon', 'Master\EselonController');
    Route::get('api/eselon', 'Master\EselonController@api')->name('api.eselon');

    Route::resource('user', 'Master\UserController');
    Route::get('api/user', 'Master\UserController@api')->name('api.user');
    Route::get('user/{pegawai_id}/add_user', 'Master\UserController@add_user')->name('user.add_user');
    Route::get('user/{id}/getRoles', 'Master\UserController@getRoles')->name('user.getRoles');
    Route::delete('user/{name}/destroyRole', 'Master\UserController@destroyRole')->name('user.destroyRole');
});

/* MASTER WILAYAH */
Route::group(['middleware' => ['permission:master-wilayah']], function () {
    Route::resource('provinsi', 'Master\ProvinsiController');
    Route::get('api/provinsi', 'Master\ProvinsiController@api')->name('api.provinsi');

    Route::get('kabupaten/{provinsi_id}/api', 'Master\KabupatenController@api')->name('api.kabupaten');
    Route::get('kabupaten/{provinsi_id}/index', 'Master\KabupatenController@index')->name('kabupaten.index');
    Route::post('kabupaten', 'Master\KabupatenController@store')->name('kabupaten.store');
    Route::delete('kabupaten/{kabupaten}', 'Master\KabupatenController@destroy')->name('kabupaten.destroy');
    Route::patch('kabupaten/{kabupaten}', 'Master\KabupatenController@update')->name('kabupaten.update');
    Route::get('kabupaten/{kabupaten}/edit', 'Master\KabupatenController@edit')->name('kabupaten.edit');

    Route::get('kecamatan/{provinsi_id}/api', 'Master\KecamatanController@api')->name('api.kecamatan');
    Route::get('kecamatan/{provinsi_id}/index', 'Master\KecamatanController@index')->name('kecamatan.index');
    Route::post('kecamatan', 'Master\KecamatanController@store')->name('kecamatan.store');
    Route::delete('kecamatan/{kecamatan}', 'Master\KecamatanController@destroy')->name('kecamatan.destroy');
    Route::patch('kecamatan/{kecamatan}', 'Master\KecamatanController@update')->name('kecamatan.update');
    Route::get('kecamatan/{kecamatan}/edit', 'Master\KecamatanController@edit')->name('kecamatan.edit');

    Route::get('kelurahan/{provinsi_id}/api', 'Master\KelurahanController@api')->name('api.kelurahan');
    Route::get('kelurahan/{provinsi_id}/index', 'Master\KelurahanController@index')->name('kelurahan.index');
    Route::post('kelurahan', 'Master\KelurahanController@store')->name('kelurahan.store');
    Route::delete('kelurahan/{kelurahan}', 'Master\KelurahanController@destroy')->name('kelurahan.destroy');
    Route::patch('kelurahan/{kelurahan}', 'Master\KelurahanController@update')->name('kelurahan.update');
    Route::get('kelurahan/{kelurahan}/edit', 'Master\KelurahanController@edit')->name('kelurahan.edit');
});

/* MASTER ROLE */
Route::group(['middleware' => ['permission:master-role']], function () {
    Route::resource('role', 'Master\RoleController');
    Route::get('api/role', 'Master\RoleController@api')->name('api.role');
    Route::get('role/{id}/permissions', 'Master\RoleController@permissions')->name('role.permissions');
    Route::post('role/storePermissions', 'Master\RoleController@storePermissions')->name('role.storePermissions');
    Route::get('role/{id}/getPermissions', 'Master\RoleController@getPermissions')->name('role.getPermissions');
    Route::delete('role/{name}/destroyPermission', 'Master\RoleController@destroyPermission')->name('role.destroyPermission');

    Route::resource('permission', 'Master\PermissionController');
    Route::get('api/permission', 'Master\PermissionController@api')->name('api.permission');
});
