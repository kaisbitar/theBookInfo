<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;

class SanatizerController extends Controller
{
    private $dir = 'suras';


    public function __construct()
    {
        $dir = storage_path().'\suras';

        $files = scandir($dir);

        foreach ($files as $fileName) {
            if (!$fileName != '.') {
                $suraFile = File::get(storage_path('suras/'.$fileName));
            }
            

        }
        
        dd($suraFile);
    }

    public function sanatize()
    {

    }
    
}

?>