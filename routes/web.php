<?php

use App\Http\Controllers\BarangController;
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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware' => 'auth'], function () {
	Route::post('/barang/print', 'BarangController@printSeller')->name('print.item.seller');
	Route::post('/barang/print/buyer', 'BarangController@printBuyer')->name('print.item.buyer');
	Route::post('/note/brang/store','NoteController@buyerStore')->name('note.buyer.store');
	Route::get('/barang/{id}/delete', 'BarangController@delete')->name('item.delete');
	Route::post('/print/note', 'PrintController@noteBarang')->name('print.note');
	Route::post('/print/note/buyyer', 'PrintController@noteBuyer')->name('print.note.buyer');
	Route::get('/pembelian/{id}/delete/item', 'PembelianController@deleteItem')->name('item.delete.pembelian');
	Route::post('/pembelian/add_item', 'PembelianController@addItems')->name('pembelian.add.item');
	Route::post('/pejualan/add_item', 'PenjualanController@addItems')->name('penjualan.add.item');
	Route::get('/pembelian/{id}/delete', 'PembelianController@delete')->name('pembelian.delete');
	Route::post('/barang/delivery', 'BarangController@delivery')->name('barang.delivery');
	Route::post('/barang/dvitem', 'BarangController@dvitem')->name('barang.dvitem');
	Route::resource('dashboard', 'DashboardController');
	Route::resource('pembelian', 'PembelianController');
	Route::resource('metal', 'MetalController');
	Route::resource('penjualan', 'PenjualanController');
	Route::resource('barang', 'BarangController');
	Route::resource('note', 'NoteController');
	Route::resource('setting','SettingController');
});