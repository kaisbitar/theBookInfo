<template>
    <div class="suraWrap card">
      <!-- <h1>السورة</h1> -->
    <v-data-table
        :items-per-page="20"
        :loading="loading"
        loading-text="جاري تحميل الآيات ... الرجاء الانتظار"
        :items="suraMap"
        class="elevation-2 mt-0"
        :hesaders-length="4"
        :headers="headers"
        fixed-header 
        :height=550
        item-key="bigIndex"
        group-by="Sura"
        :search="search"
        @click:row="sndToCalBx"
      >
      <template v-slot:group.header="item">
        {{item.group}}
      </template>
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
      <!-- <v-data-footer></v-data-footer> -->
    </div>
</template> 

<script>
export default {
  props: [],
  data() {
    return {
      suraMap:[],
      suraToPlay:[],
      fileName: [],
      suraTitle: '',
      loading: true,
      search: '',
      model: null,
      inptLabl:'',
      bigIndex:'d-none', 
      headers: [
        {class:"indigo lighten-5"},
        { text: 'السورة', value: 'Sura',class:"indigo lighten-5 pl-5" },
        { text: 'ترتيب الآية', value: 'verseIndx',class:"indigo lighten-5 pl-5" },
        { text: 'ترتيب في المصحف', value: 'bigIndex',class:"indigo lighten-5 pl-5", align: 'd-none' },
        { text: 'الآية', value: 'verseText',class:"indigo lighten-5" },
        { text: 'عدد الكلمات', value: 'NumberOfWords',class:"indigo lighten-5" },
        { text: 'عدد الأحرف', value: 'NumberOfLetters',class:"indigo lighten-5" }
      ],footer:{class:"indigo lighten-5"}
    }
  },
  methods:{
    //methods running through plySra function in board component
    playThisSura(suraToPlay){
      this.suraToPlay = suraToPlay
      this.fileName = this.suraToPlay.fileName
      this.suraTitle = 'سورة ' + this.suraToPlay.Name 
      this.inptLabl = 'ابحث عن كلمة أو رقم في ' + this.suraTitle
      this.fetchVerses(this.suraToPlay)
    },
    playQuran(){
      this.suraToPlay = 'المصحف كاملا'
      this.fileName = 'المصحف'
      this.suraTitle = 'المصحف'
      this.inptLabl = 'ابحث عن كلمة أو رقم في المصحف'
      this.fetchVerses()
    },
    fetchVerses(){
      this.loading = true
      fetch("api/sura-map-f/" + this.fileName, { method: "GET" })
      .then(res => res.json())
      .then(res => {
        if(this.fileName =='المصحف'){
          this.suraMap = res
        }
        else{
          this.suraMap = res.versesMap;      
        }
        //----
        //convert obejct to array and then mapping stuff..
        this.suraMap = Object.entries(this.suraMap);
        this.suraMap = this.suraMap.map(post => {
          return post[1]
        })
        //---
        this.indsxSra()
        return
      }).catch (function(err){
          alert(err);
      }).finally(() => (this.loading = false));
    },
    indsxSra() {
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
  },
  created(){
    this.fileName = 'المصحف'
    this.suraTitle = 'المصحف'
    this.inptLabl = 'ابحث عن كلمة أو رقم في ' + this.suraTitle
    this.fetchVerses()
  },
  computed: { 
    computedHeaders () {
      return this.headers.filter()  
    }
   },

};
</script>

<style>
</style>
