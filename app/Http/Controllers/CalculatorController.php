<?php

namespace App\Http\Controllers;

use App\FullSura;
use App\Http\Controllers\Controller;
use App\Verse;
use App\Word;
use Illuminate\Support\Facades\File;

class CalculatorController extends Controller
{
    private $request;
    private $fullSura;

    public function __construct()
    {
        $file = 'البقرة';

        $suraFile = File::get(storage_path($file));
        if (!isset($suraFile)) {
            return response()->json(["error" => "Sura file not found"]);
        }

        $this->fullSura = new FullSura($suraFile);
        $this->fullSura->name = $file;
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
        $verses = $this->processVerses($this->fullSura->suraFile);

        return $this->jsonResponse($this->paginate($verses));
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
