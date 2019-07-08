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

Route::get('/', 'SearchController@index')->name('index');

Route::get('/search-filter/{field_name}/{field_value}','SearchController@search');

Route::get('/get-data/{data_field}','SearchController@getData');

Route::get('/search-filter-group/{field_name}/{field_value}','SearchController@groupSearch');

Route::get('/group-view','SearchController@group');

Route::get('/autocomplete/{item}/{search}','SearchController@getAutocompleteData');

Route::get('/get-data-group-by/{data_field}/{group_name}','SearchController@groupData');

