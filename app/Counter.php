<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Counter extends Model
{
    public function countLettersInString($inputString)
    {
        $lettersScore = new \stdClass();
        $alphabet = File::get(storage_path('الابجدية'));

        if (!isset($alphabet)) {
            return response()->json(["error" => "Alphabet file not found"]);
        }

        $alphabetArray = explode(" ", $alphabet);
        foreach ($alphabetArray as $letter) {
            if (!empty(substr_count($inputString, $letter))) {
                $lettersScore->$letter = substr_count($inputString, $letter);
            }
        }

        return $lettersScore;
    }
}
