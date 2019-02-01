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

        $suraFile = File::get(storage_path('الفاتحة'));
        if (!isset($suraFile)) {
            return response()->json(["error" => "Sura file not found"]);
        }

        $this->fullSura = new FullSura($suraFile);
        $this->fullSura->name = $file;
    }

    public function get()
    {
        $this->fullSura->verses = $this->processVerses($this->fullSura->suraFile);
        $this->fullSura->words = $this->processVerseWords($this->fullSura->suraFile);

        // dd($this->fullSura->toArray());

        foreach ($this->fullSura as $row) {
            if (!mb_check_encoding($row, 'UTF-8')) {
                return response()->json(["error" => "File is malformed"]);
            }
        }
        // dd($this->fullSura->verses);
        return $this->jsonResponse($this->fullSura);
    }

    private function processVerseWords($verses)
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

        return $processedWords;
    }

    private function processVerses($verses)
    {
        $verseObject = new \stdClass();

        for ($i = 0; $i < sizeof($verses); $i++) {
            $verse = new Verse($verses[$i], $i);
            $verseJSON = new \stdClass();
            $wordsJSON = new \stdClass();
            $verseIndex = $i + 1;
            $verseJSON = $this->prepareVerseJSON($verse, $verseIndex);
            $verseObject->$verseIndex = $verseJSON;
        }

        return $verseObject;
    }

    private function prepareVerseJSON($verse, $i)
    {
        $verseNumberOfWords = $verse->calculateVerseWords();
        $verseNumberOfLetters = $verse->calculateVerseLetters();
        $verseJSON = new \stdClass();
        $verseJSON->TheVerse = implode(" ", $verse->verse);
        $verseJSON->WordsCount = $verseNumberOfWords;
        $verseJSON->lettersCount = $verseNumberOfLetters;

        return $verseJSON;
    }
}
