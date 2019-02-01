<?php

namespace App;

use App\FullSura;

class Verse extends FullSura
{
    public $verse;
    public $verse_number;
    
    public function __construct($verse, $verse_number)
    {
        $verse = explode(" ", $verse);
        $this->verse = $verse;
        $this->verse_number = $verse_number;
        //$verse
    }

    public function calculateVerseWords()
    {
        $verse = $this->verse;
        return sizeof($verse);
    }
    public function calculateVerseLetters()
    {
        $verse = $this->verse;
        $verse = implode("", $verse);
        $verseLetters = strlen($verse) / 2;
        return $verseLetters;
    }
}
