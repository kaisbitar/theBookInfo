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

Route::get('sura-map', 'CalculatorController@mapSura');
Route::get('verses-map', 'CalculatorController@mapVerses');
Route::get('sanatize', 'SanatizerController@runSanatization');
Route::get('letters-score', 'ScoreController@calculateLettersScore');
