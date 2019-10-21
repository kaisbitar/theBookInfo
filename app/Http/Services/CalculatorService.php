<?php

namespace App\Service;

use App\Counter;
use App\FullSura;
use App\Indexer;
use App\Verse;
use Illuminate\Support\Facades\File;



class CalculatorService{
    private $request;
    private $counter;
    private $fullSura;

    public function __construct($fullSura){
        $this->counter = new Counter();
        $this->indexer = new Indexer();
        $this->fullSura = $fullSura;
    }

    public function mapSura()
    {   
        $resultFileName = $this->fullSura->Name . '_sura_results.json';
        if (!file_exists(storage_path('decoded_suras/' . $resultFileName))) {
            $this->fullSura->NumberOfVerses = $this->fullSura->calculateNumberOfVerses();
            $this->fullSura->NumberOfWords = $this->fullSura->calculateNumberOfWords();
            $this->fullSura->NumberOfLetters = $this->fullSura->calculateNumberOfLetters();

            $this->fullSura->WordOccurrences = $this->counter->countWordsInString($this->fullSura->suraString);
            $this->fullSura->WordIndex = $this->indexer->indexWordsInString($this->fullSura->suraString);

            $this->fullSura->LetterOccurrences = $this->counter->countLettersInString($this->fullSura->suraString);
            $this->fullSura->LetterIndexes = $this->indexer->indexLettersInString($this->fullSura->verses);

            $verses = $this->processVerses($this->fullSura->verses);
            $verses["SuraLettersCount"] = $this->counter->countLettersInString($this->fullSura->suraString);
            
            $this->fullSura->VersesScore = $verses;
            
            file_put_contents(storage_path('decoded_suras/' . $resultFileName), json_encode($this->fullSura, JSON_UNESCAPED_UNICODE));
        }
        $mappedSura = file_get_contents(storage_path('decoded_suras/' . $this->fullSura->Name . '_sura_results.json'));

        return $mappedSura;
    }

    public function mapVerses()
    {
        $resultFileName = $this->fullSura->Name . '_verses_results.json';
        if (!file_exists(storage_path('decoded_verses/' . $resultFileName))) {
            $verses = $this->processVerses($this->fullSura->verses);
            $verses["SuraLettersCount"] = $this->counter->countLettersInString($this->fullSura->suraString);
            $resultFileName = $this->fullSura->Name . '_verses_results.json';
            file_put_contents(storage_path('decoded_verses/'. $resultFileName), json_encode($verses, JSON_UNESCAPED_UNICODE));
        }
        $mappedSura = file_get_contents(storage_path('decoded_verses/' . $this->fullSura->Name . '_verses_results.json'));

        return $mappedSura;
    }

    private function processVerses($verses)
    {
        $returnArray = [];

        foreach ($verses as $index => $verse) {
            $verseObject = new Verse($verse, $index);

            $verseObject->verseText = $verseObject->verseString;
            $verseObject->verseText = $verseObject->verseString;

            $verseObject->NumberOfWords = sizeof($verseObject->verseArray);
            $verseObject->NumberOfLetters = $verseObject->countVerseLetters();

            $verseObject->LetterOccurrences = $this->counter->countLettersInString($verse);
            $verseObject->LetterIndexes = $this->indexer->indexLettersInString($verseObject->verseArray);

            $verseObject->WordOccurrences = $this->counter->countWordsInString($verse);
            $verseObject->WordIndexes = $this->indexer->indexWordsInString($verse);

            $returnArray[$index + 1] = $verseObject;
        }

        return $returnArray;
    }
}