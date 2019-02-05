<?php

namespace App;

use App\FullSura;
use App\Word;

class Verse extends FullSura
{
    public $verseString;
    public $verseArray;
    public $verseIndex;

    public function __construct($verse, $index)
    {
        $this->verseString = $verse;
        $this->verseArray = explode(" ", $verse);
        $this->verseIndex = $index + 1;
    }

    public function countVerseLetters()
    {
        $verseNoSpaces = implode("", $this->verseArray);
        $lettersCount = mb_strlen($verseNoSpaces);

        return $lettersCount;
    }

    public function indexVerseWords()
    {
        $verseWords = [];

        foreach ($this->verseArray as $index => $word) {
            $wordObject = new Word($word, $index + 1);
            $wordObject->Index = $wordObject->index;
            $wordObject->Word = $wordObject->string;
            $wordObject->Letters = $wordObject->letters;
            
            $verseWords[$word] = $wordObject;
        }

        return $verseWords;
    }
}
