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

Route::get('/', 'SearchController@search');
Route::get('/autocomplete', 'SearchController@autocomplete');
Route::post('/autocomplete', 'SearchController@autocomplete')->name('autocomplete');
Route::get('/search', 'SearchController@search');
Route::get('/add-words', 'SearchController@addWords')->name('add-words');
Route::post('/add-words', 'SearchController@saveWords');
Route::get('/scrap', 'ScrapController@index');
