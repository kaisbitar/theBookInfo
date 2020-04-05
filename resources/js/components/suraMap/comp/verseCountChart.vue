<template>
  <!-- remove v-app when integrating -->
  <div class="thisChart">
      <la-cartesian v-if="loadcomplete" :height="100" :width="300" autoresize :bound="[1][1]" :data="data">
        <la-line curve dot label="verse" animated prop="count"></la-line>
        <la-y-axis  prop="verseNumber" :interval="countInterval" ></la-y-axis>
        <la-x-axis :interval="interval"></la-x-axis>
        <la-tooltip>
          <div class="tooltip" slot-scope="props">
            <div class="suraTitle">سورة {{ fileName }}</div>
            <ul class="list"
              :key="item.label"
              v-for="item in props.actived"
            >
              <li class="verseLabel">
                <div style="border-top: 3px solid #6be6c1; min-width:19px;" class="label">آية</div>
                <div class="value"> {{ props.index+1 }}</div>
              </li>
              <li>
                <div class="label" :style="{ borderTop: '3px solid ' + item.color, marginRight: '3px' }">{{typeLabel}}</div>
                <div class="value"> {{ item.value }}</div>
              </li>
            </ul>
          </div>
        </la-tooltip>
      </la-cartesian>
  </div>
</template> 


<script>


export default {
  watch:{
    fileName(fileName){
      let url = this.getUrl()
      this.getData(url)
    } 
  },
  components:{ 
   },
  props: ['fileName', 'type'],
  data() {
    return {
      show : 'line',
      loadcomplete : false,
      data: [],
      typeLabel: '',
      verseLength: 0
    }
  },
  methods:{
    getData(url){
      fetch('api/'+ url + '/' + this.fileName,{method: "GET"}) 
        .then(res => res.json())
        .then(res =>{
          this.data =  res
          this.setData()
      })
    },    
    setData(){
      let result = Object.entries(this.data)
      let data = []
      let count = 0
      this.verseLength = (result).length-1 
      for(var i=0; i<= (result).length-1; i++){ 
        let verse = result[i]
        let verseNumber = result[i][0]
        count = result[i][1]
        let dataObj = {["count"]:count, ["verseNumber"]:verseNumber}
        data.push(dataObj)
      }
      // console.log(data)
      this.data = data
      this.loadcomplete = true
      
    },
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
  computed: { 
    interval(){
      if(this.type == 'letters'){
        return   50
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
        return 50
      }
      else{
        return 50
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

</style> 