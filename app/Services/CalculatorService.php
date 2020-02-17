<?php

namespace App\Services;

use App\Counter;
use App\FullSura;
use App\Indexer;
use App\Verse;
use Illuminate\Support\Facades\File;
use App\Controllers\CalculatorController;


class CalculatorService
{
    private $request;
    private $counter;
    private $fullSura;

    public function __construct($suraFile = null, $fileName = null)
    {   
        $this->counter = new Counter();
        $this->indexer = new Indexer();
        if($fileName == "quran-index"){
            return;
        }
        elseif($fileName == "decode-all"){
            return;
        }
        else{
            $this->fullSura = new FullSura($suraFile);
            $this->fullSura->Name = $fileName; 
        }      
    }

    public function mapSura()
    {   
        $resultFileName = $this->fullSura->Name . '_sura_results.json';
        // if (!file_exists(storage_path('decoded_suras/' . $resultFileName))) {
            
            $this->fullSura->NumberOfWords = $this->fullSura->calculateNumberOfWords();
            $this->fullSura->NumberOfLetters = $this->fullSura->calculateNumberOfLetters();
            $this->fullSura->WordOccurrences = $this->counter->countWordsInString($this->fullSura->suraString);
            // dd($this->fullSura->WordOccurrences);

            $this->fullSura->WordIndex = $this->indexer->indexWordsInString($this->fullSura->suraString);

            $this->fullSura->LetterOccurrences = $this->counter->countLettersInString($this->fullSura->suraString);
            $this->fullSura->LetterIndexes = $this->indexer->indexLettersInString($this->fullSura->verses);
            $verses = $this->processVerses($this->fullSura->verses);
            $verses["SuraLettersCount"] = $this->counter->countLettersInString($this->fullSura->suraString);
            
            $this->fullSura->VersesScore = $verses;
            
            file_put_contents(storage_path('decoded_suras/' . $resultFileName), json_encode($this->fullSura, JSON_UNESCAPED_UNICODE));
        // }
        $mappedSura = file_get_contents(storage_path('decoded_suras/' . $this->fullSura->Name . '_sura_results.json'));

        return $mappedSura;
    }

    public function mapLetters()
    {
        // dd($this->counter->countLettersInString($this->fullSura->suraString));
        $this->fullSura->NumberOfLetters = $this->fullSura->calculateNumberOfLetters();

        // $this->fullSura->LetterCount = $this->counter->countLettersInString($this->fullSura->suraString);
        // $this->fullSura->LettersIndexes = $this->indexer->indexLettersInString($this->fullSura->verses);
        
        return json_encode($this->fullSura) ;
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

    public function listSuras()
    {
        //if quranIndex file doesn't exist create one and read from it 
        if(!file_exists(storage_path('quranIndex'))){
            $listOfSuras = [];
            $surasFiles = scandir(storage_path('SanatizedSuras'));
            $suraIndex = 0;
            foreach ($surasFiles as $suraFile) {
                if (($suraFile != '.')&&($suraFile != '..')) {
                    $suraInfo["fileName"] = $suraFile;
                    $suraInfo["suraName"] = mb_substr($suraFile, 3);
                    $suraIndex = preg_replace("/[^Z0-9]+/", "", $suraFile);
                    $suraInfo["suraIndex"] =  $suraIndex;
                    $listOfSuras[$suraIndex] = $suraInfo;
                }
            }
            $listOfSuras = array_values($listOfSuras);
            $resultFileName =  'quranIndex';
            file_put_contents(
                storage_path($resultFileName),
                json_encode($listOfSuras, JSON_UNESCAPED_UNICODE)
            );
        }

        return file_get_contents(storage_path('quranIndex')) ;
    } 

    // Run all the backend to create mapped suras and verses
    public function runBackend()
    {
        $surasFiles = scandir(storage_path('SanatizedSuras'));
        foreach ($surasFiles as $suraFileName) {
            if (($suraFileName != '.')&&($suraFileName != '..')) {
                $suraFile = File::get(storage_path('sanatizedSuras' . '/' .$suraFileName));
                
                $this->fullSura = new FullSura($suraFile);
                $this->fullSura->Name = $suraFileName;
                $this->mapSura();
                $this->mapVerses();
            }
        }
        return;
    }
}