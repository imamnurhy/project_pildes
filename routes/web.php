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


/* MASTER BRAND */
Route::group(['middleware' => ['permission:master-brand']], function () {
    Route::get('brand', 'Brand\BrandController@index')->name('brand.index');
    Route::get('brand/api', 'Brand\BrandController@api')->name('brand.api');
    Route::get('brand/create', 'Brand\BrandController@create')->name('brand.create');
    Route::post('brand/store', 'Brand\BrandController@store')->name('brand.store');
    Route::get('brand/show/{id}', 'Brand\BrandController@show')->name('brand.show');
    Route::get('brand/edit/{id}', 'Brand\BrandController@edit')->name('brand.edit');
    Route::patch('brand/update/{id}', 'Brand\BrandController@update')->name('brand.update');
    Route::delete('brand/delete/{id}', 'Brand\BrandController@destroy')->name('brand.destroy');


    Route::get('jenis', 'Brand\JenisAsetController@index')->name('jenis.index');
    Route::get('jenis/api', 'Brand\JenisAsetController@api')->name('jenis.api');
    Route::get('jenis/create', 'Brand\JenisAsetController@create')->name('jenis.create');
    Route::post('jenis/store', 'Brand\JenisAsetController@store')->name('jenis.store');
    Route::get('jenis/show/{id}', 'Brand\JenisAsetController@show')->name('jenis.show');
    Route::get('jenis/edit/{id}', 'Brand\JenisAsetController@edit')->name('jenis.edit');
    Route::patch('jenis/update/{id}', 'Brand\JenisAsetController@update')->name('jenis.update');
    Route::delete('jenis/delete/{id}', 'Brand\JenisAsetController@destroy')->name('jenis.destroy');
});


/* MASTER ASET */
Route::group(['middleware' => ['permission:master-aset']], function () {
    Route::prefix('aset')->namespace('Aset')->name('aset.')->group(function () {
        Route::post('masuk/api', 'AsetMasukController@api')->name('masuk.api');

        Route::get('getMerk/{id_nama_aset}', 'AsetMasukController@getMerk')->name('masuk.getMerk');
        route::get('masuk/generateNoAset', 'AsetMasukController@generateNoAset')->name('masuk.generateNoAset');
        route::get('masuk/showDetail/{id}', 'AsetMasukController@showDetail')->name('masuk.showDetail');
        Route::get('masuk/{provinsi_id}/getKabupaten', 'AsetMasukController@getKabupaten')->name('masuk.getKabupaten');
        Route::get('masuk/{kabupaten_id}/getKecamatan', 'AsetMasukController@getKecamatan')->name('masuk.getKecamatan');
        Route::get('masuk/{kecamatan_id}/getKelurahan', 'AsetMasukController@getKelurahan')->name('masuk.getKelurahan');
        Route::post('masuk/storeDetailTanah', 'AsetMasukController@storeDetailTanah')->name('masuk.storeDetailTanah');
        Route::delete('masuk/{id}/hapusBerkas', 'AsetMasukController@hapusBerkas')->name('masuk.hapusBerkas');
        Route::get('masuk/{id}/download_berkas', 'AsetMasukController@download_berkas')->name('masuk.download_berkas');
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

/* MASTER PERTANYAAN */
Route::group(['middleware' => ['permission:master-pertanyaan']], function () {
    Route::get('pertanyaan/api', 'PertanyaanController@api')->name('pertanyaan.api');
    Route::resource('pertanyaan', 'PertanyaanController');

    Route::get('jenis_pertanyaan/api', 'JenisPertanyaanController@api')->name('jenis_pertanyaan.api');
    Route::resource('jenis_pertanyaan', 'JenisPertanyaanController');
});

/* MASTER USER PERTANYAAN */
Route::group(['middleware' => ['permission:master-user-pertanyaan']], function () {
    Route::get('pertanyaanMasuk/api', 'UserPertanyaanController@api')->name('pertanyaanMasuk.api');
    Route::resource('pertanyaanMasuk', 'UserPertanyaanController');
});

Route::prefix('account')->group(function () {
    Route::get('profile', 'AccountController@profile')->name('account.profile');
    Route::post('profile/updateFoto', 'AccountController@updateFoto')->name('account.updateFoto');

    Route::get('password', 'AccountController@password')->name('account.password');
    Route::patch('password', 'AccountController@updatePassword')->name('account.password');
});

// MASTER PERMOHONAN
Route::prefix('permohonan')->name('permohonan.')->middleware('permission:master-permohonan')->group(function () {
    Route::get('index', 'PermohonanController@index')->name('index');
    Route::get('edit/{id}', 'PermohonanController@edit')->name('edit');
    Route::patch('update/{id}', 'PermohonanController@update')->name('update');
    Route::get('detail/{id}', 'PermohonanController@detail')->name('detail');
    Route::delete('destroy/{id}', 'PermohonanController@destroy')->name('destroy');
    Route::get('api', 'PermohonanController@api')->name('api');
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
