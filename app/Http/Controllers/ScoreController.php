<?php

namespace App\Http\Controllers;

use App\Counter;
use App\FullSura;
use App\Http\Controllers\Controller;
use App\Indexer;
use App\Verse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Collection;

class ScoreController extends Controller
{
    private $phrase;
    private $allScores;
    private $words;
    private $verses;
    private $request;
    
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->allScores = $this->calculateLettersScore();
        $fileName = $request->fileName;
        $file = storage_path() . "/decoded_suras" . '/' .$fileName. '_sura_results.json';
        $results = json_decode(file_get_contents($file), true);
        $this->words = $results["WordOccurrences"];
        $this->verses = $results["VersesScore"];
    }

    public function eachWordScore()
    {
        $scores = [];

        foreach ($this->words as $word => $count) {
            $scores[$word] = $this->calculateScore($word);
        }
        arsort($scores);
        return $this->jsonResponse($scores);
    }

    public function eachVerseScore()
    {
        $scores = [];
        $resultFileName = $this->request->fileName . '_verses_score.json';
        if (!file_exists(storage_path('scored_verses/' . $resultFileName))) {
            foreach ($this->verses as $index => $verseArr) {
                if (is_numeric($index)) {
                    $verse = ($this->verses[$index]["verseText"]);
                    $stripped = preg_replace('/\s/', '', $verse);
                    $scores[$index] = [
                        "verse" => $verse,
                        "score" => $this->calculateScore($stripped)
                    ];
                }
            }
            arsort($scores);       
            file_put_contents(storage_path('scored_verses/' .$this->request->fileName.'_verses_score.json'), json_encode($scores, JSON_UNESCAPED_UNICODE));
        }
        $scores = file_get_contents(storage_path('scored_verses/' .$this->request->fileName. '_verses_score.json',JSON_UNESCAPED_UNICODE));
        if($this->request->verseIndex){
            $scores = json_decode($scores);
            $scores = collect($scores);
            $scores = $scores->filter(function ($value, $key) {
                return $key == $this->request->verseIndex;
            });

            return $scores;
        }

        return ($scores);
    }

    public function calculateScore($phrase)
    { 
        // dd($phrase);
        $lettersArray = preg_split('//u', $phrase, -1, PREG_SPLIT_NO_EMPTY);
        $score = 0;

        foreach ($lettersArray as $letter) {
            if ($letter == " ") {
                $score += 0;
                continue;
            }
    
            if ($letter == 'ء' || $letter == 'ى' || $letter == 'أ' || $letter == 'إ' || $letter == 'آ') {
                $score += $this->allScores['ا'];
                continue;
            }
    
            if ($letter == 'ؤ') {
                $score += $this->allScores['و'];
                continue;
            }
            
            if ($letter == 'ئ') {
                $score += $this->allScores['ي'];
                continue;
            }
    
            if ($letter == 'ة') {
                $score += $this->allScores['ه'];
                continue;
            }
    
            if (empty($this->allScores[$letter])) {
                $score += 0;
                continue;
            }

            $score += $this->allScores[$letter];
        }

        return $score;
    }


    private function calculateLettersScore()
    {
        // //ALJUMMAL counting
        // $occurences = [
        //     "ا" => 46287,
        //     "ب" => 11491,
        //     "ت" =>  10497,
        //     "ث" => 1414,
        //     "ج" => 3317,
        //     "ح" => 4140,
        //     "خ" => 2497,
        //     "د" => 5991,
        //     "ذ" => 4932,
        //     "ر" => 12403,
        //     "ز" => 1599,
        //     "س" => 6010,
        //     "ش" => 2124,
        //     "ص" => 2074,
        //     "ض" => 1686,
        //     "ط" => 1273,
        //     "ظ" => 853,
        //     "ع" => 9405,
        //     "غ" => 1221,
        //     "ف" => 8747,
        //     "ق" => 7034,
        //     "ك" => 10520,
        //     "ل" => 38102,
        //     "م" => 26735,
        //     "ن" => 27268,
        //     "ه" => 14851,
        //     "و" => 24967,
        //     "ي" => 21714,
        //     "ؤ" => 709,
        //     "ء" => 1698
        //     ];
        //Regular counting
        $occurences = [
        "ا" => 46287,
        "ب" => 11491,
        "ت" =>  10497,
        "ث" => 1414,
        "ج" => 3317,
        "ح" => 4140,
        "خ" => 2497,
        "د" => 5991,
        "ذ" => 4932,
        "ر" => 12403,
        "ز" => 1599,
        "س" => 6010,
        "ش" => 2124,
        "ص" => 2074,
        "ض" => 1686,
        "ط" => 1273,
        "ظ" => 853,
        "ع" => 9405,
        "غ" => 1221,
        "ف" => 8747,
        "ق" => 7034,
        "ك" => 10520,
        "ل" => 38102,
        "م" => 26735,
        "ن" => 27268,
        "ه" => 14851,
        "و" => 24967,
        "ي" => 21714,
        "ؤ" => 709,
        "ء" => 1698
        ];

        $array = [];
        $counter = 1;

        foreach ($occurences as $letter => $count) {
            if ($letter == 'ء' || $letter == 'ى') {
                $occurences['ا'] += $count;
                break;
            }

            if ($letter == 'ؤ') {
                $occurences['و'] += $count;
                break;
            }
            
            if ($letter == 'ئ') {
                $occurences['ي'] += $count;
                break;
            }

            if ($letter == 'ة') {
                $occurences['ه'] += $count;
                break;
            }

            $array[$letter] = $count;
        }

        arsort($array);
        $array = $this->attachScore($array);
        
        return $array;
    }

    private function attachScore($lettersWithOcurrences)
    {
        $returnArray = [];
        $counter = 1;
        foreach ($lettersWithOcurrences as $letter => $count) {
            $returnArray[$letter] = $counter;
            $counter++;
        }

        return $returnArray;
    }
}
