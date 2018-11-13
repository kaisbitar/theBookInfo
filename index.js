$(document).ready(function(){


    console.log('READY FREADY!');

    fullSura = $('#alfataha').text();

    $('#withIntro_button').click(function(){
        fullSuraSanatized = santizeComma(fullSura);
        //Number of Verses in a full Sura
        versesNumber = calculateNumberOfVerses(fullSuraSanatized);
        //Number of Words in a Sura
        WordsNumber_Sura = calculateNumberOfWords(fullSuraSanatized);
        srua_body = '#sura_body';
        embedToTable(srua_body, versesNumber, WordsNumber_Sura);
    });    

    //without intro
    $('#noIntro_button').click(function(){
        NoIntroSura = removeIntro(fullSura);
        fullSuraSanatized = santizeComma(NoIntroSura);
        versesNumberNoIntro = calculateNumberOfVerses(fullSuraSanatized);
        WordsNumberNoIntro_Sura = calculateNumberOfWords(fullSuraSanatized);
        suraNoIntro_body = '#suraNoIntro_body';
        embedToTable(suraNoIntro_body, versesNumberNoIntro, WordsNumberNoIntro_Sura );
    });

});
function removeIntro(fullSura){
    splitSuraIntro = fullSura.split(",");
    verse = new Array();
    j=0;
    for(i=0; i<splitSuraIntro.length; i++){
        if(i!=0){
            verse[j] = splitSuraIntro[i];
            j++;
        }
    }
    return verse.toString();
}
function embedToTable(suraTable, numberOfVerses, numberOfWords_Sura){
    $(suraTable).append('<tr> <td class="numberCell" id="numberOfVerses">'+ numberOfVerses +'</td> <td class="numberCell" id="numberOfWords_sura">'+ numberOfWords_Sura +'</td></tr>');

}
function countWords(verse){
    TwordsCount = 0;
    verse = verse.split(" ");
    TwordsCount = verse.length;
    return TwordsCount;
}
function calculateNumberOfWords(fullSura){
    splitSura = fullSura.split(",");
    wordsCount = 0;
    for(i=0; i<splitSura.length; i++){
        verse = splitSura[i];
        count = countWords(verse);
        wordsCount = wordsCount + count;
    }
    return wordsCount;
}

function calculateNumberOfVerses(fullSura){
    verseLength = 0;
    splitSura = fullSura.split(",");
    verseLength = splitSura.length;
    return verseLength;
}

function santizeComma(fullSura){
    fullSuraSanatized = new Array();
    for(s=0; s<fullSura.length; s++){
        if(fullSura[s] == ','){
            fullSura[s] = ',';      console.log(fullSura[s]);  
        }
    }fullSuraSanatized = fullSura;
    return fullSuraSanatized;
}