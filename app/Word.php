<?php

namespace App;

use App\Verse;

class Word extends Verse
{
    public $letters = [];
    public $string;
    public $index;

    public function __construct($word, $index)
    {
        $this->string = $word;
        $this->index = $index;

        $lettersArray = preg_split('//u', $word, -1, PREG_SPLIT_NO_EMPTY);

        foreach ($lettersArray as $letterIndex => $letter) {
            $letterObject = new Letter($letter, $letterIndex + 1);
            $letterObject->Char = $letterObject->char;
            $letterObject->Index = $letterObject->index;

            $this->letters[] = $letterObject;
        }

        return $this;
    }
}
