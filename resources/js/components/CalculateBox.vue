<template>
  <div>
    <div class="container-fluid">
      <div class="card-group" size="lg" text="Large">
        <!-- <div
          v-for="(suraIndexItem, index) in surasList"
          v-bind:key="index"
          @click.prevent="fetchVerses(suraIndexItem.fileName)"
        >{{suraIndexItem.suraName}} {{suraIndexItem.suraIndex}}
        </div> -->
        Drop to Calculate Bro..
      </div>
      <div class="card" v-if="versesOn" size="lg" text="Large">
        <div class="card" v-if="calBox">
          <div
            class="badge badge-warning"
            v-for="(verseToCal, key) in versesToCal"
            :key="key"
          >اية رقم {{verseToCal.verseIndex}} {{verseToCal.verseText}} score={{verseToCal.verseScore.score}}</div>
        </div>
        <div class="resultBox bade-success">Division:{{Verses19Result}}</div>
        <div class="resultBox bade-success">Addition:{{VersesAddition}}</div>
        <!-- <div
          v-for="(verse, index) in verses"
          v-bind:key="index"
          v-on:click="putVerseToCal(index, verse.verseText)"
        >{{index}}- {{verse.verseText}}</div> -->
      </div>
    </div>
  </div>
</template>

<style scoped>
body {
  /* direction: ltr; */
}
.badge{
  max-width: 600px;
}
</style>

<script>
export default {
  props:["suraFileName", "verseIndex", "verseText"],
  watch:{
    "suraFileName": function(){
      this.fetchVerses(this.suraFileName)
      },
      "verseIndex": function(){
      this.putVerseToCal(this.verseIndex, this.verseText)
      }
  },
  data() {
    return {
      surasList: [],
      verses: [],
      versesToCal: [],
      verseToCal: "",
      versesOn: false,
      calBox: false,
      // suraFileName: "",
      // verseIndex: "",
      verseScore: ""
    };
  },
  methods: {
    fetchListCal: function(){
      fetch("api/quran-index", { method: "GET" })
        .then(res => res.json())
        .then(res => {
          this.surasList = res;
        });        
        return this.surasList;
    },
    fetchVerses: function(suraFileName) {    

      this.suraFileName = suraFileName;
      fetch("api/verses-map/" + suraFileName, { method: "GET" })
        .then(res => res.json())
        .then(res => {
          this.verses = res;
          this.versesOn = true;
        });
      this.getVerseScores();
    },
    putVerseToCal: function(verseIndex, verse) {
      this.verseIndex = verseIndex;
      this.verseScore = this.versesScore[verseIndex];
      this.versesToCal.push({
        verseIndex: verseIndex,
        suraIndex: this.suraFileName,
        verseScore: this.verseScore,
        verseText: verse
      });
      this.calBox = true;
      return this.verseToCal;
    },
    getVerseScores: function() {
      fetch("api/verses-score/" + this.suraFileName, { method: "GET" })
        .then(res => res.json())
        .then(res => {
          this.versesScore = res;
        });
      return this.versesScore;
    }
  },
  computed: {
    Verses19Result: function() {
      let versesSore = 0;
      for (var i = 0; i < Object.keys(this.versesToCal).length; i++) {
        versesSore = versesSore + this.versesToCal[i].verseScore.score;
      }
      return versesSore / 19;
    },
    VersesAddition: function(){
      let versesSore = 0;
      for (var i = 0; i < Object.keys(this.versesToCal).length; i++) {
        versesSore = versesSore + this.versesToCal[i].verseScore.score;
      }
      return versesSore;
    }
  },
  created() {
    this.fetchListCal();
  },
  updated() {},
  mounted() {}
};
</script>
