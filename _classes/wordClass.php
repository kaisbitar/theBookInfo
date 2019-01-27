<?php


    class words extends verse{

        public $verse;
        public $verse_number;
        function __construct( $verse, $verse_number ) { //when building the database consider passing ($sura_number, $verse_numbe, $word_number)as index for verse
            
            $this->verse = $verse;
            $this->verse_number = $verse_number;
        }   

        function indexTheWords(){
            $verse = $this->verse ;//var_dump($verse);
            $verse_number = $this->verse_number;
            $verseArray =  array();
            $wordsIndex = array();
            $verseArray = explode(' ', $verse);
            for($i = 0; $i < sizeof($verseArray); $i++){
               $wordsIndex["Verse"] = $i+1;
               $numberOfLetters = strlen($verseArray[$i])/2;
               $wordsIndex["lettersCount"] = $numberOfLetters;
               $wordsIndex["Word"] = $verseArray[$i];
               
            }
           
             return $wordsIndex;
        }

        function breakToLetters($wordsIndex){
           for($i=1; $i<sizeof($wordsIndex); $i++){
                $word = $wordsIndex[$i];
                $letters = str_split($word);
           }
           return $letters[3];
        }

    }