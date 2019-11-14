<?php

namespace App\Http\Controllers;

use App\Services\CollecterService;
use App\Counter;
use App\FullSura;
use App\Http\Controllers\Controller;
use App\Indexer;
use App\Verse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CollecterController extends Controller
{
    private $service;

    public function __construct(Request $request=null)
    { 
        if(isset($request)){
            $this->request = $request;
        }
        $this->service = new CollecterService();
    }
    
    public function countLetters()
    {   
        return $this->service->countLetters($this->request->suraIndex);
    }    
    
    public function calculateSura19()
    {   
        return $this->service->calculateSura19($this->request->suraName);
    }
}
