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


Auth::routes();

Route::get('logout', 'Auth\LoginController@logout');
// Route::get('/','Auth\LoginController@showLoginForm')->name('login');
Route::get('/','Auth\LoginController@index')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.submit'); // login submit

Route::get('adminlogin/admin', 'Auth\LoginController@adminLogin')->name('login.adminLogin'); // login
Route::post('adminsubmit/admin', 'Auth\LoginController@adminSubmit')->name('login.adminsubmit'); // login submit
Route::group(['middleware' => ['auth']], function () {
	Route::resource('/issuances','IssuanceHeaderController');
	// Route::get('issuances','IssuanceHeaderController@index')->name('issuances');
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

	//Roles
	Route::resource('/roles','RoleController');
	Route::post('/role-update','RoleController@role_update')->name('role.update');

	//Permissions
	Route::resource('/permissions','PermissionController');
	Route::post('/permission-update','PermissionController@permission_update')->name('permission.update');
		
	// Users
	Route::resource('/users','UserController');
	Route::post('/user-change-status','UserController@change_status')->name('user.change-status');
	Route::post('/user-reset-password','UserController@reset_password')->name('user.reset-password');

	//Role Access right routes
	Route::group(['prefix' => 'roleaccessrights'], function () {
		Route::get('/', 'RoleRightController@index')->name('maintenance.roleaccessrights');
		Route::post('store', 'RoleRightController@store')->name('maintenance.roleaccessrights.store');
		Route::get('store', 'RoleRightController@store')->name('maintenance.roleaccessrights.store');
	});   

	//User Access right routes
	Route::group(['prefix' => 'useraccessrights'], function () {
		Route::get('/', 'UserRightController@index')->name('maintenance.useraccessrights');
		Route::post('store', 'UserRightController@store')->name('maintenance.useraccessrights.store');
		Route::get('store', 'UserRightController@store')->name('maintenance.useraccessrights.store');
	});

	// Application routes
	Route::group(['prefix' => 'application/maintenance'], function () {
		Route::get('/', 'ApplicationController@index')->name('maintenance.application.index');
		Route::post('store', 'ApplicationController@store')->name('maintenance.application.store');
		Route::post('edit', 'ApplicationController@edit')->name('maintenance.application.edit');
		Route::put('update', 'ApplicationController@update')->name('maintenance.application.update');
		Route::delete('{id}/destroy', 'ApplicationController@destroy')->name('maintenance.application.destroy');
		Route::any('/search', 'ApplicationController@search')->name('maintenance.application.search');
		Route::get('{id}/destroy', 'ApplicationController@destroy')->name('maintenance.application.destroy');
		Route::get('systemDown', 'ApplicationController@systemDown')->name('maintenance.application.systemDown');
		Route::get('systemUp', 'ApplicationController@systemUp')->name('maintenance.application.systemUp');
		Route::get('create_indexing', 'ApplicationController@create_indexing')->name('maintenance.application.create_indexing');
	});  	
		
	// Reports
	Route::get('/report/issuance-request-summary','ReportController@issuance_summary')->name('report.issuance-summary');
	Route::post('/export-issuance-summary','ReportController@export_issuance_summary')->name('export.issuance_summary');
	
	Route::get('/report/cancelled-issuances','ReportController@cancelled')->name('report.cancelled-issuances');
	Route::post('/export-cancelled','ReportController@export_cancelled')->name('export.cancelled');

	Route::get('/report/unserve-issuances','ReportController@unserve')->name('report.unserve-issuances');
	Route::post('/export-unserve','ReportController@export_unserve')->name('export.unserve');

	Route::get('/change-password','UserController@change_password')->name('change-password');
	Route::put('/update-password', 'UserController@update_password')->name('update-password');

	Route::get('audit-logs', 'ReportController@auditLogs')->name('report.audit-logs');
	Route::get('error-logs', 'ReportController@errorLogs')->name('report.error-logs');
});

