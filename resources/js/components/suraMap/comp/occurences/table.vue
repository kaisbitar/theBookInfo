<template>
<!-- remove v-app when integrating -->
<div class="thisChart">
  <la-cartesian v-if="loadcomplete" :height="100" :width="100" :bound="[0]" autoresize :data="data">
    <la-line :continued="'continued'" dot curve prop="count"></la-line>
    <la-y-axis prop="count" :interval="500"></la-y-axis>
    <la-x-axis prop="letter" :interval="interval"></la-x-axis>
    <la-tooltip></la-tooltip>
  </la-cartesian>
</div>
</template> 


<script>


export default {
  components:{ 
   },
  props: ['fileName', 'type'],
  data() {
    return {
      data:[],
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
          this.setData()
          this.loadcomplete =true
        }).then(function(){
          
        })
    },    
    setData(){
      var result = this.data
      var records = Object.keys(result)
      var counts = Object.values(result)
      var readyForChart = []
      for(var i=0; i<= (counts.length-1); i++){ 
        let record = records[i]
        let count = counts[i]
        let countObj = {["letter"]:record, ["count"]:count}
        readyForChart.push(countObj)
      }
      this.setInterval()
      this.data = readyForChart

      return
    },
    setInterval(){
      if(this.type == 'letters'){
        this.interval = 1
      }
      else{
        let  precentage = (this.data.length/98)*100
        this.interval = 50
        Math.floor(precentage)
      }
    }
  },
  created(){  
    let url = ''
    if(this.type == 'words') {
      url = 'sura-words-occ-f'
      this.typeLabel = 'كلمات'
    }
    else{
      url = 'sura-letters-occ-f'
      this.typeLabel = 'أحرف'
    }
    this.getData(url)
  }
};
</script>



<style lang="scss"scoped>
.thisChart{
    // direction: ltr !important;
}
</style> 