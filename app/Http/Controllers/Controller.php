<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

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
        $listOfSuras = [];
        $surasFiles = scandir(storage_path('SanatizedSuras'));
        $index = -1;
        foreach ($surasFiles as $suraFile) {
            if (($suraFile != '.')&&($suraFile != '..')) {
                $listOfSuras["fileName"] = $suraFile;
                $listOfSuras["suraIndex"] = preg_replace("/[^Z0-9]+/", "", $suraFile);                
                $listOfSuras["suraName"] = mb_substr($suraFile,3);     
                return $listOfSuras;           
            }
            $index+=1;
            
        }
        return json_encode($listOfSuras);
    }
}
    