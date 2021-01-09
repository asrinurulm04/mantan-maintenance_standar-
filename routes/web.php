<?php

// ROUTE LOGIN DAN REGISTRASI KESELURUHAN
Route::post('/login', 'Auth\LoginController@login')->middleware('ceklevel');
Route::post('/login', [
    'uses'          => 'Auth\AuthController@login',
    'middleware'    => 'checkstatus',
]);
Route::get('/signup', 'SignupController@form');
Route::post('/signup/store', 'SignupController@signup');
Route::get('/success', 'SignupController@success');

Route::get('/', function () {return redirect('/login');});

Auth::routes();
Auth::routes(['verify' => true]);
Route::get('perbaikan','HomeController@perbaikan')->name('perbaikan');

Route::get('/home', 'HomeController@index')->name('home');

// Aktivasi registrasi
Route::get('activation/{token}', function ($token)
{
    $user = App\User::where('activation_token', $token)->first();
 
    if ($user) {
        $user->activated_at = \Carbon\Carbon::now();
        $user->save();
 
        return 'Your account has been activated.';
    }
 
    return 'Invalid activation token.';
});
// AKHIR ROUTE LOGIN DAN REGISTRASI KESELURUHAN

Route::get('/tes','HomeController@tes');
Route::get('/tes2','HomeController@tes2');
// Home Controller
Route::get('hapusnotif','HomeController@hapusnotif')->name('hapusnotif');
Route::get('/history','HomeController@history');
Route::get('/history/json','HomeController@json_history');
Route::get('/history/detail/{id_order}','HomeController@history_detail')->name('detailhistory');
Route::get('/cari/tanggal','HomeController@cari_tanggal');
Route::get('/cari/history','HomeController@cari_history');

Route::get('/history/pakai','HomeController@history_pakai');
Route::get('/history/pakai/json','HomeController@json_history_pakai');
Route::get('/history/pakai/detail/{id_order}','HomeController@history_detail_pakai');
Route::get('/detail/history/pakai/standar/{id_history}','HomeController@history_detail_pakai_standar');

Route::get('/rnd/kategori','HomeController@kategori');
Route::get('/rnd/kategori/json','HomeController@json_kategori');
Route::post('/rnd/tambah/kategori','HomeController@tambah_kategori');
Route::get('/rnd/kategori/nonaktif/{id_sub_kategori}','HomeController@nonaktifkategori');
Route::get('/rnd/kategori/aktif/{id_sub_kategori}','HomeController@aktifkategori');

Route::get('/rnd/plant','HomeController@plant');
Route::get('/rnd/plant/json','HomeController@json_plant');
Route::post('/rnd/tambah/plant','HomeController@tambah_plant');
Route::get('/rnd/plant/nonaktif/{id_plant}','HomeController@nonaktifplant');
Route::get('/rnd/plant/aktif/{id_plant}','HomeController@aktifplant');

Route::get('/rnd/satuan','HomeController@satuan');
Route::get('/rnd/satuan/json','HomeController@json_satuan');
Route::post('/rnd/tambah/satuan','HomeController@tambah_satuan');
Route::get('/rnd/satuan/nonaktif/{id_satuan}','HomeController@nonaktifsatuan');
Route::get('/rnd/satuan/aktif/{id_satuan}','HomeController@aktifsatuan');

//Admin
Route::post('/user/konfirmasi/post','AdminController@konfirmasi');
Route::get('/admin/bagian','AdminController@bagian');
Route::get('/admin/bagian/json','AdminController@json_bagian');
Route::post('/admin/tambah/bagian','AdminController@tambah_bagian');
Route::get('/admin/bagian/nonaktif/{id_bagian}','AdminController@ubah_menjadi_non_aktif');
Route::get('/admin/bagian/aktif/{id_bagian}','AdminController@ubah_menjadi_aktif');

// My Profile
Route::get('user','AdminController@user_aktif');
Route::get('/user/json','AdminController@json');
Route::get('/admin/profile','AdminController@profile');
Route::post('/update/profile','HomeController@update_profile');
Route::post('/ubah/password','HomeController@ubah_password');

// Users Profile
Route::get('/user/hapus/{id}','AdminController@hapususer');
Route::get('/edit/users/profile/{id}','AdminController@edit_users_profile');
Route::post('/update/users/profile','AdminController@update_users_profile');

Route::get('/stok/rnd', 'AdminController@stok_rnd');
Route::post('/admin/ubah/ke/freeze', 'AdminController@ubah_freeze');
Route::get('/data/standar/hapus/{id_standar}', 'AdminController@standarhapus');
Route::get('/data/standar/edit/{id_standar}', 'AdminController@standar_edit');
Route::post('/data/standar/update', 'AdminController@standar_update');

