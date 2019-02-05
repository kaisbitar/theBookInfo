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
        $file = 'الفاتحة';

        $suraFile = File::get(storage_path($file));
        if (!isset($suraFile)) {
            return response()->json(["error" => "Sura file not found"]);
        }

        $this->fullSura = new FullSura($suraFile);
        $this->fullSura->name =  $file;
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
        $this->fullSura->verses = $this->processVerses($this->fullSura->suraFile);
        //How can we show the Verse Index of each the verses
        return $this->jsonResponse($this->fullSura->verses);
    }

    public function mapWords()
    {
        $processedWords = array();
        $wordsContainer = array();
        $indexedWords = array();
        $wordObject = new \stdClass();

        for ($i = 0; $i < sizeof($verses); $i++) {
            $wordsArray = $verses[$i];
            for ($j = 0; $j < strlen($wordsArray); $j++) {
                $wordsString = explode(" ", $wordsArray);

                for ($z = 0; $z < sizeof($wordsString); $z++) {
                    $word = new Word($wordsString[$z]);
                    $wordsIndex = $word->indexTheWords();
                    $indexedWords[$z] = $wordsIndex;
                    $verseNumber = $i + 1;
                }

                $wordObject->$verseNumber = $indexedWords;
                $wordsContainer[$j] = $indexedWords;
            }

            $processedWords[$i] = $wordsContainer;
        }
        $this->fullSura->words = $processedWords;

        return $this->jsonResponse($this->fullSura);
    }
    private function processVerses($verses)
    {
        foreach ($verses as $index => $verse) {
            $verseObject = new Verse($verse, $index);
            $verseObject->verseNumber = $verseObject->verseIndex;
            $verseObject->WordsCount = sizeof($verseObject->verseArray);
            $verseObject->lettersCount = $verseObject->countVerseLetters();
            $verseObject->verseWords = $verseObject->indexVerseWords();
            $verses[$index] = $verseObject;
        }
        
        return $verses;
    }
}
