<?php

namespace App;

use App\FullSura;

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
}
