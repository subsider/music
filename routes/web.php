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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::name('admin.')->prefix('admin')->namespace('Admin')->group(function () {
    Route::namespace('Artist')->group(function () {
        Route::resource('artists', 'ArtistsController');
        Route::resource('artists.albums', 'ArtistAlbumsController');
        Route::resource('artists.related', 'ArtistRelatedController');
        Route::resource('artists.tracks', 'ArtistTracksController');
        Route::resource('artists.tags', 'ArtistTagsController');
    });
});
