<?php

namespace App\Http\Controllers;

use App\Counter;
use App\FullSura;
use App\Http\Controllers\Controller;
use App\Indexer;
use App\Verse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ScoreController extends Controller
{
    private $phrase;
    private $allScores;
    private $words;
    private $verses;
    
    public function __construct(Request $request)
    {
        $this->allScores = $this->calculateLettersScore();
        $file = storage_path() . "/decoded_suras/كامل sura results.json";
        $results = json_decode(file_get_contents($file), true);
        $this->words = $results["wordOccurrences"];
        $this->verses = $results["VerseIndex"];
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
        foreach ($this->verses as $verse) {
            $stripped = preg_replace('/\s/', '', $verse);
            $scores[$verse] = $this->calculateScore($stripped);
        }
        
        arsort($scores);
        return $this->jsonResponse($scores);
    }

    public function calculateScore($phrase)
    {
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
        $occurences = [
        "ا" => 46287,
        "ب" => 11491,
        "ت" => 10520,
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
        "ك" => 10497,
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
