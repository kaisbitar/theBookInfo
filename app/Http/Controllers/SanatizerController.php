<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;

class SanatizerController extends Controller
{

    public function __construct()
    {
        $this->rawHTMLFolderPath = storage_path('nonSanatizedSuras');
        $this->cleanedSurasPath = storage_path('SanatizedSuras');
        
    }

    public function sanatize()
    {
        $rawHTMLFiles = scandir($this->rawHTMLFolderPath);
        foreach ($rawHTMLFiles as $rawHTMLFile) {  
            if (($rawHTMLFile != '.')&&($rawHTMLFile != '..')) {
                $suraStringToClean = self::getSuraString($rawHTMLFile); 
                $readyToSaveSura = self::cleanSuraString($suraStringToClean);
                

                $fileNameToSave = substr($rawHTMLFile, 0, strpos($rawHTMLFile, "."));
                $fileNameToSave = $fileNameToSave.$readyToSaveSura["suraName"];
                self::saveSura($readyToSaveSura["theSura"], $fileNameToSave);
            }
        }
    }

    public function getSuraString($rawHTMLFile)
    {
        $notsanatizedSura = File::get($this->rawHTMLFolderPath.'/'.$rawHTMLFile);
        $suraStringToClean = iconv('WINDOWS-1256', 'UTF-8', $notsanatizedSura); 
        $suraStringToClean = (strip_tags($suraStringToClean));

        return $suraStringToClean;

    }

    public function cleanSuraString($suraStringToClean)
    {
        $SuraArrayToClean = explode(' ', $suraStringToClean);
        $tmpToClean= array();
        $cleanedSura= array();
        foreach($SuraArrayToClean as $key=>$ArrayElement) {
            $ArrayElement = str_replace("&nbsp;", "", $ArrayElement);
            $ArrayElement = str_replace("\n","",$ArrayElement); 
            $ArrayElement = str_replace(" ","",$ArrayElement); 

            $tmpToClean[$key] = $ArrayElement;
        }
        
        foreach ($tmpToClean as $key => $value) {
            if( ($tmpToClean[$key] == 'القرآن') && 
              ($tmpToClean[$key+1] == 'مكتوب')&&
              ($tmpToClean[$key+2] == 'بالرسم') &&
              ($tmpToClean[$key+3] == 'العثمانيسورة') ) 
              {
                $tmpToClean[$key] = '';
                $tmpToClean[$key+1] = '';
                $tmpToClean[$key+2] = '';
                $tmpToClean[$key+3] = '';
              }
            if ($tmpToClean[$key] == 'twentysex') {
                $tmpToClean[$key] = '26';
            }  
            if ((strpos($tmpToClean[$key], 'مكية)'))) {
                 $tmpToClean[$key] = str_replace('مكية', '', $tmpToClean[$key]);
            }
             else if ((strpos($tmpToClean[$key], 'مدنية)'))) {
                $tmpToClean[$key] = str_replace('مدنية', '', $tmpToClean[$key]);
            }                 
            if ($tmpToClean[$key] == 'رقم') {
                $tmpToClean[$key] = str_replace('رقم', '', $tmpToClean[$key]);
            }
            if ((strpos($tmpToClean[$key], '('))) {
                $tmpToClean[$key] = str_replace('(', ',', $tmpToClean[$key]);
                $tmpToClean[$key] = str_replace(')', '', $tmpToClean[$key]);
            }
            if ((strpos($tmpToClean[$key], ')'))) {
                $tmpToClean[$key] = str_replace(')', ',', $tmpToClean[$key]);
                $tmpToClean[$key] = str_replace('(', '', $tmpToClean[$key]);
            }
                        
        }

        $tmpToClean = array_diff($tmpToClean, array('')) + array_intersect($tmpToClean, array(''));
        $tmpToClean = array_values($tmpToClean);
        $suraName = $tmpToClean[0];
        $tmpToClean[0] = str_replace($suraName, '', $tmpToClean[0]);    
        
        $tmpToClean = implode(" ", $tmpToClean);    
        $cleanedSura = strstr($tmpToClean, 'انتهت', true); 
        
        $cleanedSura = str_replace('(', '', $cleanedSura); 
        $cleanedSura = str_replace(')', '', $cleanedSura); 
        $cleanedSura = str_replace(',', '', $cleanedSura); 
        $cleanedSura = preg_replace('/[0-9]+/', ',', $cleanedSura);
        $cleanedSura = str_replace(' , ', ',', $cleanedSura); 
        $cleanedSura = str_replace(' ,', ',', $cleanedSura);  
        $cleanedSura = str_replace(', ', ',', $cleanedSura); 
        $cleanedSura = str_replace('الاالذين', 'الا الذين', $cleanedSura); 
        $cleanedSura = str_replace('تحصوهاإن', 'تحصوها إن', $cleanedSura); 
        $cleanedSura = str_replace('ءا', 'ا', $cleanedSura); 
        $cleanedSura = mb_substr($cleanedSura, 0, -1);
        $cleanedSura = str_replace('عمران,', '', $cleanedSura); 
        $cleanedSura = ltrim($cleanedSura, ',');
        $cleanedSura = ltrim($cleanedSura, ' ');
        $cleanedSura = rtrim($cleanedSura, '  ');


        $readyToSaveString = $cleanedSura;
        echo($readyToSaveString);
        echo "<br><br><br>";
        if($suraName == "آل"){
             $suraName = "آل_عمران";
        }
       $readyToSaveSura["theSura"] = $readyToSaveString;
       $readyToSaveSura["suraName"] = $suraName;

      return $readyToSaveSura;
    }        

    public function saveSura($readyToSaveSura, $fileNameToSave)
    {
        $sanataizedDir = fopen($this->cleanedSurasPath.'\\'.$fileNameToSave, 'w');
        fwrite($sanataizedDir, $readyToSaveSura);
        fclose($sanataizedDir);
    }
    
    
    
}

?>