<template>
    <v-container class="suraWrap card ">
      <!-- <h1>السورة</h1> -->
      
    <v-card>
      <v-data-table
          :items-per-page="400"
          :loading="loading"
          loading-text="جاري تحميل الآيات ... الرجاء الانتظار"
          :items="suraMap"
          class="elevation-2 mt-0 overflow-y-auto"
          :hesaders-length="4"
          :headers="headers"
          fixed-header 
          height="400"
          item-key="bigIndex"
          group-by="Sura"
          :search="search"
          @click:row="sndToCalBx"
          dense
        >    
        <!-- group by customization -->
        <!-- <template v-slot:group.header="item">
        </template> -->
       
       
        <!-- rows details -->
        
        <template v-slot:item="item">
          <tr :class="{addedToCal:added === item.item.tableIndex}" @click="sndToCalBx(item.item)">
            <td><div class="tableNumber">{{item.item.bigIndex}}</div></td>
            <td><div class="tableNumber">{{item.item.verseIndx}}</div></td>
            <td><div class="tableText">{{item.item.verseText}}</div></td>
            <td><div class="tableNumber">{{item.item.NumberOfWords}}</div></td>
            <td><div class="tableNumber">{{item.item.NumberOfLetters}}</div></td>
          </tr>
        </template> 

               <!-- 
          Only title and search bar down here
        -->
        <template v-slot:top>
          <v-toolbar flat>
              <v-toolbar-title>{{suraTitle}}</v-toolbar-title>
              <v-spacer></v-spacer>
              <v-text-field
                mb-2
                v-model="search"
                append-icon="mdi-magnify"
                :label="inptLabl"
                single-line
                hide-details
                class="mb-1 pt-0
                rounded mt-0"
                autofocus
                background-color="lighten-5 mb-0"
              ></v-text-field>
          </v-toolbar>
        </template>
        
      </v-data-table>
    </v-card>
    </v-container>
</template> 

<script>
export default {
  watch:{
    fileName(){
      this.playThisSura()
    }
  },
  props: ['fileName'],
  data() {
    return {
      suraMap:[],
      suraToPlay:[],
      suraTitle: '',
      loading: true,
      search: '',
      inptLabl:'',
      added:0,
      headers: [
        { text: 'السورة', value: 'Sura',class:"indigo lighten-5 pl-5" },
        { text: 'ترتيب في السورة', value: 'verseIndx',class:"indigo lighten-5 pl-5" },
        { text: 'ترتيب في المصحف', value: 'bigIndex',class:"indigo lighten-5 pl-5",},
        { text: 'الآية', value: 'verseText',class:"indigo lighten-5" },
        { text: 'عدد الكلمات', value: 'NumberOfWords',class:"indigo lighten-5" },
        { text: 'عدد الأحرف', value: 'NumberOfLetters',class:"indigo lighten-5" }
      ]
    }
  },
  methods:{
    //methods running through plySra function in board component
    playThisSura(){
      this.fetchVerses(this.fileName)
    },
    playQuran(){
      this.suraToPlay = 'المصحف كاملا'
      this.fileName = 'المصحف_fe'
      this.suraTitle = 'المصحف'
      this.inptLabl = 'ابحث عن كلمة أو رقم في المصحف'
      this.fetchVerses()
    },
    fetchVerses(){
      this.loading = true
      fetch("api/sura-map-f/" + this.fileName, { method: "GET" })
      .then(res => res.json())
      .then(res => {
        this.suraMap = res.versesMap;  
        this.prepareData()        
      }).finally(() => (this.loading = false));
    },
    prepareData(){
      this.suraTitle = 'سورة ' + this.suraMap[1].Sura 
      this.inptLabl = 'ابحث عن كلمة أو رقم في ' + this.suraTitle
      //convert obejct to array and then mapping stuff..
      this.suraMap = Object.entries(this.suraMap);
      this.suraMap = this.suraMap.map(post => {
        return post[1]
      })
      //---
      this.indexSura()
      return
    },
    indexSura() {
     this.suraMap = this.suraMap.map(
        (items, index) => ({
          ...items,
          bigIndex: index + 1  
        }
      ))
      this.loading = false
    },
    sndToCalBx(verse){
      //run method in board to add verse to the calculation box
      this.$emit('adVrsToCal', verse)
    },
    onScroll(value){
    }
  },
  created(){
    this.playThisSura()

  },
  computed: { },

};
</script>

<style>
.tableText{
  /* border-bottom: 1px solid #eaeaea !important; */
  padding-bottom: 3%;
  padding-top: 3%;
}
.addedToCal{
  background: orange;
}
</style>
