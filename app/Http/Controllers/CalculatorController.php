<?php

namespace App\Http\Controllers;

use App\FullSura;
use App\Http\Controllers\Controller;
use App\Verse;
use Illuminate\Support\Facades\File;

class CalculatorController extends Controller
{
    private $request;
    private $fullSura;

    public function __construct()
    {
        $fileName = 'البقرة';

        $suraFile = File::get(storage_path($fileName));
        if (!isset($suraFile)) {
            return response()->json(["error" => "Sura file not found"]);
        }

        $this->fullSura = new FullSura($suraFile);
        $this->fullSura->name = $fileName;
    }

    public function mapSura()
    {
        $this->fullSura->numberOfVerses = $this->fullSura->calculateNumberOfVerses();
        $this->fullSura->numberOfWords = $this->fullSura->calculateNumberOfWords();
        $this->fullSura->numberOfLetters = $this->fullSura->calculateNumberOfLetters();
        $this->fullSura->VerseIndex = $this->fullSura->breakToVerses();

        return $this->jsonResponse($this->fullSura);
    }

    public function mapVerses()
    {
        $verses = $this->processVerses($this->fullSura->verses);
        return $this->jsonResponse($verses);
    }

    public function scoreLetters()
    {
        $lettersScore = [];
        $lettersScore["sura_title"] = $this->fullSura->name;

        $alphabet = File::get(storage_path('الابجدية'));
        if (!isset($alphabet)) {
            return response()->json(["error" => "Alphabet file not found"]);
        }

        $alphabetArray = explode(" ", $alphabet);
        foreach ($alphabetArray as $letter) {
            $lettersScore[$letter] = substr_count($this->fullSura->suraString, $letter);
        }

        return $this->jsonResponse($lettersScore);
    }

    private function processVerses($verses)
    {
        foreach ($verses as $index => $verse) {
            $verseObject = new Verse($verse, $index);
            $verseObject->verseNumber = $verseObject->verseIndex;
            $verseObject->WordsCount = sizeof($verseObject->verseArray);
            $verseObject->lettersCount = $verseObject->countVerseLetters();
            $verseObject->words = $verseObject->indexVerseWords();
            $verses[$index] = $verseObject;
        }

        return $verses;
    }
}
