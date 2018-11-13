<?php

     class verse extends fullSura{


        public $verse;
        public $verse_number;
        function __construct( $verse, $verse_number ) {

            
            $verse = explode(" ", $verse);
            $this->verse = $verse;
            $this->verse_number = $verse_number;
            //$verse

        } 

        function calculateVerseWords(){
            $verse = $this->verse;
            return sizeof($verse);
        }
        function calculateVerseLetters(){
            $verse = $this->verse;
            $verse = implode("", $verse);
            $verseLetters = strlen($verse)/2;
            return $verseLetters;
        }
        
    }
?>