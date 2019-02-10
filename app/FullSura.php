<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FullSura extends Model
{
    public $verses;
    public $suraString;

    public function __construct($file)
    {
        $this->verses =  explode(",", $file);
        $this->suraString = $file;

        return $this;
    }

    public function breakToVerses()
    {
        $fullSura = $this->verses;

        for ($i = 0; $i < sizeof($fullSura); $i++) {
            $versesArray[$i + 1] = $fullSura[$i];
        }

        return $versesArray;
    }

    public function calculateNumberOfVerses()
    {
        return sizeof($this->verses);
    }

    public function calculateNumberOfLetters()
    {
        $lettersCount = 0;
        $fullSura = $this->verses;

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
        $fullSura = $this->verses;

        for ($i = 0; $i < sizeof($fullSura); $i++) {
            $verse = $fullSura[$i];
            $verse = explode(" ", $verse);
            $verseNumberOfWord = sizeof($verse);
            $wordsCount = $wordsCount + $verseNumberOfWord;
        }

        return $wordsCount;
    }
}
