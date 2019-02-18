<?php

namespace App\Http\Controllers;

use App\Counter;
use App\Indexer;
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
        $this->indexer = new Indexer();

        $fileName = $request->input('fileName');

        if (!isset($fileName)) { 
            throw new \Exception("Please input a Sura name");
        }

        $suraFile = File::get(storage_path('sanatizedSuras/'.$fileName));

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
        $this->fullSura->wordIndex = $this->indexer->indexWordsInString($this->fullSura->suraString);
        
        $this->fullSura->letterOccurrences = $this->counter->countLettersInString($this->fullSura->suraString);
        $this->fullSura->LettersMapIndexes = $this->indexer->indexLettersInString($this->fullSura->verses);


        $this->fullSura->VerseIndex = $this->fullSura->breakToVerses();

        $resultFileName = $this->fullSura->name . ' sura results';

        file_put_contents(
            storage_path('decoded_suras/'. $resultFileName),
            json_encode($this->fullSura->toArray(), JSON_UNESCAPED_UNICODE)
        );

        return $this->jsonResponse($this->fullSura);
    }

    public function mapVerses()
    {
        $verses = $this->processVerses($this->fullSura->verses);
        $verses["SuraLettersCount"] = $this->counter->countLettersInString($this->fullSura->suraString);

        $resultFileName = $this->fullSura->name . ' verses results';
        file_put_contents(storage_path('decoded_verses/'. $resultFileName), json_encode($verses, JSON_UNESCAPED_UNICODE));

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
            
            $verseObject->TotalNumOfWords = sizeof($verseObject->verseArray);
            $verseObject->TotalNumOfLetters = $verseObject->countVerseLetters();
            
            $verseObject->LettersOccurrences = $this->counter->countLettersInString($verse);
            $verseObject->LettersIndexes = $this->indexer->indexLettersInString($verseObject->verseArray);
            
            $verseObject->WordsOccurrences = $this->counter->countWordsInString($verse);
            $verseObject->wordIndex = $this->indexer->indexWordsInString($verse);

            $returnArray[$index] = $verseObject;
        }

        return $returnArray;
    }
}
