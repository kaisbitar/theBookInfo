<template>
  <v-app>
    <v-container class="grey lighten-5 d-flex" fluid>
      <div class="quran-list">
        <v-lazy> 
          <quranIndex v-on:plySra="plySra"></quranIndex>  
        </v-lazy>  
        <v-lazy>
            <sura ref="sura" v-on:adVrsToCal="adVrsToCal"></sura>  
          </v-lazy>
      </div>
      <div class="quran-list">
      <calBrd ref="calBrd"></calBrd></div>
    </v-container>  
  </v-app>
</template> 


<script>
import quranIndex from './boardComponents/Quran/quranIndex.vue'
import sura from './boardComponents/Quran/sura.vue'
import calBrd from './boardComponents/calculations/calBrd.vue'

export default {
  components:{
    sura,
    quranIndex,
    calBrd
  },
  props: [],
  data() {
    return {
    }
  },
  computed: {},
  methods:{
    plySra(suraToPlay){      
      //receiving sura from QuranIndex and below sending to sura component
      this.$refs.sura.playThisSura(suraToPlay)
    },
    adVrsToCal(verse){
      //receiving verse from sura and below sending to calBrd component
      this.$refs.calBrd.adThsVrs(verse)
    }
  }
};
</script>



<style lang="scss">
// @import "bootstrap";
@import '~vuetify/src/styles/variables.scss';
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
</style> 