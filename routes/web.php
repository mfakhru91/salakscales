<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\DvitemController;
use App\Http\Controllers\GradingController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	return view('welcome');
})->name('home.page');

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware' => 'auth','middleware' => 'verified' ], function () {

	// print
	Route::post('/print/note/buyyer', 'PrintController@noteBuyer')->name('print.note.buyer');
	Route::post('/print/note', 'PrintController@noteBarang')->name('print.note');

	// barang
	Route::post('/barang/print', 'BarangController@printSeller')->name('print.item.seller');
	Route::post('/barang/print/buyer', 'BarangController@printBuyer')->name('print.item.buyer');
	Route::post('/note/brang/store', 'NoteController@buyerStore')->name('note.buyer.store');
	Route::get('/barang/{id}/delete', 'BarangController@delete')->name('item.delete');
	Route::post('/barang/delivery', 'BarangController@delivery')->name('barang.delivery');
	Route::post('/barang/dvitem', 'BarangController@dvitem')->name('barang.dvitem');

	// pembelian
	Route::get('/pembelian/{id}/delete/item', 'PembelianController@deleteItem')->name('item.delete.pembelian');
	Route::post('/pembelian/add_item', 'PembelianController@addItems')->name('pembelian.add.item');
	Route::get('/pembelian/{id}/delete', 'PembelianController@delete')->name('pembelian.delete');

	// penjualan
	Route::post('/pejualan/add_item', 'PenjualanController@addItems')->name('penjualan.add.item');
	Route::get('/penjualan/{id}/delete', 'PenjualanController@delete')->name('penjualan.delete');
	Route::post('/penjualan/editmincome/', 'PenjualanController@income')->name('penjulan.update.income');

	// delivery item
	Route::get('/dvitem/{id}/delete', 'DvitemController@delete')->name('dvitem.delete');
	Route::post('/dvitem/delivery/deliveryUpdate', 'DvitemController@deliveryUpdate')->name('barang.deliveryUpdate');

	// bookkeeping
	Route::get('/additional-item/{id}/delete', 'AdditionalItemController@delete')->name('additional-item.delete');
	Route::get('/additional-item/export', 'AdditionalItemController@export')->name('additional-item.export');

	// income statement
	Route::get('laporan-laba-rugi/tahun','IncomeStatementController@detaildata')->name('incomestatement.year');

	// understanding of zakat
	Route::get('dashboard/zakat', function () {
		return view('users.dashboard.zakat');
	})->name('zakat.understanding');

	// grading
	Route::get('grading/{id}/delete', 'GradingController@delete')->name('grading.delete');
	Route::post('grading/items/confirmation','GradingController@confirmation_grade')->name('grading.confirmation');
	Route::post('grading/items/confirmation/store','GradingController@graded_store_item')->name('grading.confirmation.store');

    // gradeing items
    Route::get('grading/item/{id}/edit', 'GradingController@grade_item_edit')->name('grading.item.edit');
    Route::put('grading/item/{id}/update','GradingController@grade_item_update')->name('grading.item.update');
    Route::get('grading/item/{id}/delete','GradingController@grade_item_delete')->name('grading.item.delete');

	// resource controller routing
	Route::resource('dashboard', 'DashboardController');
	Route::resource('pembelian', 'PembelianController');
	Route::resource('penjualan', 'PenjualanController');
	Route::resource('dvitem', 'DvitemController');
	Route::resource('metal', 'MetalController');
	Route::resource('barang', 'BarangController');
	Route::resource('note', 'NoteController');
	Route::resource('setting', 'SettingController');
	Route::resource('jurnal-ledger', 'JournalLedgerController');
	Route::resource('jurnal-pembelian', 'JurnalPembelianController');
	Route::resource('jurnal-penjualan', 'JurnalPenjualanController');
	Route::resource('additional-item', 'AdditionalItemController');
	Route::resource('laporan-laba-rugi', 'IncomeStatementController');
	Route::resource('grading', 'GradingController');


});
