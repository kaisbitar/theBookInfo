<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FullSura extends Model
{
    public $suraFile;

    public function __construct($file)
    {
        // $file = \utf8_decode($file);
        $this->suraFile =  explode(",", $file);

        return $this;
    }

    public function breakToVerses()
    {
        $fullSura = $this->suraFile;

        for ($i = 0; $i < sizeof($fullSura); $i++) {
            $versesArray[$i + 1] = $fullSura[$i];
        }

        return $versesArray;
    }

    public function calculateNumberOfVerses()
    {
        return sizeof($this->suraFile);
    }

    public function calculateNumberOfLetters()
    {
        $lettersCount = 0;
        $fullSura = $this->suraFile;

        for ($i = 0; $i < sizeof($fullSura); $i++) {
            $verse = explode(" ", $fullSura[$i]);
            
            for ($j = 0; $j < sizeof($verse); $j++) {
                $numberOfLetters = strlen($verse[$j]);
                //echo $verse[$j];echo '  '; echo ($numberOfLetters/2);echo '<br>';
                $lettersCount = $lettersCount + ($numberOfLetters / 2);
            }
        }
        return $lettersCount;
    }

    public function calculateNumberOfWords()
    {
        $wordsCount = 0;
        $fullSura = $this->suraFile;

        for ($i = 0; $i < sizeof($fullSura); $i++) {
            $verse = $fullSura[$i];
            $verse = explode(" ", $verse);
            $verseNumberOfWord = sizeof($verse);
            $wordsCount = $wordsCount + $verseNumberOfWord;
        }

        return $wordsCount;
    }
}
