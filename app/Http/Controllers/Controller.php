<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\FullSura;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function jsonResponse($data, $code = 200)
    {
        return response()->json(
            $data,
            $code,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_UNESCAPED_UNICODE
        );
    }

    /**
     *
     * @param array|Collection      $items
     * @param int   $perPage
     * @param int  $page
     * @param array $options
     *
     * @return LengthAwarePaginator
     */
    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (\Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof \Illuminate\Support\Collection ? $items : \Illuminate\Support\Collection::make($items);

        return new \Illuminate\Pagination\LengthAwarePaginator(array_values($items->forPage($page, $perPage)->toArray()), $items->count(), $perPage, $page, $options);
    }

    public function listSuras(){
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
    public function runBackend(){
        $surasFiles = scandir(storage_path('SanatizedSuras'));
        foreach ($surasFiles as $suraFileName) {
            if (($suraFileName != '.')&&($suraFileName != '..')) {
                $fullSura = new CalculatorController($suraFileName);    
                $fullSura->mapSura();
                $fullSura->mapVerses();
            }
        }
        return;
    }
}
    