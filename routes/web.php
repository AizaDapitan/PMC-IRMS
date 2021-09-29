<?php

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

Route::get('/','Auth\LoginController@showLoginForm')->name('login');

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
	Route::resource('/issuances','IssuanceHeaderController');
	Route::post('/issuance-cancel','IssuanceHeaderController@cancel')->name('issuance.cancel');
	Route::get('/ajax-get-ppe-item-details','IssuanceHeaderController@ajax_get_item_details')->name('ajax-get-ppe-item-details');

	Route::post('/issuance-remove-item','IssuanceHeaderController@remove_item')->name('issuance.remove-item');

	Route::get('/print-issuance/{id}','IssuanceHeaderController@print')->name('issuance-print');

	Route::get('/ajax-employees','IssuanceHeaderController@employees')->name('ajax-employees');
	Route::get('/ajax-contractors','IssuanceHeaderController@contractors')->name('ajax-contractors');


	// Maintenance
	Route::resource('/ppe-items','ItemCategoryController');
	Route::post('/ppe-category-update','ItemCategoryController@category_update')->name('ppe-category.update');
	Route::post('/ppe-category-delete','ItemCategoryController@category_delete')->name('ppe-category.delete');
	Route::post('/ppe-category-multiple-delete','ItemCategoryController@category_multiple_delete')->name('ppe-category.multiple-delete');

	Route::resource('/ppe-types','ItemTypeController');
	Route::post('/ppe-item-update','ItemTypeController@item_update')->name('ppe-item.update');
	Route::post('/ppe-item-delete','ItemTypeController@item_delete')->name('ppe-item.delete');
	Route::post('/ppe-item-multiple-delete','ItemTypeController@item_multiple_delete')->name('ppe-item.multiple-delete');

	Route::resource('/users','UserController');
	Route::post('/user-change-status','UserController@change_status')->name('user.change-status');
	Route::post('/user-reset-password','UserController@reset_password')->name('user.reset-password');

	// Reports
	Route::get('/report/issuance-request-summary','ReportController@issuance_summary')->name('report.issuance-summary');
	Route::post('/export-issuance-summary','ReportController@export_issuance_summary')->name('export.issuance_summary');
	
	Route::get('/report/cancelled-issuances','ReportController@cancelled')->name('report.cancelled-issuances');
	Route::post('/export-cancelled','ReportController@export_cancelled')->name('export.cancelled');

	Route::get('/report/unserve-issuances','ReportController@unserve')->name('report.unserve-issuances');
	Route::post('/export-unserve','ReportController@export_unserve')->name('export.unserve');

	Route::get('/change-password','UserController@change_password')->name('change-password');
	Route::put('/update-password', 'UserController@update_password')->name('update-password');
});

