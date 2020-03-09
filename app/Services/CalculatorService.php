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
        if (!file_exists(storage_path('decoded_suras/' . $resultFileName))) {
            
            $this->fullSura->NumberOfWords = $this->fullSura->calculateNumberOfWords();
            $this->fullSura->NumberOfLetters = $this->fullSura->calculateNumberOfLetters();
            $verses = $this->processVerses($this->fullSura->verses);
            $this->fullSura->SuraLettersCount = $this->counter->countLettersInString($this->fullSura->suraString);

            $this->fullSura->versesMap = $verses;

            $this->fullSura->WordOccurrences = $this->counter->countWordsInString($this->fullSura->suraString);
            $this->fullSura->WordIndex = $this->indexer->indexWordsInString($this->fullSura->suraString);
            $this->fullSura->LetterOccurrences = $this->counter->countLettersInString($this->fullSura->suraString);
            $this->fullSura->LetterIndexes = $this->indexer->indexLettersInString($this->fullSura->verses);
            
            
            file_put_contents(storage_path('decoded_suras/' . $resultFileName), json_encode($this->fullSura, JSON_UNESCAPED_UNICODE));
        }
        $mappedSura = file_get_contents(storage_path('decoded_suras/' . $this->fullSura->Name . '_sura_results.json'));

        return $mappedSura;
    }

    public function mapLetters()
    {
        $this->fullSura->LetterCount = $this->counter->countLettersInString($this->fullSura->suraString);
        $verses = $this->processVerses($this->fullSura->verses);

        return $verses;
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

            // $suraName = preg_replace("/[0-9]/", "", $this->fullSura->Name);
            $suraName = $this->fullSura->Name;
            $verseObject->Sura = $suraName;
            $verseObject->index = $index+1;

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
            $surasFiles = scandir(storage_path('decoded_suras'));
            $suraIndex = 0;
            $allSuras = [];
            $i=1;
            foreach ($surasFiles as $suraFile) {
                if (($suraFile != '.')&&($suraFile != '..')&&($suraFile != 'المصحف_sura_results.json')) {
                    if (!file_exists(storage_path($suraFile.'_verses_results.json'))) {
                        $mappedSura = file_get_contents(storage_path('decoded_suras\\' . $suraFile), true);
                        $mappedSura = json_decode($mappedSura, true);
                        $indexInfo["fileName"] = $mappedSura["Name"];
                        $indexInfo["Name"] = mb_substr($indexInfo["fileName"], 3);      
                        $indexInfo["suraIndex"] = $i;              
                        // dd(count($mappedSura["versesMap"])-1);
                        $indexInfo["numberOfVerses"] = count($mappedSura["versesMap"])-1;
                        $indexInfo["NumberOfWords"] = $mappedSura["NumberOfWords"];
                        $indexInfo["NumberOfLetters"] = $mappedSura["NumberOfLetters"];
                        array_push($allSuras, $indexInfo);
                    }  
                 $i++;
                }
            }                
            file_put_contents(
                storage_path('quranIndex'),
                json_encode($allSuras, JSON_UNESCAPED_UNICODE)
            );
        }

        return file_get_contents(storage_path('quranIndex')) ;
    } 

    // Run all the backend to create mapped suras and verses
    public function runBackend()
    {
        $surasFiles = scandir(storage_path('SanatizedSuras'));
        foreach ($surasFiles as $suraFileName) {
            if (($suraFileName != '.')&&($suraFileName != '..')&&($suraFileName != 'المصحف')) {
                $suraFile = File::get(storage_path('sanatizedSuras' . '/' .$suraFileName));
                
                $this->fullSura = new FullSura($suraFile);
                $this->fullSura->Name = $suraFileName;
                $this->mapSura();
                $this->mapVerses();
                $this->mapComplete();
            }
        }
        return;
    }

    public function mapComplete(){
        $allSurasFiles = scandir(storage_path('decoded_suras'));
        $mappedQuran = [];
        $index = 1;
        if(!file_exists(storage_path('decoded_suras/'.'المصحف'.'_sura_results.json'))){
            foreach ($allSurasFiles as $suraFile) {
                if (($suraFile != '.')&&($suraFile != '..')) {
                    $suraInfo = File::get(storage_path('decoded_suras/'.$suraFile));
                    $suraInfo = json_decode($suraInfo);
                    foreach($suraInfo->versesMap as $verseInfo){
                        $mappedQuran[$index] = $verseInfo;
                        $index++;
                    }
                }                   
            }
            file_put_contents(
                storage_path('decoded_suras/'.'المصحف'.'_sura_results.json'),
                json_encode($mappedQuran, JSON_UNESCAPED_UNICODE)
            );
        }
        $mappedQuran = file_get_contents(storage_path('decoded_suras/'.'المصحف'.'_sura_results.json'));
        
        return $mappedQuran;
    }
}