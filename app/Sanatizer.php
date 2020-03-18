<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;


class Sanatizer extends Model
{
    public $folderToSanatize;    

    public function __construct($folderToSanatize, $cleanedSurasPath)
    {
        $this->folderToSanatize = $folderToSanatize;
        $this->cleanedSurasPath = $cleanedSurasPath;
    }

    public function sanatize()
    {
        //clear the المصحف file before starting
        $sanatizedFiles = scandir($this->cleanedSurasPath);
        foreach ($sanatizedFiles as $sanatizedFile) {
            if($sanatizedFile == "المصحف"){
                unlink ($this->cleanedSurasPath.'/المصحف');
            }
        }
        $rawHTMLFiles = scandir($this->folderToSanatize);
        foreach ($rawHTMLFiles as $rawHTMLFile) {
            if (($rawHTMLFile != '.')&&($rawHTMLFile != '..')) {
                $suraStringToClean = self::getSuraString($rawHTMLFile);
                $readyToSaveSura = self::cleanSuraString($suraStringToClean);

                $suraNumber = substr($rawHTMLFile, 0, strpos($rawHTMLFile, "."));
                $fileNameToSave = $suraNumber.$readyToSaveSura["suraName"];
                self::saveAllSuras($readyToSaveSura["theSura"], $fileNameToSave, $suraNumber);
                self::saveIndividualSura($readyToSaveSura["theSura"], $fileNameToSave);
            }
        }
    } 
    public function getSuraString($rawHTMLFile)
    {
        $notsanatizedSura = File::get($this->folderToSanatize.'/'.$rawHTMLFile);
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
            $ArrayElement = str_replace("\r","",$ArrayElement); 
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
        $cleanedSura = str_replace('البحربما ينفع الناس', 'البحر بما ينفع الناس', $cleanedSura); 
        $cleanedSura = str_replace('قومامسرفين', 'قوما مسرفين', $cleanedSura); 
        $cleanedSura = str_replace('فوقهافاما', 'فوقها فاما', $cleanedSura);   
        $cleanedSura = str_replace('تحصوهاإن', 'تحصوها إن', $cleanedSura);  
        $cleanedSura = str_replace(' احى ', ' أحي ', $cleanedSura); 
        $cleanedSura = str_replace('واوليك', 'واولئك', $cleanedSura); 
        $cleanedSura = str_replace('لايخفىعليه', 'لايخفى عليه', $cleanedSura);  
        $cleanedSura = str_replace('تلبسونهاوترى', 'تلبسونها وترى', $cleanedSura); 
        $cleanedSura = str_replace(' شىء ', ' شئ ', $cleanedSura); 
        $cleanedSura = str_replace('بريء', 'برئ', $cleanedSura);  
        $cleanedSura = str_replace('الخبء', 'الخبئ', $cleanedSura);   
        $cleanedSura = str_replace(' قلبى ', ' قلبي ', $cleanedSura);    
        
        $cleanedSura = str_replace(' من ولى ', ' من ولي ', $cleanedSura);    
        $cleanedSura = str_replace(' وايى ', ' وايي ', $cleanedSura);    
        $cleanedSura = str_replace(' بعهدى ', ' بعهدي ', $cleanedSura);    
        $cleanedSura = str_replace(' بيتى ', ' بيتي ', $cleanedSura);    
        $cleanedSura = str_replace(' عهدى ', ' عهدي ', $cleanedSura);    
        $cleanedSura = str_replace(' ذريتى ', ' ذريتي ', $cleanedSura);    
        $cleanedSura = str_replace('انى جاعل', 'اني جاعل', $cleanedSura);    
        $cleanedSura = str_replace('انى اعلم', 'اني اعلم', $cleanedSura);    
        $cleanedSura = str_replace('انى فضلتكم', 'اني فضلتكم', $cleanedSura);    
        $cleanedSura = str_replace('الا امانى', 'الا اماني', $cleanedSura);    
        $cleanedSura = str_replace('وانى فضلتكم', 'واني فضلتكم', $cleanedSura);    
        $cleanedSura = str_replace('فانى قريب', 'فاني قريب', $cleanedSura);    
        $cleanedSura = str_replace('انى جاعلك', 'اني جاعلك', $cleanedSura);   
        $cleanedSura = str_replace('انى', 'اني', $cleanedSura); 
        $cleanedSura = str_replace('عبادى عنى', 'عبادي عني', $cleanedSura); 
        
        // لى 
        // بى 
        $cleanedSura = str_replace('مثليها قلتم اني هذا', 'مثليها قلتم انى هذا', $cleanedSura);   
        $cleanedSura = str_replace('اني يكون له ولد ولم', 'انى يكون له ولد ولم', $cleanedSura);   
        $cleanedSura = str_replace('اني يكون له الملك', 'انى يكون له الملك', $cleanedSura);   
        $cleanedSura = str_replace('يمريم اني لك هذا', 'يمريم انى لك هذا', $cleanedSura);   
        $cleanedSura = str_replace('اني يكون لي ولد', 'انى يكون لي ولد', $cleanedSura);   
        $cleanedSura = str_replace('حرثكم انى شيتم', 'حرثكم انى شيتم', $cleanedSura);   
        $cleanedSura = str_replace('قال رب اني يكون لي غلم', 'قال رب انى يكون لي غلم', $cleanedSura);   
        $cleanedSura = str_replace('فاني تؤفكون', 'فانى تؤفكون', $cleanedSura);   
        $cleanedSura = str_replace('اني تؤفكون', 'انى تؤفكون', $cleanedSura);    
        $cleanedSura = str_replace(' كفي ', ' كفى ', $cleanedSura);    
        $cleanedSura = str_replace(' وكفي ', ' وكفى ', $cleanedSura);    
         
        
         
        
              
        //important postion
        $cleanedSura = str_replace('سيء', 'سئ', $cleanedSura);   
        $cleanedSura = str_replace('فىابرهيم', 'في ابرهيم', $cleanedSura);   
        $cleanedSura = str_replace('العلى العظيم', 'العلي العظيم', $cleanedSura);   
        $cleanedSura = str_replace(' الحى ', ' الحي ', $cleanedSura);   
        $cleanedSura = str_replace(' الغى ', ' الغي ', $cleanedSura);   
        $cleanedSura = str_replace('الله ولى', 'الله ولي', $cleanedSura);   

        $cleanedSura = str_replace(' وقضى الامر ', ' وقضي الامر ', $cleanedSura);   
        $cleanedSura = str_replace(' بنى ', ' بني ', $cleanedSura);   
        $cleanedSura = str_replace(' عفى ', ' عفي ', $cleanedSura);   
        $cleanedSura = str_replace(' ياولى ', ' ياولي ', $cleanedSura);   
        $cleanedSura = str_replace(' بشىء ', ' بشي ', $cleanedSura);   
        $cleanedSura = str_replace(' لى ', ' لي ', $cleanedSura);   
        $cleanedSura = str_replace(' فى ', ' في ', $cleanedSura);   
        $cleanedSura = str_replace('دفء', 'دفئ', $cleanedSura);  
        $cleanedSura = str_replace(' وهى ', ' وهي ', $cleanedSura);         
        $cleanedSura = str_replace(' هى ', ' هي ', $cleanedSura);         
        $cleanedSura = str_replace('ءاتخذ', 'أاتخذ', $cleanedSura);         
        $cleanedSura = str_replace('ءآلله', 'آالله', $cleanedSura);         
        $cleanedSura = str_replace('ءالله', 'آالله', $cleanedSura);
        $cleanedSura = str_replace('ءأنت', 'أانت', $cleanedSura);   
        $cleanedSura = str_replace('ءأرباب', 'أارباب', $cleanedSura);   
        $cleanedSura = str_replace('ءأسجد', 'أاسجد', $cleanedSura);   
        $cleanedSura = str_replace('ءأشكر', 'أاشكر', $cleanedSura);       
        $cleanedSura = str_replace('ءانذرتهم', 'أانذرتهم', $cleanedSura);         
        $cleanedSura = str_replace('ء انذرتهم', 'أانذرتهم', $cleanedSura);         
        $cleanedSura = str_replace('ء ال يعقوب', 'آل يعقوب', $cleanedSura);         
        $cleanedSura = str_replace('وءاخرجني', 'واخرجني', $cleanedSura);         
        $cleanedSura = str_replace('وءاخرجنا', 'واخرجنا', $cleanedSura);         
        $cleanedSura = str_replace('ءاعجمي', 'أاعجمي', $cleanedSura);         
        $cleanedSura = str_replace('ءانتم', 'أانتم', $cleanedSura); 
        $cleanedSura = str_replace(',ءاشفقتم', ',ااشفقتم', $cleanedSura); 
        $cleanedSura = str_replace(',ءأمنتم', ',اامنتم', $cleanedSura);
        $cleanedSura = str_replace('ولقاىءالاخرة', 'ولقاء الاخرة', $cleanedSura); 
        $cleanedSura = str_replace('ولءامنينهمولامرنهم', 'ولامنينهم ولامرنهم', $cleanedSura);  //PHP can't find the sunstring, although it exist in the sting hmmmm 
        //important that this step comes after              
        //  
        $cleanedSura = str_replace(' ءا', ' ا', $cleanedSura);         
        $cleanedSura = str_replace(',وءا', ',وا', $cleanedSura);        
        $cleanedSura = str_replace(' وءا', ' وا', $cleanedSura);  
        $cleanedSura = str_replace(',ءا', ',ا', $cleanedSura);        
        $cleanedSura = str_replace('أ', 'ا', $cleanedSura);        
        $cleanedSura = str_replace('آ', 'ا', $cleanedSura);        
        $cleanedSura = str_replace('إ', 'ا', $cleanedSura);  
        
        //important position
        $cleanedSura = str_replace('ءا', 'ا', $cleanedSura); 

        //important postion
        $cleanedSura = str_replace(' را ', ' رءا ', $cleanedSura);
        $cleanedSura = str_replace(' واخيه ان تبوا ', ' واخيه ان تبوءا ', $cleanedSura);
        $cleanedSura = str_replace(' جزا ', ' جزءا ', $cleanedSura);
        $cleanedSura = str_replace(' ورا ', ' ورءا ', $cleanedSura);
        $cleanedSura = str_replace(' ترا ', ' ترءا ', $cleanedSura);
        $cleanedSura = str_replace(' سوا ', ' سوءا ', $cleanedSura);
        $cleanedSura = str_replace(' ردا ', ' ردءا ', $cleanedSura);

        $cleanedSura = str_replace('منهن جزا', ' منهن جزءا', $cleanedSura);   
        $cleanedSura = str_replace('له من عباده جزا', 'له من عباده جزءا', $cleanedSura);   
        $cleanedSura = str_replace('ارنى', 'ارني', $cleanedSura);  
        $cleanedSura = str_replace('ربى', 'ربي', $cleanedSura); 
        $cleanedSura = str_replace('ياتى', 'ياتي', $cleanedSura); 
        $cleanedSura = str_replace('تحى', 'تحي', $cleanedSura); 
        $cleanedSura = str_replace('شئ', 'شي', $cleanedSura); 
        $cleanedSura = str_replace('وتثبيتامن', 'وتثبيتا من', $cleanedSura); 
        $cleanedSura = str_replace('شيء', 'شي', $cleanedSura); 
        $cleanedSura = str_replace('الذى', 'الذي', $cleanedSura);  
        $cleanedSura = str_replace('ابرهيملابيه', 'ابرهيم لابيه', $cleanedSura);  
        $cleanedSura = str_replace('بلقاىءربهم', 'بلقاء ربهم', $cleanedSura); 
        $cleanedSura = str_replace('مصلىوعهدنا', 'مصلى وعهدنا', $cleanedSura);  
        $cleanedSura = str_replace('يحى', 'يحي', $cleanedSura);  
        $cleanedSura = str_replace('قال اني يحي هذه', 'قال انى يحي هذه', $cleanedSura);   
        $cleanedSura = str_replace('آناى', 'انائ', $cleanedSura);  
        $cleanedSura = str_replace('لايخفى', 'لا يخفى', $cleanedSura); 
        $cleanedSura = mb_substr($cleanedSura, 0, -1);
        $cleanedSura = str_replace('عمران,', '', $cleanedSura); 
        $cleanedSura = ltrim($cleanedSura, ',');
        $cleanedSura = ltrim($cleanedSura, ' ');
        $cleanedSura = rtrim($cleanedSura, '  ');
        $cleanedSura = (strip_tags($cleanedSura));

        substr_replace($cleanedSura, '.', -1, 0);

        $readyToSaveString = $cleanedSura;
        if($suraName == "آل"){
            $suraName = "آل_عمران";
       }
        echo $suraName;       
        // echo strlen($readyToSaveString);

        echo ":<br><br>";
        echo($readyToSaveString);
        echo "<br><br><br>";
        $readyToSaveSura["theSura"] = $readyToSaveString;
        $readyToSaveSura["suraName"] = $suraName;

      return $readyToSaveSura;
    }        

    public function saveIndividualSura($readyToSaveSura, $fileNameToSave)
    {
        $sanataizedDir = fopen($this->cleanedSurasPath.'/'.$fileNameToSave, 'w');
        fwrite($sanataizedDir, $readyToSaveSura);
        fclose($sanataizedDir);
    }
    public function saveAllSuras($readyToSaveSura, $fileNameToSave, $suraNumber)
    {
        $readyToSaveSura = $readyToSaveSura . ",";
        // dump($readyToSaveSura);
        $sanataizedDir = fopen($this->cleanedSurasPath.'/المصحف', 'a');
        fwrite($sanataizedDir, $readyToSaveSura);
        fclose($sanataizedDir);
    }
}

?>
