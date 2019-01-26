<?php

namespace App;

class FullSura
{
    public $fullSura;
    public $sura_number;

    public function __construct($fullSura)
    {
        $fullSura = explode(",", $fullSura);
        $this->fullSura = $fullSura;
    }

    public function breakToVerses()
    {
        $fullSura = $this->fullSura;

        for ($i = 0; $i < sizeof($fullSura); $i++) {
            $verseIndex = $i + 1;
            //$verse[]= [$verseIndex=>$fullSura[$i]];
            $verse[($verseIndex)] = $fullSura[$i];
        }

        return $verse;
    }

    public function calculateNumberOfVerses()
    {
        $fullSura = $this->fullSura;
        return sizeof($fullSura);
    }

    public function calculateNumberOfLetters()
    {
        $lettersCount = 0;
        $fullSura = $this->fullSura;

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
        $fullSura = $this->fullSura;

        for ($i = 0; $i < sizeof($fullSura); $i++) {
            $verse = $fullSura[$i];
            $verse = explode(" ", $verse);
            $verseNumberOfWord = sizeof($verse);
            $wordsCount = $wordsCount + $verseNumberOfWord;
        }

        return $wordsCount;
    }
}
