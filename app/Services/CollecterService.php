<?php

namespace App\Services;


class CollecterService
{    
    public function calculateSura19($suraName){
        $file = storage_path() . "/scored_verses" . '/' . $suraName . '_verses_score.json' ;
        $scoredVerses = json_decode(file_get_contents($file), true);
        ksort($scoredVerses);
        $scoredVerses = collect($scoredVerses);
        $mainScoredVerses = collect($scoredVerses);
        $this->totalSocre=0;
        $this->divdingScore=0;
        $this->calculatedVerses = [];
        $this->mainVerseCalculatedVerses = [];
        $this->mainIndex = 1;
        for($this->mainIndex;$this->mainIndex < count($mainScoredVerses);$this->mainIndex++){
            // dump($scoredVerses);
            $scoredVerses->each(function($verse, $verseIndex){
                
                $this->totalSocre = $this->totalSocre + $verse["score"];
                $this->divdingScore = $this->totalSocre/19;
                // $this->calculatedVerses[$verseIndex]["verse"] = $verse["verse"];
                //     $this->calculatedVerses[$verseIndex]["score"] = $verse["score"];
                if (!is_float($this->divdingScore)) {
                    $result["score"] = $this->totalSocre;
                    $result["division"] = $this->divdingScore;
                    $this->calculatedVerses["Results"] = $result;
                    $this->calculatedChunk = collect($this->calculatedVerses);
                    // dump(($this->calculatedChunk));
                    // dump($this->calculatedChunk);
                    $this->mainVerseCalculatedVerses[$verseIndex] = $this->calculatedChunk;
                    return $this->calculatedChunk;
                }
                
            
            
            });
            $scoredVerses->forget($this->mainIndex);
        }            dd($this->mainVerseCalculatedVerses);

        // dump($mainVerseCalculatedVerses);
    }

