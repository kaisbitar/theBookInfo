<?php

include_once('../_classes/fullSuraClass.php');
include_once('../_classes/verseClass.php');
include_once('../_classes/wordClass.php');
include_once('../_classes/lettersClass.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$suraName = 'الفاتحة';
$text = 'بسم الله الرحمن الرحيم,الحمد لله رب العلمين,الرحمن الرحيم,ملك يوم الدين,إياك نعبد وإياك نستعين,اهدنا الصرط المستقيم,صرط الذين أنعمت عليهم غير المغضوب عليهم ولا الضالين';
    // $text = 'بسم الله الرحمن الرحيم,الحمد لله رب العلمين,الرحمن الرحيم,ملك يوم الدين,إياك نعبد وإياك نستعين,اهدنا الصرط المستقيم,صرط الذين أنعمت عليهم غير المغضوب عليهم ولا الضالين';
    //$text='abc, abcd, abcde, abcdef';
    //$myfile = file_get_contents("../البقرة.txt"); 
   // $text = $myfile;//echo $text;
if (isset($text)) {

    $fullSura = new fullSura($text);

    $suraObject = prepareSuraJSON($fullSura);
    $suraObject->suraName = $suraName;


    $verses = $fullSura->fullSura;

    $verseObject = pross_verses($verses);

    $suraObject->verse = $verseObject;        
    $jsonObject = json_encode($suraObject);
    echo $jsonObject;

} else {
    echo 'Full Sura Not Provided';
}

function pross_verseWords($verseWords)
{

    for ($j = 0; $j < sizeof($wordsArray); $j++) {

        $words = new words($wordsArray);
        $wordsIndex = $words->indexTheWords();
        var_dump($words);
        echo '<br>';
        $word[$i + 1] = $wordsIndex;
        $singleWord = $wordsIndex;

    }
    return $singleWord;
}
function pross_verses($verses)
{
    $verseObject = new \stdClass();

    for ($i = 0; $i < sizeof($verses); $i++) {

        $verse = new verse($verses[$i], $i);
        $verseJSON = new \stdClass();
        $wordsJSON = new \stdClass();
        $verseIndex = $i + 1;
        $verseJSON = prepareVerseJSON($verse, $verseIndex);
        $verseObject->$verseIndex = $verseJSON;
    }
    return $verseObject;
}
function prepareVerseJSON($verse, $i)
{
    $verseNumberOfWords = $verse->calculateVerseWords();
    $verseNumberOfLetters = $verse->calculateVerseLetters();
    $verseJSON = new \stdClass();
    $verseJSON->TheVerse = implode(" ", $verse->verse);
    $verseJSON->WordsCount = $verseNumberOfWords;
    $verseJSON->lettersCount = $verseNumberOfLetters;

    return $verseJSON;
}

function prepareSuraJSON($fullSura)
{

    $numberOfVerses = $fullSura->calculateNumberOfVerses();
    $numberOfWords = $fullSura->calculateNumberOfWords();
    $numberOfLetters = $fullSura->calculateNumberOfLetters();
    $sura = new \stdClass();
    $sura->numberOfVerses = $numberOfVerses;
    $sura->numberOfWords = $numberOfWords;
    $sura->numberOfLetters = $numberOfLetters;
    $sura->VerseIndex = $fullSura->breakToVerses();

    return $sura;

}





?>