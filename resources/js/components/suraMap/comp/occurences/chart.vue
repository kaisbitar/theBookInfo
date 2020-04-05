<template>
<!-- remove v-app when integrating -->
<div class="thisChart">
  <la-cartesian :bound="[0][1]" :height="100" :width="300" autoresize :data="chartData">
    <la-line animated dot curve prop="count"></la-line>
    <la-y-axis  prop="count" :interval="countInterval"></la-y-axis>
    <la-x-axis prop="record" :interval="interval"></la-x-axis>
    <la-tooltip>
          <div class="tooltip" slot-scope="props">
            <div class="suraTitle">سورة {{ fileName }}</div>
            <ul class="list"
              :key="item.label"
              v-for="item in props.actived"
            >
              <li class="verseLabel">
                <div style="border-top: 3px solid #6be6c1; min-width:19px;" class="label">التكرار</div>
                <div class="value"> {{ item.value }}</div>
              </li>
              <li>
                <div class="label" :style="{ borderTop: '3px solid ' + item.color, marginRight: '3px' }">{{typeLabel}}</div>
                <div class="value"> {{ props.label }}</div>
              </li>
            </ul>
          </div>
        </la-tooltip>
  </la-cartesian>
</div>
</template> 


<script>


export default {
  components:{ 
   },
  props: ['fileName','data', 'type'],
  data() {
    return {
      loadcomplete : false,
      // chartData: []
    }
  },
  methods: { 
    getUrl(){
      let url = ''
      if(this.type == 'words') {
        url = 'verses-number-of-words-f'
        this.typeLabel = 'كلمات'

        return url
      }
      else{
        url = 'verses-number-of-letters-f'
        this.typeLabel = 'أحرف'

        return url
      }
    }
  },
  computed:{    
    chartData(){
      var result = this.data
      var records = Object.keys(result)
      var counts = Object.values(result)
      var readyForChart = []
      for(var i=0; i<= (counts.length-1); i++){ 
        let record = records[i]
        let count = counts[i]
        let countObj = {["record"]:record, ["count"]:count}
        readyForChart.push(countObj)
      }
      this.loadcomplete = true
      
      return readyForChart
    },
    interval(){
      if(this.type == 'letters'){
        return   5
      }
      else{
        var data = Object.values(this.data)
        var count = data.length
        let  precentage = Math.floor((count*20)/100)
        return precentage
      }
    },
    countInterval(){
      if(this.type == 'words'){
        return 250
      }
      else{
        return 15
      }
    }
  },
  created(){  
    let url = ''
    if(this.type == 'words') {
      url = 'sura-words-occ-f'
      this.typeLabel = 'الكلمة'
    }
    else{
      url = 'sura-letters-occ-f'
      this.typeLabel = 'الحرف'
    }
    // this.setData()
  }
};
</script>



<style lang="scss"scoped>
.thisChart{
    // direction: ltr !important;
}
</style> 