    public function countLetters($suraIndex)
    {
        $allDecodedSuras = [];
        $fileNames = scandir(storage_path('sanatizedSuras'));
        foreach ($fileNames as $index=> $fileName) {
            if (($fileName != '.')&&($fileName != '..')) {
                $file = storage_path() . "/decoded_suras" . '/' .$fileName. '_sura_results.json';
                $decodedSura = json_decode(file_get_contents($file), true);
                $allDecodedSuras[$index-1] = $decodedSura;
            }
        }
        if($suraIndex !== 'all'){
            $allDecodedSuras = $allDecodedSuras[$suraIndex];
        }
        if ((file_exists(storage_path('theBookLettersCount')))) {
            $allCounts = [];
            $alef=0;
            $alefM=0;
            $lam=0;
            $noon=0;
            $meem=0;
            $waw=0;
            $ya2=0;
            $ha2=0;
            $ra2=0;
            $ba2=0;
            $kaein=0;
            $ta2=0;
            $ein=0;
            $fa2=0;
            $qaf=0;
            $seen=0;
            $dal=0;
            $thal=0;
            $heh=0;
            $jeem=0;
            $kha2=0;
            $sheen=0;
            $saud=0;
            $daud=0;
            $zay=0;
            $tha2=0;
            $taa2=0;
            $ghein=0;
            $za2=0;
            $hamzeh=0;
            $ta2M=0;
            $LettersCount = [];
            $count = 0;

            foreach ($allDecodedSuras as $decodedSura) {
                $lettersArray = $decodedSura["LetterOccurrences"];
                // dd($lettersArray);
                foreach ($lettersArray as $letter=>$key) {
                    $count = $count+$key;
                    $LettersCount["all"] = $count;
                    if ($letter == 'أ' || $letter == 'إ' || $letter == 'آ' || $letter == 'ا') {
                        $alef = $alef + $key;
                        $LettersCount['ا أ إ آ'] = $alef;
                        
                    }
                    if( $letter == 'ء'){
                        $hamzeh = $hamzeh + $key;
                        $LettersCount['ء'] = $hamzeh;
                    }
                    if( $letter == 'ى'){
                        $alefM = $alefM + $key;
                        $LettersCount['ى'] = $alefM;
                    }
                    elseif ($letter == 'ل') {
                        $lam = $lam + $key;
                        $LettersCount['ل'] = $lam;
                        
                    }
                    elseif ($letter == 'ن') {
                        $noon = $noon + $key;
                        $LettersCount['ن'] = $noon;
                        
                    }
                    elseif ($letter == 'م') {
                        $meem = $meem + $key;
                        $LettersCount['م'] = $meem;
                        
                    }
                    elseif ($letter == 'و' || $letter == 'ؤ') {
                        $waw = $waw + $key;
                        $LettersCount['و ؤ'] = $waw;
                        
                    }
                    elseif ($letter == 'ئ' || $letter == 'ي') {
                        $ya2 = $ya2 + $key;
                        $LettersCount['ي'] = $ya2;
                        
                    }
                    elseif ($letter == 'ه') {
                        $ha2 = $ha2 + $key;
                        $LettersCount['ه'] = $ha2;
                        
                    }
                    elseif ($letter == 'ة') {
                        $ta2M = $ta2M + $key;
                        $LettersCount['ة'] = $ta2M;
                        
                    }
                    elseif ($letter == 'ر') {
                        $ra2 = $ra2 + $key;
                        $LettersCount['ر'] = $ra2;
                        
                    }
                    elseif ($letter == 'ب') {
                        $ba2 = $ba2 + $key;
                        $LettersCount['ب'] = $ba2;
                        
                    }
                    elseif ($letter == 'ك') {
                        $kaein = $kaein + $key;
                        $LettersCount['ك'] = $kaein;
                        
                    }
                    elseif ($letter == 'ت') {
                        $ta2 = $ta2 + $key;
                        $LettersCount['ت'] = $ta2;
                        
                    }
                    elseif ($letter == 'ع') {
                        $ein = $ein + $key;
                        $LettersCount['ع'] = $ein;
                        
                    }
                    elseif ($letter == 'ف') {
                        $fa2 = $fa2 + $key;
                        $LettersCount['ف'] = $fa2;
                        
                    }
                    elseif ($letter == 'ق') {
                        $qaf = $qaf + $key;
                        $LettersCount['ق'] = $qaf;
                        
                    }
                    elseif ($letter == 'س') {
                        $seen = $seen + $key;
                        $LettersCount['س'] = $seen;
                        
                    }
                    elseif ($letter == 'د') {
                        $dal = $dal + $key;
                        $LettersCount['د'] = $dal;
                        
                    }
                    elseif ($letter == 'ذ') {
                        $thal = $thal + $key;
                        $LettersCount['ذ'] = $thal;
                        
                    }
                    elseif ($letter == 'ح') {
                        $heh = $heh + $key;
                        $LettersCount['ح'] = $heh;
                        
                    }
                    elseif ($letter == 'ج') {
                        $jeem = $jeem + $key;
                        $LettersCount['ج'] = $jeem;
                        
                    }
                    elseif ($letter == 'خ') {
                        $kha2 = $kha2 + $key;
                        $LettersCount['خ'] = $kha2;
                        
                    }
                    elseif ($letter == 'ش') {
                        $sheen = $sheen + $key;
                        $LettersCount['ش'] = $sheen;
                        
                    }
                    elseif ($letter == 'ص') {
                        $saud = $saud + $key;
                        $LettersCount['ص'] = $saud;
                        
                    }
                    elseif ($letter == 'ض') {
                        $daud = $daud + $key;
                        $LettersCount['ض'] = $daud;
                        
                    }
                    elseif ($letter == 'ز') {
                        $zay = $zay + $key;
                        $LettersCount['ز'] = $zay;
                        
                    }
                    elseif ($letter == 'ث') {
                        $tha2 = $tha2 + $key;
                        $LettersCount['ث'] = $tha2;
                        
                    }
                    elseif ($letter == 'ط') {
                        $taa2 = $taa2 + $key;
                        $LettersCount['ط'] = $taa2;
                        
                    }
                    elseif ($letter == 'غ') {
                        $ghein = $ghein + $key;
                        $LettersCount['غ'] = $ghein;
                        
                    }
                    elseif ($letter == 'ظ') {
                        $za2 = $za2 + $key;
                        $LettersCount['ظ'] = $za2;
                        
                    }
                }
            }
            arsort($LettersCount);
            file_put_contents(storage_path('TheBookLettersCount'), json_encode($LettersCount, JSON_UNESCAPED_UNICODE));
        }
        $LettersCount = file_get_contents(storage_path('TheBookLettersCount'));

        return $LettersCount;
    }

}
