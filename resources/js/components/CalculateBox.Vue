<template>
  <div>
    <div class="container-fluid">
      <div class="card-group"
        size="lg"
        text="Large"
      >
        <div 
          v-for="(suraIndexItem, index) in surasList"
          v-bind:key="index"
          @click.prevent="fetchVerses(suraIndexItem.fileName)"
        >
          {{suraIndexItem.suraName}} {{suraIndexItem.suraIndex}}
        </div>
      </div>
      <div class="container">
        <div v-if="calBox">
          <div class="badge badge-warning" v-for="verseToCal in versesToCal">
            اية رقم {{verseToCal.verseIndex}}   {{verseToCal.verseText}}    score={{verseToCal.verseScore.score}}               
          </div>
        </div>
        <div class="col-sm">
          <div class="resultBox bade-success">
          <p>{{Verses19Result}}</p>
        </div>
        </div>
      <div class="row" v-if="versesOn">

        <div class="col-sm">
          <div
          v-for="(verse, index) in verses"
          v-bind:key="index"
          v-on:click="putVerseToCal(index, verse.verseText)"
        >
          {{index}}- {{verse.verseText}}
        </div>
        </div>
        </div>
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
  data() {
    return {
      surasList: [],
      verses: [],
      versesToCal: [],
      verseToCal:'',
      versesOn: false,
      calBox: false,
      suraFileName:'',
      verseIndex:'',
      verseScore: '',
      // allVersesScore:[]
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
        // this.getAllVerseScores();
    },
    putVerseToCal: function(verseIndex, verse) {
      this.verseIndex = verseIndex;
      this.verseScore = this.versesScore[verseIndex]
      this.versesToCal.push({verseIndex: verseIndex, suraIndex: this.suraFileName, verseScore: this.verseScore, verseText: verse});
      this.calBox = true;
      // this.verseToCal = this.versesScore[verse]

      return this.verseToCal;
    },
    getVerseScores: function(){
      fetch("api/verses-score/" + this.suraFileName, { method: "GET" })
        .then(res => res.json())
        .then(res => {
          this.versesScore = res
        });
      return this.versesScore;
    },
//     getAllVerseScores: function(){
//       for(var i = 0; i < (this.surasList).length; i++){
//               console.log(this.surasList[i].fileName);
// // return
//         let fileName = this.surasList[i].fileName
//         fetch("api/verses-score/" + fileName, { method: "GET" })
//           .then(res => res.json())
//           .then(res => {
//             console.log('s')
//             this.allVersesScore[i] = res
//           });
//       }        return this.allVersesScore;

//     }
  },
  computed: {
    Verses19Result: function() {
      let versesSore = 0;
      for(var i = 0; i < Object.keys(this.versesToCal).length; i++){
        versesSore = versesSore + this.versesToCal[i].verseScore.score
      }
      return versesSore/19;
    },
  },
  created() {
    this.fetchListCal();
  },
  updated() {},
  mounted() { }
};
</script>