Route::get('/admin/standar/freeze', 'AdminController@datafreeze');
Route::get('/admin/standar/lokasi', 'AdminController@standar_lokasi');

Route::get('/data/user/aktif', 'AdminController@user_aktif');
Route::get('/data/user/belum/aktif', 'AdminController@user_belum_aktif');

Route::get('/notifikasi', 'AdminController@notifikasi');

Route::get('/admin/order/qc', 'AdminController@order_qc');
Route::get('/order/diterima/qc', 'AdminController@order_diterima_qc');
Route::get('/order/rnd', 'AdminController@order_rnd');

Route::get('/stok/qc/wip', 'AdminController@stok_qc_wip');
Route::get('/stok/qc/bahan/baku', 'AdminController@stok_qc_bahan_baku');

Route::get('/index', 'AdminController@index');
// history

Route::get('/admin/history','QCController@history');
Route::get('/admin/cari/tanggal','QCController@cari_tanggal');

// QC BARU

Route::get('/qc/awal/pesan/{id_standar}', 'QCController@pesan_stok');
Route::post('/qc/masuk/keranjang', 'QCController@masuk_keranjang');
Route::post('/qc/order/hapus/satu', 'QCController@order_hapus_satu');
Route::post('/qc/order/kirim/satu/post', 'QCController@order_kirim_satu_post');
Route::post('/qc/order/batal/kirim/satu/post', 'QCController@order_batal_kirim_satu_post');
Route::post('/qc/order/kirim/semua/post', 'QCController@order_kirim_semua');

// AKhir QC Baru

//QC

Route::get('/qc/notifikasi', 'QCController@notifikasi');

Route::get('/qc/order/diterima/qc', 'QCController@orderditerimaqc');
Route::get('/qc/order/diterima', 'QCController@orderditerima');
Route::get('/qc/perubahan', 'QCController@perubahan');

Route::post('/qc/terpakai', 'QCController@stok_terpakai');

Route::get('/qc/stok/standar', 'QCController@stok');
Route::get('/qc/pakai/stok/{id_standar}', 'QCController@pakai_stok');
Route::post('/qc/pakai/stok/', 'QCController@pakai_stok_proses');
Route::get('/qc/stok/baku/tambah/{id_standar}', 'QCController@stok_baku_tambah');
Route::post('/qc/stok/update','QCController@stok_update');
Route::post('/qc/stok/terpakai','QCController@stok_terpakai');
Route::get('/qc/stok/cari', 'QCController@cari');
Route::get('/qc/stok/cari/nama', 'QCController@cari_nama');
Route::get('/qc/stok/terpakai', 'QCController@terpakai');


Route::get('/qc/stok/baku', 'QCController@stok_baku');
Route::get('/qc/stok/baku/cari', 'QCController@cari_baku');
Route::get('/qc/baku/cari/nama', 'QCController@cari_baku_nama');

Route::get('/add-to-cart/{id}', ['uses' => 'QCController@getAddToCart', 'as' => 'standar.AddToCart']);
Route::get('/qc/order', 'QCController@order');
Route::get('/qc/order/keranjang/{id_standar}', 'QCController@order_keranjang');
Route::post('/qc/order/keranjang','QCController@proses_keranjang');
Route::get('/qc/keranjang/total', 'QCController@total');
Route::get('/qc/keranjang/hapus/{id_keranjang}', 'QCController@keranjang_hapus');
Route::get('/qc/kirim/satu/keranjang/{id_keranjang}','QCController@kirim_satu_keranjang');
Route::post('/qc/kirim/semua/keranjang','QCController@kirim_semua_keranjang');

Route::get('/qc/history/order/hapus/{id_order}','QCController@history_order_hapus');
Route::get('/qc/history/order/cari', 'QCController@cari_history_order');
Route::get('/qc/history/order/cari2', 'QCController@cari_history_order2');

Route::get('/qc/history/update','QCController@history_update');
Route::get('/qc/history/pemakaian/cari', 'QCController@cari_history_pemakaian');


Route::get('/qc/order/diterima2', 'QCController@order_diterima2');
Route::get('/qc/order/diterima', 'QCController@order_diterima');
Route::post('/qc/terima/order', 'QCController@terima_order');
Route::get('/qc/order/diterima/{id_order}', 'QCController@hapus');


//RND
Route::get('rnd/cetak','RNDController@cetaklabel')->name('cetakstandar');
Route::get('rnd/cetakBB','RNDController@cetaklabelBB')->name('cetakstandarBB');
Route::get('/rnd/notifikasi', 'RNDController@notifikasi');
Route::get('/rnd/back', 'RNDController@back');

