<template>
  <!-- remove v-app when integrating -->
  <v-app>
    <v-card-title>تواتر الكلمات</v-card-title>
    <div v-for="k in quranIndex">
      <h1>سورة {{k.fileName}}</h1>
      <verseCountChart :type="'letters'" :fileName="k.fileName"> </verseCountChart>
    </div>
  </v-app>
</template>


<script>
import sura from '../Quran/sura.vue'
import suraOccurences from './comp/occurences/suraOccurences.vue'
import verseCountChart from './comp/verseCountChart.vue'
import suraIndexes from './comp/indexes/suraIndexes.vue'
// import verseDetails from  '../board/boardComponents/calculations/calculationComp/verseDetails.vue'

export default {
  components:{
    suraOccurences,
    suraIndexes
   },
  props: [],
  data() {
    return {
      quranIndex:[],
      fileName:"002البقرة",
      showSura: false
    }
  },
  computed: { },
  methods:{
    fetchData(){
      fetch('api/quran/quranIndex',{method: "GET"})
        .then(res => res.json())
        .then(res =>{
          this.quranIndex = res
      })
    },
  },
  created(){
    this.fetchData()
  }
};
</script>

<style lang="scss">
.numberCard{
  width: 300px;
  font-size: .2em;
}
li.verseLabel {
    margin-left: -1px !important;
    min-width: 19px !important;
}
.thisChart{
    direction: ltr !important;
}
.tooltip {
  background: rgba(0, 0, 0, 0.8);
  border-radius: 4px;
  direction: rtl !important;
}

.suraTitle {
  padding: 5px;
  color: #959da5;
}

.list {
  list-style: none;
  display: flex;
  padding-left: 3px !important;
}

.list li {
  padding-top: 2px;
  flex: 1;
  color: #fff;
  margin: 0;
  min-width: 56px;
  padding-right: 3px;
}

.list li::before {
  content: none;
}

.label {
  color: #dfe2e5;
  font-weight: 600;
  display: flex;
}

.value {
  color: #959da5;
  // margin-right: 3px;
}
</style>