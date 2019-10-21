<?php

namespace App\Http\Controllers;

use App\Service\CalculatorService;
use App\Counter;
use App\FullSura;
use App\Http\Controllers\Controller;
use App\Indexer;
use App\Verse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CalculatorController extends Controller
{
    private $request;
    private $fullSura;
    private $counter;

    public function __construct($fileName=null, Request $request=null)
    { 
        $this->counter = new Counter();
        $this->indexer = new Indexer();
        
        if ($request) {
            $fileName = $request->fileName;
        }
        if (!isset($fileName)) {
            throw new \Exception("Please input a Sura name");
        }
        // $suraFile = File::get(storage_path('sanatizedSuras' . '/' .$fileName));
        if (!isset($suraFile)) {
            throw new \Exception("Sura file not found");
        }
        // $this->fullSura = new FullSura($suraFile);
        // $this->fullSura->Name = $fileName;
        $this->service = new CalculatorService($this->fullSura);
           
    }

    public function mapSura()
    {   
        return $this->service->mapSura();
    }

    public function mapVerses()
    {
        return $this->service->mapVerses();
    }

}
