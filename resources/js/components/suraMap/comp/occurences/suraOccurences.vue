<template>
<!-- remove v-app when integrating -->
<div class="thisChart">
  <occurenceChart v-if="loadcomplete" :fileName="fileName" :data="data" :type="type"></occurenceChart>
  <!-- <la-cartesian v-if="loadcomplete" :height="100" :width="100" :bound="[0]" autoresize :data="data">
    <la-line :continued="'continued'" dot curve prop="count"></la-line>
    <la-y-axis prop="count" :interval="500"></la-y-axis>
    <la-x-axis prop="letter" :interval="interval"></la-x-axis>
    <la-tooltip></la-tooltip>
  </la-cartesian> -->
</div>
</template> 


<script>
import occurenceTable from './table.vue'
import occurenceChart from './chart.vue'

export default {
  watch:{
    fileName(fileName){
      let url = this.getUrl()
      this.getData(url)
    } 
  },
  components:{ 
    occurenceChart,
    occurenceTable
   },
  props: ['fileName', 'type'],
  data() {
    return {
      data: [],
      loadcomplete : false,
      interval:0
    }
  },
  computed: { },
  methods:{
    getData(url){
      fetch('api/'+ url + '/' + this.fileName,{method: "GET"}) 
        .then(res => res.json())
        .then(res =>{
          this.data =  res
          this.loadcomplete =true
        }).then(function(){
          
      })
    },
    getUrl(){
      let url = ''
      if(this.type == 'words') {
        url = 'sura-words-occ-f'
        this.typeLabel = 'كلمات'

        return url
      }
      else{
        url = 'sura-letters-occ-f'
        this.typeLabel = 'أحرف'

        return url
      }
    }    
  },
  created(){ 
    let url = this.getUrl()
    this.getData(url)
  }
};
</script>



<style lang="scss"scoped>
.thisChart{
    // direction: ltr !important;
}
</style> 