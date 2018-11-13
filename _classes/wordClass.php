<?php


    class words extends verse{

        public $verse;
        public $verse_number;
        function __construct( $verse ) { //when building the database consider passing ($sura_number, $verse_numbe, $word_number)as index for verse
            
            $this->verse = $verse;
        }   

        function indexTheWords(){
            $verse = $this->verse ;
            $wordCount =  array();
            for($i = 0; $i < sizeof($verse); $i++){
                $wordIndex = $i + 1;
                $wordCount [($wordIndex)] = $verse[$i];
            }

            return $wordCount;
        }

        function breakToLetters($wordsIndex){
           for($i=1; $i<sizeof($wordsIndex); $i++){
                $word = $wordsIndex[$i];
                $letters = str_split($word);
           }
           return $letters[3];
        }

    }