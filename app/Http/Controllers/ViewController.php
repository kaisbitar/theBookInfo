<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function viewQuranMap(Request $request)
    {   
        $fileName = $request->fileName;
        $mappedSura = file_get_contents(storage_path('decoded_suras/المصحف_sura_results.json'));

        return ($mappedSura);
    }

    public function viewSuraMap(Request $request)
    {   
        $fileName = $request->fileName;
        $mappedSura = file_get_contents(storage_path('decoded_suras/' . $fileName . '_sura_results.json'));

        return ($mappedSura);
    }

    public function viewVersesMap(Request $request)
    {   
        $fileName = $request->fileName;
        $mappedSura = file_get_contents(storage_path('decoded_verses/' . $fileName . '_verses_results.json'));

        return ($mappedSura);
    }

    public function viewQuranIndex()
    {   
        $mappedSura = file_get_contents(storage_path('quranIndex'));

        return ($mappedSura);
    }
    
}
