<template>
<v-card>
    <v-data-table
      :items-per-page="400"
      :loading="loading"
      loading-text="جاري تحميل الآية... الرجاء الانتظار"
      :items="scoredVerses"
      item-key="index"
      class="elevation-2 mt-0"
      :headers-length="4"
      :headers="headers"
      fixed-header 
      height="'250'"
      width="'200'"
      @click:row="handleClick"
      hide-default-footer
    >
      <!-- Header -->
      <template v-slot:top>
      <v-toolbar flat>
          <v-toolbar-title>حساب التسعة عشر</v-toolbar-title>
          <v-spacer></v-spacer>
      </v-toolbar>
      </template>

      <!-- المجمع العددي -->
      <template v-slot:item.verseScore="item">
        <v-chip class="tableName">{{item.item.verseScore}}</v-chip>
      </template>

      <!-- Footer Tools -->
      <template v-slot:footer>
        <v-container>
          <!-- values summer component -->
          <!-- <valuesSum :scoresGroup="versesTocal"></valuesSum> -->
        </v-container>
        <v-toolbar flat>
            <v-toolbar-title>            
              <!-- <v-icon :left="true" small  color="red" v-if="tableIndex > 1"  @click="verses=[],tableIndex=1,versesTocal=[]">mdi-delete-outline</v-icon> -->
            </v-toolbar-title>
            <v-spacer></v-spacer>
        </v-toolbar>
      </template>
    </v-data-table>
  </v-card>  
</template> 


<script>

import valuesSum from './calculationComp/valuesSum.vue'

export default {
  components:{
    valuesSum
  },
  props: ['fileName','range'],
  data() {
    return {
      scoredVerses: [],
      loading: null,
      tableIndex:1,
      verseScore:0, 
      versesTocal:[],  
      ranges:0,
      headers: [
        {class:"indigo lighten-5"},
        { text: 'الآية', value: 'tableIndex',class:"indigo lighten-5", align: 'start', width:'70'},
        { text: 'السورة', value: 'Sura',class:"indigo lighten-5 pl-5" },
        { text: 'الترتيب في السورة', value: 'verseIndx',class:"indigo lighten-5 pl-5"},
        { text: 'الترتيب في المصحف', value: 'bigIndex',class:"indigo lighten-5 pl-5"},
        { text: 'الآية', value: 'verse',class:"indigo lighten-5 verseText" },
        { text: 'المجموع العددي', value: 'score',class:"indigo lighten-5"},
      ]
    }
  },
  computed: { },
  methods:{
     fetchNumericalValues(){
        fetch('api/verses-score/'+this.fileName,{method: "GET"}) 
          .then(res => res.json())
          .then(res =>{
            var result = res
            result = Object.entries(result);
            result = result.map(post => {
              return post[1]
            })
            this.scoredVerses = result
            this.find19()
  
        }).finally(() => (this.loading = false))
    },
    find19(){
      fetch('api/find-19-in-sura/'+this.fileName,{method: "GET"}) 
          .then(res => res.json())
          .then(res =>{
            this.ranges = res 
            console.log(this.ranges)
            perapareRang
        }).finally(() => (this.loading = false))
    },
    //coming from sura - async because we are calling for score
    // async adThsVrs(verse){
    //   this.verse = verse
    //   this.verseScore = await this.fetchNumericalValues()
    //   this.verse.verseScore = (await this.verseScore)
    //   this.verse.tableIndex = this.tableIndex
    //   this.tableIndex++
    //   this.verses.push(this.verse)
    //   this.versesTocal.push(this.verseScore)
    //   this.loading = false 
    // },
    
    handleClick(value){ }

  },
  computed:{  },
  created(){  
    this.fetchNumericalValues()
  }
};
</script>



<style lang="scss">

</style> 