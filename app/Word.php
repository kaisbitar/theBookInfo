<?php

namespace App;

use App\Verse;

class Word extends Verse
{
    public $word;
    public $verse_number;

    public function __construct($word)
    {
        //when building the database consider passing ($sura_number, $verse_numbe, $word_number)as index for verse
        $this->word = $word;
    }

    public function indexTheWords()
    {
        $word = $this->word;
        $wordCount = array();

        $lettersArray = preg_split('//u', $word, -1, PREG_SPLIT_NO_EMPTY);
        
        foreach ($lettersArray as $index => $letter) {
            $wordCount[$index + 1] = $letter;
        }

        return $wordCount;
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
