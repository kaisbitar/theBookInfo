<?php

namespace App\Http\Controllers;

use App\Counter;
use App\FullSura;
use App\Http\Controllers\Controller;
use App\Verse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CalculatorController extends Controller
{
    private $request;
    private $fullSura;

    public function __construct(Request $request)
    {
        $fileName = $request->input('fileName');

        // $fileName = 'الفاتحة';

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

        return $this->jsonResponse($this->paginate($verses));
    }

    public function countLetters()
    {
        $counter = new Counter();
        $lettersCount = [];
        $lettersCount["sura_title"] = $this->fullSura->name;
        $lettersCount["occurrences"] = $counter->countLettersInString($this->fullSura->suraString);

        return $this->jsonResponse($lettersCount);
    }

    private function processVerses($verses)
    {
        $counter = new Counter();
        $returnArray = [];

        foreach ($verses as $index => $verse) {
            $verseObject = new Verse($verse, $index);

            $verseObject->verseText = $verseObject->verseString;
            $verseObject->verseNumber = $verseObject->verseIndex;
            $verseObject->verseText = $verseObject->verseString;
            $verseObject->WordsCount = sizeof($verseObject->verseArray);
            $verseObject->LettersCount = $verseObject->countVerseLetters();
            $verseObject->LettersScore = $counter->countLettersInString($verse);
            $verseObject->Words = $verseObject->indexVerseWords();
            $verses[$index] = $verseObject;
        }

        return $verses;
    }
}
