<template>
  <!-- remove v-app when integrating -->
  <v-app class="temp">
    <div  @click="showIndex = !showIndex">
      <quranIndex class="dropIndex" v-show="showIndex" @playSura="playSura"></quranIndex>
    </div>
    
    
      <!-- <v-app-bar class="" 
        elevate-on-scroll
        scroll-target="#titeText" 
        fixed 
        flat 
        color="white"
      > 
        <h1  class="text-center mb-3  ml-auto mr-auto">سورة {{fileName}}</h1></v-app-bar> -->
    <v-toolbar-title>
      <h4  class="display-1	text-center   ml-auto mr-auto">سورة {{fileName}}</h4> 
    </v-toolbar-title>
    <v-card flat>
      <v-card-title class="pa-0">
        <v-btn @click="showIndex = !showIndex">القائمة 
          <v-icon class="mr-2" small>mdi-script-text-outline</v-icon>
        </v-btn>    
      </v-card-title>
      <v-card-title class="pa-0">        
        <v-btn class="ml-12" @click="showSura = !showSura">الآيات
          <v-icon class="mr-2" small>mdi-format-list-bulleted</v-icon>
          </v-btn>
        <span class="display-3 blueText">{{numberOfVerses}}</span>
        <span class="grey--text">آية</span>
      </v-card-title>
      <sura v-show="showSura" :fileName="fileName" ref="sura"></sura>
    </v-card>  
    <v-row class="pa-1" :max-height="statsHeight" flat width="100%">
      <div class="ml-2">
        <v-row class="pr-3" style="width: fit-content;"> 
          <v-card  width="250" class=" ma-2 pr-12 pa-12">
            <span class="display-3 blueText">{{numberOfWords}}</span>
            <span class="grey--text">كلمة</span>
          </v-card>
          <v-card class="ml-1 mr-1 ma-2">
            <v-card-title>تكرار الكلمات</v-card-title>
            <suraOccurences :type="'words'" :fileName="fileName"></suraOccurences>
          </v-card>
          <v-card class="ml-1 mr-1 ma-2">
            <v-card-title>تواتر الكلمات</v-card-title>
            <verseCountChart :type="'words'" :fileName="fileName"> </verseCountChart>
          </v-card>
        </v-row>
        <v-row class="pr-3 mt-5 mb-5" style="width: fit-content;"> 
          <v-card  width="250" class="pr-12 pa-12 ma-2">
            <span class="display-3 blueText">{{numberOfLetters}}</span>
            <span class="grey--text">حرف</span>
          </v-card>
          <v-card class="ml-1 mr-1 ma-2">
            <v-card-title>تكرار الأحرف</v-card-title>
          <suraOccurences :type="'letters'" :fileName="fileName"></suraOccurences></v-card>
          <v-card class="ml-1 mr-1 ma-2">
            <v-card-title>تواتر الأحرف</v-card-title>
          <verseCountChart :type="'letters'" :fileName="fileName"> </verseCountChart></v-card>
        </v-row>
      </div>
        <v-card :max-height="statsHeight" class="mb-2 pl-5 pr-5 ml-2 mr-2">
          <v-card-title>مواقع الكلمات</v-card-title>
          <suraIndexes :type="'words'" :numberOfWords="numberOfWords" :fileName="fileName"></suraIndexes>
        </v-card>
        <v-card :max-height="statsHeight" class="mb-2 pl-5 pr-5 ml-2 mr-2">
          <v-card-title>مواقع الأحرف</v-card-title>
          <suraIndexes :type="'letters'" :numberOfVerses="numberOfVerses" :fileName="fileName"></suraIndexes>
        </v-card>
    </v-row>
  </v-app>
</template> 


<script>
import quranIndex from '../Quran/quranIndex'
import sura from '../Quran/sura.vue'
import suraOccurences from './comp/occurences/suraOccurences.vue'
import verseCountChart from './comp/verseCountChart.vue'
import suraIndexes from './comp/indexes/suraIndexes.vue'

export default {
  components:{ 
    suraOccurences,
    suraIndexes,
    verseCountChart
   },
  props: [],
  data() {
    return {
      porminent:false,
      numberOfWords:0,
      numberOfLetters:0,
      numberOfVerses:0,
      sura:[],
      fileName:"001الفاتحة",
      showSura: false,
      showIndex:false
    }
  },
  computed: {
    statsHeight () {
      switch (this.$vuetify.breakpoint.name) {
        // case 'xs': return '220px'
        // case 'sm': return '400px'
        // case 'md': return '200px'
        case 'lg': return '1000px'
        // case 'xl': return '800px'
      }
    }
  },
  methods:{
    fetchData(){
      fetch('api/sura-map-f/' + this.fileName,{method: "GET"}) 
        .then(res => res.json())
        .then(res =>{
          this.sura =  res 
          this.numberOfWords = this.sura.NumberOfWords
          this.numberOfLetters = this.sura.NumberOfLetters
          var result = Object.values(this.sura.versesMap)
          this.numberOfVerses = result.length
      })
    },
    playSura(value){
      console.log(value.fileName)
      this.fileName = value.fileName
      this.fetchData()
    }
  },
  created(){  
    this.fetchData()
  }
};
</script>

<style lang="scss" scoped>
@import '~@/variables.scss';

.temp{
  max-width: 1503px;
  margin-right: 9px;
}
.dropIndex{
  position: fixed;
  z-index: 4;
}
.suraTitle {
  width: 302px;
  margin: auto;
  background: #626c91 !important;
  color: white;
}
.countCard{
  max-width: 157px;
  border-top: 4px solid #3fb1e3;
}
.blueText{
  color: $blue;
}
</style> 