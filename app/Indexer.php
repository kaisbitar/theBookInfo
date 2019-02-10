<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Indexer extends Model
{
    public function __construct()
    {
        return $this;
    }

    public function indexLettersInString($verseArray)
    {
        $oneWordVerse = implode("", $verseArray);
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
