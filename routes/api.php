<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//api resources
Route::get('sura-map/{fileName}', 'CalculatorController@mapSura');
Route::get('verses-map/{fileName}', 'CalculatorController@mapVerses');
Route::get('sanatize', 'SanatizerController@runSanatization');
Route::get('words-score/{fileName}', 'ScoreController@eachWordScore');
Route::get('verses-score/{fileName}', 'ScoreController@eachVerseScore');
Route::get('suras-list', 'controller@listSuras');

//Run Backend calculations and create decoded verses and suras results files
Route::get('decode-all', 'controller@runBackend');
