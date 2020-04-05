<template>
  <v-app>
    <v-container class="grey lighten-5 d-flex" fluid>
      <!-- <div class="quran-list"> -->
        <v-lazy> 
          <quranIndex v-on:plySra="plySra"></quranIndex>  
        </v-lazy>  
        <v-lazy>
            <sura ref="sura" @adVrsToCal="adVrsToCal19"></sura>  
            <!-- <sura ref="sura" @adVrsToCal="adVrsToTble"></sura>   -->
          </v-lazy>
      <!-- </div> -->
      <!-- <div class="quran-list"> -->
          <theNineteen ref="theNineteen"></theNineteen>
          <!-- <verses ref="verses"></verses> -->
      <!-- </div> -->
    </v-container>  
  </v-app>
</template> 


<script>
import quranIndex from '../Quran/quranIndex.vue'
import sura from '../Quran/sura.vue'
import verses from '../Quran/verses.vue'
import theNineteen from './boardComponents/calculations/theNineteen.vue'

export default {
  components:{
    sura,
    quranIndex,
    verses,
    theNineteen
  },
  props: [],
  data() {
    return {
    }
  },
  computed: {},
  methods:{
    plySra(suraToPlay){      
      //receiving sura or full Quran from QuranIndex to play a Sura and below sending to sura component
      if(suraToPlay == 'المصحف'){
        this.$refs.sura.playQuran()
      }
      else{
        this.$refs.sura.playThisSura(suraToPlay)
      }
    },
    adVrsToCal19(verse){
      //receiving verse from sura and below sending to verses component
      this.$refs.theNineteen.adThsVrs(verse)
    },
    adVrsToTble(verse){
      //receiving verse from sura and below sending to verses component
      this.$refs.verses.adThsVrs(verse)
    }
  }
};
</script>



<style lang="scss">
// @import "bootstrap";
// @import '~vuetify/src/styles/variables.scss';
@import '~@/variables.scss';
.v-application{
  font-family: $body-font-family;
}
 .v-application--wrap {
    min-height: 50px !important;
} 
.quran-list {
  width: 800px;
  margin: 10px;
}
.tableNumber{
  text-align: center;
  background: #F1F8E9;//light-green lighten-5
}
.tableText{
  text-align: center;
}
</style> 