<?php

Route::get('/', function () {
    return redirect('login');
});

Route::get('/logout', function () {
    return "<center>Someting It's Wrong.</center>";;
});

Auth::routes();

Route::prefix('home')->group(function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/grafikLelang', 'HomeController@grafikLelang')->name('home.grafikLelang');
});

Route::prefix('account')->group(function() {
    Route::get('profile', 'AccountController@profile')->name('account.profile');
    Route::post('profile/updateFoto', 'AccountController@updateFoto')->name('account.updateFoto');
    
    Route::get('password', 'AccountController@password')->name('account.password');
    Route::patch('password', 'AccountController@updatePassword')->name('account.password');
});

    /* MAIN MENU SELEKSI JABATAN */
Route::group(['middleware' => ['permission:petugas-panselnas']], function () {
    Route::prefix('seleksi')->group(function () {
        Route::get('pansel', 'Seleksi\PanselnasController@index')->name('panselnas');
        Route::post('api/pansel', 'Seleksi\PanselnasController@api')->name('api.panselnas');
        Route::get('pansel/{id}', 'Seleksi\PanselnasController@edit')->name('panselnas.edit');
        Route::patch('pansel/{id}', 'Seleksi\PanselnasController@update')->name('panselnas.update');
        Route::patch('pansel/{id}/mutasi', 'Seleksi\PanselnasController@updateMutasi')->name('panselnas.updateMutasi');
    });
});

Route::group(['middleware' => ['permission:petugas-panselnas-admin']], function () {
    Route::prefix('seleksi')->group(function () {
        Route::get('admin-pansel', 'Seleksi\AdminController@index')->name('admin.panselnas');
        Route::post('api/admin-pansel', 'Seleksi\AdminController@api')->name('api.admin.panselnas');
        Route::get('admin-pansel/{id}', 'Seleksi\AdminController@edit')->name('admin.panselnas.edit');
        Route::patch('admin-pansel/{id}', 'Seleksi\AdminController@update')->name('admin.panselnas.update');
        Route::patch('admin-pansel/{id}/mutasi', 'Seleksi\AdminController@updateMutasi')->name('admin.panselnas.updateMutasi');

        Route::get('arsipSetuju', 'Seleksi\ArsipSetujuController@index')->name('arsipSetuju');
        Route::post('api/arsipSetuju', 'Seleksi\ArsipSetujuController@api')->name('api.arsipSetuju');
        Route::get('arsipSetuju/{id}', 'Seleksi\ArsipSetujuController@edit')->name('arsipSetuju.edit');
        Route::get('arsipTolak', 'Seleksi\ArsipTolakController@index')->name('arsipTolak');
        Route::post('api/arsipTolak', 'Seleksi\ArsipTolakController@api')->name('api.arsipTolak');
        Route::get('arsipTolak/{id}', 'Seleksi\ArsipTolakController@edit')->name('arsipTolak.edit');
    });
});

    /* REPORT */
Route::group(['middleware' => ['permission:report-lelang']], function () {
    Route::prefix('report')->group(function () {
        Route::get('registrasi', 'Report\RegistrasiController@index')->name('registrasi.report');
        Route::post('api/registrasi', 'Report\RegistrasiController@api')->name('api.registrasi.report');
        Route::get('registrasi/exportToExcel/{d_dari}/{d_sampai}', 'Report\RegistrasiController@exportToExcel')->name('registrasi.report.exportToExcel');
        
        Route::get('seleksi', 'Report\SeleksiController@index')->name('seleksi.report');
        Route::post('api/seleksi', 'Report\SeleksiController@api')->name('api.seleksi.report');
        Route::get('seleksi/exportToExcel/{d_dari}/{d_sampai}', 'Report\SeleksiController@exportToExcel')->name('seleksi.report.exportToExcel');
    });
});

    /* CONFIG LELANG JABATAN */
Route::group(['middleware' => ['permission:config-lelang_jabatan']], function () {
    Route::resource('lelang', 'Lelang\LelangController');
    Route::get('api/lelang', 'Lelang\LelangController@api')->name('api.lelang');

    Route::get('api/lelangsyarat/{lelang_id}', 'Lelang\LelangsyaratController@api')->name('api.lelangsyarat');
    Route::get('lelangsyarat/{lelang_id}/index', 'Lelang\LelangsyaratController@index')->name('lelangsyarat.index');
    Route::post('lelangsyarat', 'Lelang\LelangsyaratController@store')->name('lelangsyarat.store');
    Route::delete('lelangsyarat/{id}', 'Lelang\LelangsyaratController@destroy')->name('lelangsyarat.destroy');
    Route::patch('lelangsyarat/{id}', 'Lelang\LelangsyaratController@update')->name('lelangsyarat.update');
    Route::get('lelangsyarat/{id}/edit', 'Lelang\LelangsyaratController@edit')->name('lelangsyarat.edit');

    Route::resource('pengumuman', 'Lelang\PengumumanController');
    Route::get('api/pengumuman', 'Lelang\PengumumanController@api')->name('api.pengumuman');
    
    Route::resource('content', 'Lelang\ContentController');
    Route::get('api/content', 'Lelang\ContentController@api')->name('api.content');

    Route::resource('agenda', 'Lelang\AgendaController');
    Route::get('api/agenda', 'Lelang\AgendaController@api')->name('api.agenda');

    Route::resource('album', 'Lelang\AlbumController');
    Route::get('api/album', 'Lelang\AlbumController@api')->name('api.album');

    Route::get('api/albumfoto/{album_id}', 'Lelang\AlbumfotoController@api')->name('api.albumfoto');
    Route::get('albumfoto/{album_id}/index', 'Lelang\AlbumfotoController@index')->name('albumfoto.index');
    Route::post('albumfoto', 'Lelang\AlbumfotoController@store')->name('albumfoto.store');
    Route::delete('albumfoto/{id}', 'Lelang\AlbumfotoController@destroy')->name('albumfoto.destroy');
    Route::patch('albumfoto/{id}', 'Lelang\AlbumfotoController@update')->name('albumfoto.update');
    Route::get('albumfoto/{id}/edit', 'Lelang\AlbumfotoController@edit')->name('albumfoto.edit');

    Route::resource('filedownload', 'Lelang\FiledownloadController');
    Route::get('api/filedownload', 'Lelang\FiledownloadController@api')->name('api.filedownload');

    Route::resource('syarat', 'Lelang\SyaratController');
    Route::get('api/syarat', 'Lelang\SyaratController@api')->name('api.syarat');
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