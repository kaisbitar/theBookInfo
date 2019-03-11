<?php

namespace App\Http\Controllers;

use App\Sanatizer;
use Illuminate\Support\Facades\File;

class SanatizerController extends Controller
{
    public $rawHTMLFolderPath;
    public $cleanedSurasPath;

    public function __construct()
    {
        $this->rawHTMLFolderPath = storage_path('nonSanatizedSuras');
        $this->cleanedSurasPath = storage_path('SanatizedSuras');
    }

    public function runSanatization()
    {
        $sanatizer = new Sanatizer($this->rawHTMLFolderPath, $this->cleanedSurasPath);
        $sanatizer->sanatize();
    }
}
