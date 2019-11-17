<template>
  <div>
    <div class="container-fluid">
      <div class="card-group" size="lg" text="Large">
      </div>
      <div class="card calContainer" v-if="versesOn" size="lg" text="Large">
        <div class="card" v-if="calBox">
          <div
            class="verse card"
            v-for="(verseToCal, key) in versesToCal"
            :key="key"
          >
            <div 
              class = "verseIndex btn btn-warning"
            > اية رقم {{verseToCal.verseIndex}} 
            </div>
            <div class="btn btn-success">
             {{verseToCal.verseText.substring(0,8)+".."}}
            </div> 
           div. score={{verseToCal.verseScore.score}}
          </div>
        </div>
        <div class="resultBox bade-success">Division:{{Verses19Result}}</div>
        <div class="resultBox bade-success">Addition:{{VersesAddition}}</div>
        <div 
          class="btn btn-danger clean-box"
          @click="versesToCal=[]"
        >
          مسح الحسابات
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
  .clean-box{
    font-weight: 300;
    width: 157px;
  }
  .calContainer{
    position: fixed;
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
