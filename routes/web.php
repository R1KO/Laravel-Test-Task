<?php

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

Route::group(['middleware' => 'web'], function () {

    Route::get('/', 'WorkerController@view')->name('view');
    Route::post('import', 'WorkerController@import')->name('excel.import');
    Route::get('export', 'WorkerController@export')->name('excel.export');

	Route::group(['prefix' => 'worker', 'as' => 'worker.'], function () {

		Route::post('add', 'WorkerController@create')->name('add');
		Route::put('save/{worker}', 'WorkerController@store')->name('save');
		Route::delete('delete/{worker}', 'WorkerController@delete')->name('delete');
	});
});