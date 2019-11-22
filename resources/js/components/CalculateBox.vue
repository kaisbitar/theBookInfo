<template>
  <div>
    <div class="container-fluid">
      <div 
          class="btn btn-danger clean-box"
          @click="versesToCal=[]"
        >
          مسح الحسابات
        </div>
      <div class="card-group" size="lg" text="Large">
      
      <div class="container calContainer" v-if="versesOn" size="lg" text="Large">
        <div class="verseWrap container" v-if="calBox" v-for="(verseToCal, key) in versesToCal"
            :key="key">
          <div
            class="verse card"
          >
            <div 
              class = "verseIndex btn btn-warning"
            > اية رقم {{verseToCal.verseIndex}} 
            </div>
            <div class="verseText">
            <div class="btn btn-success">
             {{verseToCal.verseText.substring(0,20)+".."}}
            </div> 
            </div>
           <div class="verseScore btn btn-info"> {{verseToCal.verseScore.score}}</div>
           
          </div>
          <div class="plusSign card" v-if="(key == versesToCal.length-1)">
            =
          </div>
          <div class="plusSign card" v-else-if="(versesToCal.length > 1)">
            +
          </div>
        </div>
      </div>
      <div class="clacWrap card">
        <div class="resultBox bade-success">مجموع الايات ={{VersesAddition}}</div>
        <div class="resultBox bade-success">{{VersesAddition}}<span> &#247; </span>19 = {{Verses19Result}}</div>
      </div>
      <!-- <toast-component :toastMsg="toastMsg" :toastOn="toastOn"></toast-component> -->
    </div>
    </div>
  </div>
</template>

<style scoped>
  .clean-box{
    font-weight: 300;
    width: 157px;
  }
  .verseScore{
    font-size: 13px;
    color: #007709;
    background: #28b8174d;
  }
  .verseIndex.btn.btn-warning {
    margin: auto;
  }
  .plusSign{
    margin-left: 4px;
    margin-bottom: 4px;
    padding: 4px;
    float: right;
    margin-top: 48px;
    font-weight: bolder;
  }
  .verseWrap{
    max-width: fit-content;
    float: right; 
    padding: 0px;
  
  }
  .clacWrap{
    float: right;
  }
</style>

<script>

import ToastComponent from './ToastComponent.vue'

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
      verseScore: "",
      versesScore:[],
      toastOn:false
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
        });
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
      this.versesOn = true;
      this.calBox = true;
      return this.verseToCal;
    },
    getVerseScores: function() {
      fetch("api/verses-score/" + this.suraFileName, { method: "GET" })
        .then(res => res.json())
        .then(res => {
          this.versesScore = res;
      });
    }
  },
  computed: {
    Verses19Result: function() {
      let versesSore = 0;
      for (var i = 0; i < Object.keys(this.versesToCal).length; i++) {
        versesSore = versesSore + this.versesToCal[i].verseScore.score;
      }
      // if(Number.isInteger(versesSore/19)){
      //   this.toastOn = true;
      //   this.toastMsg = this.versesToCal[i].verseScore.score+' /19 = '+versesSore/19;
      // }
      // else{
      //   this.toastOn =false;
      // }
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
    this.getVerseScores()
  },
  updated() {},
  mounted() {}
};
</script>
