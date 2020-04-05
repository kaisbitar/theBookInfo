<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function viewQuranMap(Request $request)
    {   
        // $fileName = $request->fileName;
        $mappedSura = file_get_contents(storage_path('decoded_suras/المصحف_fe_sura_results.json'));

        return ($mappedSura);
    }        
    public function viewQuranSearchInfo(Request $request)
    {   
        $mappedSura = file_get_contents(storage_path('decoded_suras/المصحف_fe_sura_results.json'));
        $mappedSura = (json_decode($mappedSura, true));
        $searchInfo = [];
        for($i=1; $i<=count($mappedSura);$i++){
            $searchInfo[$i]["Sura"] = $mappedSura[$i]["Sura"];
            $searchInfo[$i]["verseIndx"] = $mappedSura[$i]["verseIndx"];
            $searchInfo[$i]["verseText"] = $mappedSura[$i]["verseText"];
            $searchInfo[$i]["NumberOfWords"] = $mappedSura[$i]["NumberOfWords"];
            $searchInfo[$i]["NumberOfLetters"] = $mappedSura[$i]["NumberOfLetters"];
            $searchInfo[$i]["bigIndex"] = $i;
        }

        return ($searchInfo);
    }
    
    public function viewLettersOcc(Request $request){

        $fileName = $request->fileName;
        $mappedSura = file_get_contents(storage_path('decoded_suras/' . $fileName . '_sura_results.json'));
        $mappedSura = (json_decode($mappedSura, true));
        $lettersOcc = [];
        $lettersOcc = $mappedSura["LetterOccurrences"];
        asort($lettersOcc);

        return ($lettersOcc);
    }
    
    public function viewWordsOcc(Request $request){

        $fileName = $request->fileName;
        $mappedSura = file_get_contents(storage_path('decoded_suras/' . $fileName . '_sura_results.json'));
        $mappedSura = (json_decode($mappedSura, true));
        $wordsOcc = [];
        $wordsOcc = $mappedSura["WordOccurrences"];
        asort($wordsOcc);

        return ($wordsOcc);
    }

    public function viewVersesNumberOfWords(Request $request){

        $fileName = $request->fileName;
        $mappedSura = file_get_contents(storage_path('decoded_suras/' . $fileName . '_sura_results.json'));
        $mappedSura = (json_decode($mappedSura, true));
        $allNumberOfwords = [];
        for($i=1; $i<=count($mappedSura["versesMap"]);$i++){
            $numberOfWords = $mappedSura["versesMap"][$i]["NumberOfWords"];
            $allNumberOfwords[$i] = $numberOfWords;
        }

        return ($allNumberOfwords);
    }

    public function viewVersesNumberOfLetters(Request $request){

        $fileName = $request->fileName;
        $mappedSura = file_get_contents(storage_path('decoded_suras/' . $fileName . '_sura_results.json'));
        $mappedSura = (json_decode($mappedSura, true));
        $allNumberOfwords = [];
        for($i=1; $i<=count($mappedSura["versesMap"]);$i++){
            $numberOfLetters = $mappedSura["versesMap"][$i]["NumberOfLetters"];
            $allNumberOfwords[$i] = $numberOfLetters;
        }

        return ($allNumberOfwords);
    }

    public function viewWordsIndexes(Request $request){

        $fileName = $request->fileName;
        $mappedSura = file_get_contents(storage_path('decoded_suras/' . $fileName . '_sura_results.json'));
        $mappedSura = (json_decode($mappedSura, true));
        $wordsIndexes = [];
        $indexes = $mappedSura["WordIndex"];
        $wordsIndexes = $indexes;

        return ($wordsIndexes);
    }
    public function viewLettersIndexes(Request $request){

        $fileName = $request->fileName;
        $mappedSura = file_get_contents(storage_path('decoded_suras/' . $fileName . '_sura_results.json'));
        $mappedSura = (json_decode($mappedSura, true));
        $wordsIndexes = [];
        $indexes = $mappedSura["LetterIndexes"];
        $wordsIndexes = $indexes;

        return ($wordsIndexes);
    }

    public function viewSuraMap(Request $request)
    {   
        $fileName = $request->fileName;
        $mappedSura = file_get_contents(storage_path('decoded_suras/' . $fileName . '_sura_results.json'));

        return ($mappedSura);
    }

    public function viewVersesMap(Request $request)
    {   
        $fileName = $request->fileName;
        $mappedSura = file_get_contents(storage_path('decoded_verses/' . $fileName . '_verses_results.json'));

        return ($mappedSura);
    }

    public function viewQuranIndex()
    {   
        $mappedSura = file_get_contents(storage_path('quranIndex'));

        return ($mappedSura);
    }
    
}
