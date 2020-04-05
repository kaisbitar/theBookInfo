<template>
<!-- remove v-app when integrating -->
<div class="thisChart">
  <h4>{{itemLabel}}</h4>
  <la-cartesian :bound="[1][1]" :height="100" :width="20" autoresize :data="chartData">
    <la-line animated  dot curve prop="count"></la-line>
    <la-y-axis   :interval="countInterval"></la-y-axis>
    <la-x-axis :interval="interval"></la-x-axis>
    <la-tooltip>
          <div class="tooltip" slot-scope="props">
            <div class="suraTitle">سورة {{ fileName }}</div>
            <ul class="list"
              :key="item.label"
              v-for="item in props.actived"
            >
              <li v-if="item.value !== 0" class="verseLabel">
                <div style="border-top: 3px solid #6be6c1; min-width:19px;" class="label">الموقع</div>
                <div class="value"> {{ item.value }}</div>
              </li>

              <li v-else class="verseLabel">
                <div style="border-top: 3px solid #6be6c1; min-width:19px;" class="label">الموقع</div>
                <div class="value"> {{ item.value }}</div>
              </li>

              <li v-if="item.value !==  numberOfWords && item.value !== 0">
                <div class="label" :style="{ borderTop: '3px solid ' + item.color, marginRight: '3px' }">{{typeLabel}}</div>
                <div class="value"> {{ itemLabel }}</div>
              </li>
              <li v-else-if="item.value !== 0">
                <div class="label" :style="{ borderTop: '3px solid ' + item.color, marginRight: '3px' }">آخر كلمة في السورة</div>
              </li>
              <!-- <li v-else-if="item.value == 0">
                <div class="label" :style="{ borderTop: '3px solid ' + item.color, marginRight: '3px' }">أول كلمة في السورة</div>
              </li> -->

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
  props: ['fileName','typeLabel','data', 'type', 'numberOfWords'],
  data() {
    return {
      loadcomplete : false,
      itemLabel:''
      // chartData: []
    }
  },
  methods: {   },
  computed:{    
    chartData(){
      var result = this.data
      this.itemLabel = result[0]
      var counts = Object.values(result)
      var readyForChart = []
      var countArray = counts[1].split(',');
      
      for(var i=0; i<= (countArray.length); i++){
        let count = countArray[i]
        let countObj = {["count"]:count}
        readyForChart.push(countObj)
      }
      var numberOfWords = this.numberOfWords
      let verseNumber = {["count"]:numberOfWords}
      readyForChart.push(verseNumber)
      readyForChart.unshift({["count"]:0});
      this.loadcomplete = true
      
      return readyForChart
    },
    interval(){
      if(this.type == 'letters'){
        return   25
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
        return 5
      }
      else{
        return 100
      }
    }
  },
  created(){  
    
    // this.setData()
  }
};
</script>



<style lang="scss"scoped>
.thisChart{
    // direction: ltr !important;
}
</style> 