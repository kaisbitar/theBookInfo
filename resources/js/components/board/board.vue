<template>
  <div>
    <quranIndex fixed-header class="quranList" v-on:suraItemClicked="suraItemClicked"></quranIndex>    
    <sura ref="sura"></sura>
  </div>
  
</template> 


<script>
import quranIndex from './boardComponents/Quran/quranIndex.vue'
import sura from './boardComponents/Quran/sura.vue'

export default {
  components:{
    sura,
    quranIndex
  },
  props: [],
  data() {
    return {
    }
  },
  computed: {},
  methods:{
    suraItemClicked(suraToPlay){      
      this.$refs.sura.playThisSura(suraToPlay)
    }
  }
};
</script>



<style lang="scss">
@import "bootstrap";
@import '~vuetify/src/styles/variables.scss';
.v-application{
  font-family: $body-font-family;
}
 .v-application--wrap {
    min-height: 50px !important;
} 
.qura-list .v-application {
  max-width: 700px;
}
</style> 