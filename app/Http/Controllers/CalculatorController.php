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
    private $counter;

    public function __construct(Request $request)
    {
        $this->counter = new Counter();

        $fileName = $request->input('fileName');

        if (!isset($fileName)) {
            throw new \Exception("Please input a Sura name");
        }

        $suraFile = File::get(storage_path($fileName));

        if (!isset($suraFile)) {
            throw new \Exception("Sura file not found");
        }

        $this->fullSura = new FullSura($suraFile);
        $this->fullSura->name = $fileName;
    }

    public function mapSura()
    {
        $this->fullSura->numberOfVerses = $this->fullSura->calculateNumberOfVerses();
        $this->fullSura->numberOfWords = $this->fullSura->calculateNumberOfWords();
        $this->fullSura->numberOfLetters = $this->fullSura->calculateNumberOfLetters();
        $this->fullSura->wordOccurrences = $this->counter->countWordsInString($this->fullSura->suraString);
        $this->fullSura->VerseIndex = $this->fullSura->breakToVerses();

        $resultFileName = $this->fullSura->name . ' sura results';
        file_put_contents(storage_path($resultFileName), json_encode($this->fullSura->toArray(), JSON_UNESCAPED_UNICODE));

        return $this->jsonResponse($this->fullSura);
    }

    public function mapVerses()
    {
        $verses = $this->processVerses($this->fullSura->verses);
        $resultFileName =$this->fullSura->name . ' verses results';
        file_put_contents(storage_path($resultFileName), json_encode($verses, JSON_UNESCAPED_UNICODE));

        return $this->jsonResponse($verses);
    }

    public function countLetters()
    {
        $lettersCount = [];
        $lettersCount["sura_title"] = $this->fullSura->name;
        $lettersCount["occurrences"] = $counter->countLettersInString($this->fullSura->suraString);

        return $this->jsonResponse($lettersCount);
    }

    private function processVerses($verses)
    {
        $returnArray = [];

        foreach ($verses as $index => $verse) {
            $verseObject = new Verse($verse, $index);

            $verseObject->verseText = $verseObject->verseString;
            $verseObject->verseNumber = $verseObject->verseIndex;
            $verseObject->verseText = $verseObject->verseString;
            $verseObject->WordsCount = sizeof($verseObject->verseArray);
            $verseObject->LettersCount = $verseObject->countVerseLetters();
            $verseObject->LettersScore = $this->counter->countLettersInString($verse);
            $verseObject->IndexWords = $verseObject->indexVerseWords();
            $verseObject->WordsOccurrences = $this->counter->countWordsInString($verse);
            $verses[$index] = $verseObject;
        }

        return $verses;
    }
}
