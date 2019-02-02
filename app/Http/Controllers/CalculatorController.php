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
       // dd($suraFile);
        if (!isset($suraFile)) {
            return response()->json(["error" => "Sura file not found"]);
        }

        $this->fullSura = new FullSura($suraFile);
        $this->fullSura->name = $file;
    }

    public function get()
    {
        $this->fullSura->numberOfVerses = $this->fullSura->calculateNumberOfVerses();
        $this->fullSura->numberOfWords = $this->fullSura->calculateNumberOfWords();
        $this->fullSura->numberOfLetters = $this->fullSura->calculateNumberOfLetters();
        $this->fullSura->VerseIndex = $this->fullSura->breakToVerses();

        $this->fullSura->verses = $this->processVerses($this->fullSura->suraFile);
        $this->fullSura->words = $this->processVerseWords($this->fullSura->suraFile);

        // dd($this->fullSura->toArray());

        foreach ($this->fullSura as $row) {
            // if (!mb_check_encoding($row, 'UTF-8')) {
            //     return response()->json(["error" => "File is malformed"]);
            // }
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
        foreach($verses as $index => $verse){        
            $verseObject = new Verse($verse, $index);
            $verseObject->WordsCount = sizeof($verseObject->verseArray);
            $verseObject->lettersCount = $verseObject->countVerseLetters();
        }

        return $verses;
    }

}