// WIP
Route::get('/rnd/data/standar', 'RNDController@standar');
Route::get('/rnd/standar/cari', 'RNDController@cari_standar');
Route::get('/rnd/stok/wip/cari', 'RNDController@cari_stok_wip');

//Kirim
Route::get('/rnd/awal/kirim/{id_standar}', 'RNDController@awal_kirim');
Route::post('/rnd/masuk/keranjang', 'RNDController@masuk_keranjang');

//crud data standar
Route::get('/rnd/baku/edit/{id_standar}', 'RNDController@baku_edit');
Route::post('/rnd/data/standar/hapus', 'RNDController@data_standar_hapus');
Route::get('/rnd/data/standar/edit/{id_standar}', 'RNDController@standar_edit');
Route::get('/rnd/data/standar/lihat/{id_standar}', 'RNDController@standar_lihat');
Route::post('/rnd/data/standar/update', 'RNDController@standar_update');
Route::post('/rnd/data/standar/freeze', 'RNDController@ubah_ke_freeze');

// Freeze
Route::get('/rnd/standar/freeze', 'RNDController@freeze');
Route::get('/standar/freeze/json','RNDController@json_freeze');
Route::post('/data/standar/unfreeze', 'RNDController@unfreeze');
Route::get('/rnd/standar/unfreeze/{id_standar}', 'RNDController@unfreeze');
Route::get('/rnd/standar/freeze/edit/{id_standar}', 'RNDController@standar_freeze_edit');
Route::post('/rnd/standar/freeze/update', 'RNDController@standar_freeze_update');


// Input Item Baru
Route::get('/rnd/input/wip/baru', 'HomeController@input_wip_baru');
Route::post('/rnd/input/wip/baru/store', 'HomeController@input_wip_baru_store');
Route::get('/rnd/input/bahan/baku/baru', 'HomeController@input_bahan_baku_baru');
Route::post('/rnd/input/bahan/baku/baru/store', 'HomeController@input_bahan_baku_baru_store');

// Route::post('/rnd/input/wip/baru/store', 'RNDController@input_item_baru_store');

// Order

Route::get('/rnd/order', 'RNDController@order');
Route::get('/rnd/cari/nama/order','RNDController@cari_nama_order');
Route::get('/rnd/cari/tanggal/order','RNDController@cari_tanggal_order');
Route::get('/rnd/cari/tanggal/order/unrequest','RNDController@cari_tanggal_order_unrequest');
Route::get('/rnd/order/unrequest', 'RNDController@order_unrequest');
Route::post('/rnd/order/unrequest/batal', 'RNDController@order_unrequest_batal');
Route::post('rnd/order/batal', 'RNDController@order_batal')->name('rnd/order/batal');
Route::get('/rnd/order/proses/{id_order}', 'RNDController@order_proses');
Route::get('/rnd/order/proses/unrequest/{id_order}', 'RNDController@order_proses_unrequest');
Route::post('/rnd/order/proses', 'RNDController@proses_order');
Route::post('/rnd/order/proses/unrequest', 'RNDController@proses_order_unrequest');
Route::get('/rnd/order/terkirim/hapus/{id_order}', 'RNDController@order_terkirim_hapus');

Route::get('download_order','excelController@download_order')->name('download_order');
Route::get('download_wip','excelWIP@download_wip')->name('download_wip');
Route::get('/rnd/standar/lokasi', 'RNDController@lokasi');
Route::get('/rnd/ExportWIP','RNDController@export_excel_wip');
Route::get('/rnd/ExportBaku','RNDController@export_excel_baku');
Route::get('/cari/tanggal/detail','HomeController@cari_tanggal_detail');

// Bahan Baku
Route::get('/rnd/standar/baku', 'RNDController@standar_baku');
Route::get('/rnd/bahan/baku/edit/{id_standar}', 'RNDController@bahan_baku_edit');
Route::post('/rnd/bahan/baku/update', 'RNDController@bahan_baku_update');
Route::get('/rnd/baku/cari', 'RNDController@cari_standar_baku');
Route::get('/rnd/stok/baku/cari', 'RNDController@cari_stok_baku');

// History
Route::get('/rnd/history','RNDController@history');
Route::get('/rnd/cari/tanggal','RNDController@cari_tanggal');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// cetak
 Route::get('spreadsheet/download',[
    'as' => 'spreadsheet/download', 
    'uses' => 'cetakController@cetak_all'
 ]);

 Route::post('/cetak_id','cetakController@cetak_id')->name('cetak_id');
 Route::get('cetakBB','cetakBBController@cetak_allBB')->name('cetakBB');
 Route::post('/cetak_idBB','cetakBBController@cetak_idBB')->name('cetak_idBB');
 Route::get('cetakkeranjang','cetakkeranjangController@cetak_allkeranjang')->name('cetakkeranjang');