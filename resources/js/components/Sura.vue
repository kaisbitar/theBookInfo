<template>
<div v-if="loading" class="container-fluid spinner-box">
      <b-spinner label="Spinner" variant="success"></b-spinner>
    </div>
  <div v-if="!loading"  class="suraBlock card" v-on:click="changeToScreen">
    
    <!-- <draggable @unchoose="dropToCalculate"> -->
      <!-- </draggable> -->
    <!-- <div v-if="!loading"> -->
      <calculate-box :verseText="verse.verseText" :verseIndex="verseIndex" :suraFileName="suraFileName" ></calculate-box>
    <!-- </div> -->
      <!-- change the next tag to draggable when you get there -->
    <div v-if="!loading" class="versesBlock" @click ="clickToCalculate">
      <div class="titleContainer card-header">
      <!-- <fixedheader v-if="showSura"> -->
        <div class="titleBlock">
          <div class="suraTitle">
            <div
              class="suraInfo btn btn-warning col-sm suraVersesNum"
            >
              عدد الآيات {{sura.NumberOfVerses}}
            </div>
            <div class="suraName btn btn-success">سورة {{sura.suraName}}</div>
          </div>
          <div class="suraInfoBlock">
            <span class="suraInfo btn btn-danger col-sm">عدد الكلمات {{sura.NumberOfWords}}</span>
            <span class="suraInfo btn btn-secondary col-sm">عدد الحروف {{sura.NumberOfLetters}}</span>
          </div>
        </div>
      <!-- </fixedheader> -->
    </div>
      <div
        class="verse card"
        v-for="(verse, index) in verses"
        v-bind:key="index"
        ref="thisVerse"
        v-on:click.prevent="selectVerse(verse, index)" 
        v-if="index!=='SuraLettersCount'" 
      >
        <div class="SuraLettersCount">
          <span class="verseIndex btn btn-warning">آية {{index}}</span>
        </div>
        <!-- hidden inputs for holding data -->
        <input type="hidden" v-model="verse.verseText" />
        <input type="hidden" v-model="verse.NumberOfLetters" />
        <input type="hidden" v-model="verse.NumberOfWords" />
        <input type="hidden" v-model="verse.NumberOfWords" />
        <input type="hidden" v-model="index" />
        <!--  -->
        <div class="verseText container-fluid">
          <span class="btn btn-success">{{verse.verseText}}</span>
        </div>
        <div class="verseCounts">
            <span class="verseInfo btn btn-danger">{{verse.NumberOfWords}} كلمة</span>
            <span class="verseInfo btn btn-secondary">{{verse.NumberOfLetters}} حرف</span>
          </div>
      </div>
    </div>
  </div>
</template> 

<script>
import SearchSura from "./SearchSura.vue";
import CalculateBox from "./CalculateBox.vue";

export default {
  components: {
    SearchSura,
    props: ["verses"]
  },
  props: ["suraFileName", "screen"],
  data() {
    return {
      sura: [],
      verses: [],
      verse: [],
      detailShow: false,
      loading: false,
      showSura: false,
      verseIndex:0
    };
  },
  methods: {
    clickToCalculate() {
      // this.$emit("changingScreen", this.screen);
    },
    changeToScreen() {
      this.$emit("changingScreen", this.screen);
    },
    selectVerse(verse, index) {
      this.verse = verse;
      this.verseIndex = index; 
    }
  },
  computed: {
    fetchVerses: function() {
      if (this.suraFileName == "") {
        this.loading = false;
        return;
      }
      fetch("api/verses-map/" + this.suraFileName, { method: "GET" })
        .then(res => res.json())
        .then(res => {
          this.verses = res;
          this.showSura = true;
          this.loading = false;
        });
    },
    fetchSura: function() {
      this.showSura = false;
      if (this.suraFileName == "") {
        this.loading = false;
        return;
      }
      this.loading = true;
      fetch("api/sura-map/" + this.suraFileName, { method: "GET" })
        .then(res => res.json())
        .then(res => {
          this.sura = res;
          this.sura.NumberOfLetters = res.NumberOfLetters;
          this.sura.NumberOfVerses = res.NumberOfVerses;
          this.sura.NumberOfWords = res.NumberOfWords;
          this.sura.suraName = res.Name;
          this.sura.suraName = res.Name.replace(/[0-9]/g, "");
          this.fetchVerses;
        });
    }
  },
  mounted() {},
  created() {},
  updated() { }
};
</script>

<style lang="scss" >
.btn {
  padding: 0;
  color: #000;
}
.spinner-box {
  margin-top: 15px;
}
.suraInfoBlock {
  display: flex;
  margin-top: 2px;
}
.suraInfoBlock li > h2 > span {
  width: 254px;
  text-align: center;
}
.suraInfoBlock span{
  font-size: 10px;
}
.suraInfo {
  margin: 0px 2px 0px 1px;
  font-size: 12px;
}
.suraName {
  width: 224.4px;
  margin-left: -2px;
  font-size: 20px;
  /* padding-bottom: 9px; */
  color: black;
  height: 36px;
  margin-top: 3px;
}
.suraTitle {
  max-width: 224.4px;
  margin-top: -1px;
}
.titleContainer {
  padding: 0px 0px 4px 0px;
  background-color: #fbf5ef;
  transition: all 1s ease;
}
.titleBlock {
  max-width: 228px;
  margin: auto;
  transition: all 1s ease;
}
.titleBlock.vue-fixed-header--isFixed {
  position: fixed;
  // left: 0;
  top: 0;
  width: 100vw;
  background: #f8f9fa;
  border: 1px solid #00000020;
  z-index: 1;
  transition: all 0.11s ease;
}
.suraBlock {
  // min-height: 512px; 
    display: grid;
    grid-template-columns: 40% 60%;
    direction: ltr;
}
span.verseInfo.btn-danger {
  margin-left: 3px;
}
.btn-danger{
  background: #b8611738;
}
.SuraLettersCount {
  margin-left: auto;
  margin-right: auto;
}

.verse {
  margin-left: 4px;
  margin-bottom: 4px;
  padding: 4px;
  float: right;
  background: #f6eeef6b;
}
.verse a {
  color: #000;
}
.verse a:hover {
  color: red;
  text-decoration: none;
}
.versesBlock {
  padding: 4px 4px 4px 1px;
  transition: all 1s ease;
}
.detail {
  display: sticky;
}
.verseIndex {
  font-size: 12px;
  width: 110px;
}
.verseInfo {
  font-size: 12px;
   margin: 4px 0px 4px 4px;
  width: 41.4px;
  font-size: 10px;
}
.verseInfo .verseIndex {
  font-size: 12px;
}
.btn-warning {
  background-color: #ff750094;
  border-color: #e17c25;
}
.btn-secondary {
  background-color: #6c757d30;
}
.btn-warning {
  background-color: #ffc10796;
}
.btn-success {
  background-color: #28a7450a;
}
.verseCounts {
  display: flex;
  margin-top: 3px;
}
.verseText {
  text-align: center;
  margin-top: 1px;
  padding: 2px;
  padding-bottom: 0px;
  /* margin-bottom: 5px;
	padding: 11px; */
}
.verseText.container-fluid .btn {
  padding: 4px;
  font-size: 14px;
  padding-top: 0px;
}
</style>
