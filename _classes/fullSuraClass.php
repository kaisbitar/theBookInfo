    <?php
        class fullSura {

            public  $fullSura;
            public $sura_number;
            function __construct( $fullSura ) {
            
                $fullSura = explode(",", $fullSura);

                $this->fullSura = $fullSura;

            } 

            function breakToVerses(){
                $fullSura = $this->fullSura;
                for($i=0; $i < sizeof($fullSura); $i++){
                    $verseIndex = $i + 1;
                    //$verse[]= [$verseIndex=>$fullSura[$i]];
                    $verse [($verseIndex)] = $fullSura[$i];
                }
                return $verse;
            }

            function calculateNumberOfVerses(){

                $fullSura = $this->fullSura;
                return sizeof($fullSura);
            }
            
            function calculateNumberOfLetters(){

                $lettersCount = 0;
                $fullSura = $this->fullSura;
            for($i=0; $i < sizeof($fullSura); $i++){
                    $verse = explode(" ", $fullSura[$i]);
                    //var_dump($verse);
                    for($j=0; $j < sizeof($verse); $j++){
                    $numberOfLetters = strlen($verse[$j]);   
                    // var_dump($numberOfLetters);
                    // echo $verse[$j];echo '  '; echo ($numberOfLetters/2);echo '<br>';
                    // 
                        $lettersCount = $lettersCount + ($numberOfLetters/2);
                    }
                
            }
                return $lettersCount;
            }
            
            function calculateNumberOfWords(){
                $wordsCount = 0;
                $fullSura = $this->fullSura;
                for($i=0; $i < sizeof($fullSura); $i++){
                    $verse = $fullSura[$i];
                    $verse = explode(" ", $verse);
                    $verseNumberOfWord = sizeof($verse);
                    $wordsCount = $wordsCount + $verseNumberOfWord;
                }

                return $wordsCount;
            }

        }

    ?>