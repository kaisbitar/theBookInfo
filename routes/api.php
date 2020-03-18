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

//front-end resources
Route::get('verses-map-f/{fileName}', 'ViewController@viewVersesMap');
Route::get('quran-map-f/{fileName}', 'ViewController@viewQuranMap');
Route::get('quran/quranIndex','ViewController@viewQuranIndex');
Route::get('sura-map-f/{fileName}','ViewController@viewQuranSearchInfo');
Route::get('quran-search-info/{fileName}','ViewController@viewQuranSearchInfo');
//Scores:
Route::get('words-score/{fileName}', 'ScoreController@eachWordScore');
Route::get('verses-score/{fileName}', 'ScoreController@eachVerseScore');
Route::get('verse-score/{fileName}/{verseIndex}', 'ScoreController@singleVerseScore');

Route::get('find/{fileName}', 'ScoreController@find19InSura');


// Backend calculations
Route::get('sura-map/{fileName}', 'CalculatorController@mapSura');
Route::get('verses-map/{fileName}', 'CalculatorController@mapVerses');
Route::get('letters-map/{fileName}', 'CalculatorController@mapLetters');
Route::get('sanatize', 'SanatizerController@runSanatization');
//send quraIndex
Route::get('quran-index/{fileName}', 'CalculatorController@listSuras');
Route::get('decode-all', 'CalculatorController@runBackend');
//you have to decode-all before running Quran map
Route::get('quran-map/{fileName}', 'CalculatorController@mapComplete');
Route::get('count-letters/{suraIndex}', 'CollecterController@countLetters');
Route::get('calculate-sura-19/{suraName}', 'CollecterController@calculateSura19');
