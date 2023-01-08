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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/main_page', 'mainController@index')->name('main_page');
Route::get('/all_photo', 'PhotoController@index')->name('all_photo');
Route::get('/manage_photo', 'ManageController@index')->name('manage_photo');
// pdf_page
Route::get('/test_fpdf', 'FpdfController@index')->name('test_fpdf');

// ajax
// main_page
Route::post('/main_page/more_photo', 'MainController@more_photo')->name('main_pahe.more_photo');
// all_photo
Route::post('/all_photo/photo/{photo}', 'PhotoController@single')->name('all_photo.single_photo');
Route::post('/all_photo/comment/{photo}', 'PhotoController@comment')->name('comment.all_comment');
Route::post('/all_photo/comment/{photo}/write', 'PhotoController@write_comment')->name('comment.write_comment');
Route::post('/all_photo/comment/delete/{comment}', 'PhotoController@delete_comment')->name('comment.delete_comment');
Route::post('/all_photo/comment/update/{comment}', 'PhotoController@update_comment')->name('comment.update_comment');
// release_photo
Route::post('/manage_photo/upload_photo/preview', 'ManageController@upload_photo_preview')->name('release_photo.upload_photo_preview');
Route::post('/manage_photo/release_photo', 'ManageController@release_photo')->name('release_photo.release_photo');
// manage_photo
Route::post('/manage_photo/all_photo', 'ManageController@all_photo')->name('manage_photo.all_photo');
Route::post('/manage_photo/delete/{photo}', 'ManageController@delete_photo')->name('manage_photo.delete_photo');
Route::post('/manage_photo/update_photo/preview', 'ManageController@update_photo_preview')->name('manage_photo.update_photo_preview');
Route::post('/manage_photo/update_photo/submit/{photo}', 'ManageController@update_photo_submit')->name('manage_photo.update_photo_submit');
Route::post('/manage_photo/update_introduction/{photo}', 'ManageController@update_introduction')->name('manage_photo.update_introduction');
