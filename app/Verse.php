<?php

namespace App;

use App\Word;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Verse extends Model
{
    public $verseString;
    public $verseArray;
    public $verseIndex;
    public $lettersCount = [];

    public function __construct($verse, $index)
    {
        $this->verseString = $verse;
        $this->verseArray = explode(" ", $verse);
        $this->verseIndex = $index + 1;

        return $this;
    }

    public function countVerseLetters()
    {
        $verseNoSpaces = implode("", $this->verseArray);
        $lettersCount = mb_strlen($verseNoSpaces);

        return $lettersCount;
    }

    public function indexVerseWords()
    {
        $verseWords = new Collection();

        foreach ($this->verseArray as $index => $word) {
            $wordObject = new Word($word, $index + 1);
            $wordObject->Index = $wordObject->index;
            $wordObject->Word = $wordObject->string;
            $wordObject->Letters = $wordObject->letters;

            $verseWords->push($wordObject);
        }

        return $verseWords;
    }

    public function indexLettersInString()
    {
        $oneWordVerse = implode("", $this->verseArray);
        $lettersArray = preg_split('//u', $oneWordVerse, -1, PREG_SPLIT_NO_EMPTY);
        $returnArray = [];

        foreach ($lettersArray as $index => $char) {
            if (!isset($returnArray[$char])) {
                $returnArray[$char] = [];
            }

            array_push($returnArray[$char], $index + 1);
        }

        return $returnArray;
    }
}
