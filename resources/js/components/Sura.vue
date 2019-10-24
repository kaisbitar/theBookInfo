<template>
  <div
    class="suraBlock card"
    v-on:click="changeToScreen"
  >
    <div
      v-if="loading"
      class="container-fluid spinner-box"
    >
      <b-spinner
        label="Spinner"
        variant="success"
      ></b-spinner>
    </div>
    <div class="titleContainer card-header">
      <fixedheader v-if="showSura">
        <div class="titleBlock">
          <div class="suraInfoBlock ">
            <span class="suraInfo btn btn-custom-orange col-sm">
              عدد الكلمات {{sura.NumberOfWords}}
            </span>
            <span class="suraInfo btn btn-secondary col-sm">
              عدد الحروف {{sura.NumberOfLetters}}
            </span>
          </div>
          <div class="suraTitle">
            <div class="suraInfo btn btn-warning col-sm suraVersesNum ">
              عدد الآيات {{sura.NumberOfVerses}}
            </div>
            <div class="suraName btn btn-success">سورة {{sura.suraName}}</div>
          </div>
          <!-- <SearchSura ref="searchSura" v-if="showSura" :verses = "verses">SearchSura</SearchSura>                          -->
        </div>
      </fixedheader>
    </div>

    <div
      v-if="showSura"
      class="versesBlock"
    >
      <div
        class="verse card"
        v-for="(verse, index) in verses"
        v-bind:key="index"
        @click.prevent="showDetail(verse)"
      >
        <div
          v-if="index!='SuraLettersCount'"
          class="SuraLettersCount"
        >
          <div class="verseCounts">
            <span class="verseInfo btn btn-custom-orange">{{verse.NumberOfWords}} كلمة</span>
            <span class="verseInfo btn btn-secondary">{{verse.NumberOfLetters}} حرف</span>
          </div>
          <span class="verseIndex btn btn-warning">
            آية رقم: {{index}}
          </span>
        </div>
        <!-- hidden inputs for holding data -->
        <input
          type="hidden"
          v-model="verse.verseText"
        >
        <input
          type="hidden"
          v-model="verse.NumberOfLetters"
        >
        <input
          type="hidden"
          v-model="verse.NumberOfWords"
        >
        <!--  -->
        <div class="verseText container-fluid">
          <span class="btn btn-success">
            {{verse.verseText}}
          </span>
        </div>
      </div>
    </div>
  </div>
</template> 

<!-- Lib for stars -->
<script>
import SearchSura from "./SearchSura.vue";
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
      showSura: false
    };
  },
  methods: {
    showDetail(verse) {
      this.verse.verseText = verse.verseText;
      this.verse.NumberOfLetters = verse.NumberOfLetters;
      this.verse.NumberOfWords = verse.NumberOfWords;
      this.detailShow = true;
      return this.verse;
    },
    changeToScreen() {
      this.$emit("changingScreen", this.screen);
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
          this.sura.NumberOfLetters = res.NumberOfLetters;
          this.sura.NumberOfVerses = res.NumberOfVerses;
          this.sura.NumberOfWords = res.NumberOfWords;
          console.log(res.Name);
          this.sura.suraName = res.Name;
          console.log(res.Name);
          this.fetchVerses;
        });
    }
  },
  mounted() {}
};
</script>

<style scoped>
.btn {
  padding: 0;
  color: #000;
}
.spinner-box {
  margin-top: 15px;
}
.suraInfoBlock {
  display: flex;
}
.suraInfoBlock li > h2 > span {
  width: 254px;
  text-align: center;
}
.suraInfo {
  margin: 0px 2px 0px 2px;
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
  padding: 4px 0px 4px 0px;
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
  left: 0;
  top: 0;
  width: 100vw;
  background: #f8f9fa;
  border: 1px solid #00000020;
  z-index: 1;
  transition: all 0.11s ease;
}
.suraBlock {
  /* min-height: 512px; */
}
span.verseInfo.btn-custom-orange {
  margin-left: 3px;
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
  /* margin: 4px 0px 4px 4px; */
  width: 53.4px;
}
.verseInfo .verseIndex {
  font-size: 12px;
}
.btn-custom-orange {
  background-color: #ff750094;
  border-color: #e17c25;
}
.btn-secondary {
  background-color: #6c757db0;
}
.btn-warning {
  background-color: #ffc10796;
}
.btn-success {
  background-color: #28a74557;
}
.verseCounts {
  display: flex;
}
.verseText {
  text-align: center;
  margin-top: 3px;
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
