<template>
<v-row>
<v-data-table
  :search="search"
  :headers="headers"
  :items="tableData"
  loading-text="جاري تحميل المواقع ... الرجاء الانتظار"
  v-if="!loading"
  class=""
  hide-default-header
  :height="300"
  :items-per-page="5"
>
  <template v-slot:item="item">
    <indexChart :numberOfWords="numberOfWords" :typeLabe="typeLabel" :type="type" :fileName="fileName" :data="item.item"></indexChart>
  </template>
  <template v-slot:top>
    <v-toolbar flat>
        <!-- <v-toolbar-title>{{suraTitle}}</v-toolbar-title> -->
        <v-spacer></v-spacer>
        <v-text-field
          mb-2
          v-model="search"
          append-icon="mdi-magnify"
          :label="typeLabel"
          single-line
          hide-details
          class="mb-1 pt-0
          rounded mt-0"
          background-color="lighten-5 mb-0"
        ></v-text-field>
    </v-toolbar>
  </template>
</v-data-table>
</v-row>
</template>

<script>

import indexChart from './chart.vue'

export default {
  watch:{
    fileName(fileName){
      let url = this.getUrl()
      this.fetchData(url)
    } 
  },
  components:{
    indexChart
  },
  props: ["fileName", 'type', 'numberOfWords'],
  data() {
    return {
      search: '',
      itemsPerPage: 10,
      headerType:'الحرف',
      headers:[
        {text:'', value:'0'},
        {text:"المواقع", value:'1'}
      ],
      typeLabel:'',
      data: [],
      tableData:[],
      loading: false
    }
  },
  computed: {
        
  },
  methods:{
    getUrl(){
      let url = ''
      if(this.type == 'words') {
        url = 'sura-words-indexes-f'
        this.typeLabel = 'ابحث عن موقع كلمة'
        this.headerType = 'الكلمة'
        return url
      }
      else{
        url = 'sura-letters-indexes-f'
        this.typeLabel = 'ابحث عن موقع حرف'
        this.headerType = 'الحرف'
        return url
      }
    },
    fetchData(url){
      fetch('api/' + url + '/' + this.fileName, { method: "GET" })
      .then(res => res.json())
      .then(res => {
        this.data = res;  
        this.getdata()
      }).finally(() => (this.loading = false));
    },
    getdata(){
      var result = Object.entries(this.data)
      for(var i=0; i<= (result).length-1; i++){
        result[i][1] = result[i][1].toString()
        result[i] = Object.assign({}, result[i]); 
      }
      this.tableData = result

      return
    }
  },
  beforeDestroy(){  },
  created(){ 
    let url = ''
    if(this.type == 'words') {
      url = 'sura-words-indexes-f'
      this.typeLabel = 'ابحث عن موقع كلمة'
      this.headerType = 'الكلمة'
    }
    else{
      url = 'sura-letters-indexes-f'
      this.typeLabel = 'ابحث عن موقع حرف'
    }
    this.fetchData(url)
   }
};
</script>



<style lang="scss" scoped>
.v-data-table{
  width:278px;
}
</style> 