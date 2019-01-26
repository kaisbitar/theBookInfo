$(document).ready(function() {
  console.log("READY FREADY!");

  fullSura = $("#alfataha").text();
  analyseSura(fullSura);

  $("#withIntro_button").click(function() {
    // fullSuraSanatized = santizeComma(fullSura);
    // //Number of Verses in a full Sura
    // versesNumber = calculateNumberOfVerses(fullSuraSanatized);
    // //Number of Words in a Sura
    // WordsNumber_Sura = calculateNumberOfWords(fullSuraSanatized);
    // srua_body = '#sura_body';
    // embedToTable(srua_body, versesNumber, WordsNumber_Sura);
    analyseSura(fullSura);
  });

  //without intro
  $("#noIntro_button").click(function() {
    // NoIntroSura = removeIntro(fullSura);
    // fullSuraSanatized = santizeComma(NoIntroSura);
    // versesNumberNoIntro = calculateNumberOfVerses(fullSuraSanatized);
    // WordsNumberNoIntro_Sura = calculateNumberOfWords(fullSuraSanatized);
    // suraNoIntro_body = '#suraNoIntro_body';
    // embedToTable(suraNoIntro_body, versesNumberNoIntro, WordsNumberNoIntro_Sura );
  });
});

function analyseSura() {
  $.ajax({
    url: "_processes/FullSuraProgram.php", // point to server-side PHP script
    dataType: "json", // what to expect back from the PHP script, if anything
    cache: false,
    contentType: false,
    processData: false,
    type: "post",
    success: function(php_script_response) {
      console.log(php_script_response); // display response from the PHP script, if any
    }
  });
}
