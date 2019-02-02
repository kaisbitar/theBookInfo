<?php

namespace App;

use App\Verse;

class Word extends Verse
{
    public $verse;
    public $verse_number;

    public function __construct($verse)
    {
        //when building the database consider passing ($sura_number, $verse_numbe, $word_number)as index for verse
        $this->verse = $verse;
    }

    public function indexTheWords()
    {
        $verse = $this->verse;
        $wordsIndex = array();

        $lettersArray = preg_split('//u', $verse, -1, PREG_SPLIT_NO_EMPTY);

        foreach ($lettersArray as $index => $letter) {
            $wordsIndex["Verse"] = $index + 1;
            $numberOfLetters = mb_strlen($lettersArray[$index]);
            $wordsIndex["lettersCount"] = $numberOfLetters;
            $wordsIndex["Word"] = $lettersArray[$index];
        }

        return $wordsIndex;

        // $verse = $this->verse; //var_dump($verse);
        // $verse_number = $this->verse_number;
        // $verseArray = array();
        // $wordsIndex = array();
        // $verseArray = explode(' ', $verse);
        // for ($i = 0; $i < sizeof($verseArray); $i++) {
        //     $wordsIndex["Verse"] = $i + 1;
        //     $numberOfLetters = mb_strlen($verseArray[$i]);
        //     $wordsIndex["lettersCount"] = $numberOfLetters;
        //     $wordsIndex["Word"] = $verseArray[$i];
        // }

        // return $wordsIndex;

    }

    public function breakToLetters($wordsIndex)
    {
        for ($i = 1; $i < sizeof($wordsIndex); $i++) {
            $word = $wordsIndex[$i];
            $letters = str_split($word);
        }
        return $letters[3];
    }
}
