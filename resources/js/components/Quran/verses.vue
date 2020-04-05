<template>
  <v-app>
    <!-- <h1>الحسابات</h1> -->
    <!-- <v-data-table
      :headers="headers"
      :items="verses"
      :single-expand="singleExpand"
      :expanded.sync="expanded"
      item-key="verseIndx"
      show-expand
      class="elevation-1"
  >
    <template v-slot:top>
      <v-toolbar flat>
        <v-toolbar-title>Expandable Table</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-switch v-model="singleExpand" label="Single expand" class="mt-2"></v-switch>
      </v-toolbar>
    </template>
    <template v-slot:expanded-item="{ headers }">
      <td :colspan="headers.length">Peek-a-boo!</td>
    </template>
  </v-data-table> -->
    <v-data-table
      :items-per-page="400"
      loading
      :loading="loading"
      loading-text="جاري تحميل... الرجاء الانتظار"
      :items="verses"
      item-key="verseIndx"
      class="elevation-2 mt-0"
      :hesaders-length="4"
      :headers="headers"
      :single-expand="singleExpand"
      show-expand
      fixed-header 
      @click:row="handleClick"
    >
      <template v-slot:top>
      <v-toolbar flat>
          <v-toolbar-title>الآيات</v-toolbar-title>
          <v-spacer></v-spacer>
      </v-toolbar>
      </template>
      <!-- Expanded items  (tables) -->
      <template  v-slot:expanded-item="vrsDtl">
        <td  :colspan="600" class=" lighten-5">
          <v-simple-table
          >
          <!-- verseDetails.vue file -->
            <template v-slot:default>
              <verseDetails :vrsDtl="vrsDtl.item"></verseDetails>
              
            </template>
            
          </v-simple-table>
        </td>
      </template>  
       <template slot="items" slot-scope="props">
        <td>
          <v-btn
            
          >CLICKSSS</v-btn>
        </td>
      </template>      
    </v-data-table>
    <div class="my-2">
      <v-btn small color="error" v-if="verses != []"  @click="verses=[]">مسح</v-btn>
    </div>
  </v-app>
</template> 


<script>

import verseDetails from  '../board/boardComponents/calculations/calculationComp/verseDetails.vue'
export default {
  components:{
    verseDetails
  },
  props: [],
  data() {
    return {
      verses: [],
      expanded:[],
      loading: null,
      tableIndex:0,
      singleExpand: true,
      headers: [
        {class:"indigo lighten-5"},
        { text: 'رقم الآية', value: 'index',class:"indigo lighten-5 pl-5" ,align: 'start'},
        { text: 'الآية', value: 'verseText',class:"indigo lighten-5" },
        { text: 'عدد الكلمات', value: 'NumberOfWords',class:"indigo lighten-5" },
        { text: 'عدد الأحرف', value: 'NumberOfLetters',class:"indigo lighten-5" },
        { text: '', value: 'data-table-expand',class:"indigo lighten-5"},
      ]
    }
  },
  computed: {  },
  methods:{
    adThsVrs(verse){
        verse["tableIndex"] = this.tableIndex
        this.tableIndex++
        this.verses.push(verse)
        this.loading = false
        this.expanded = []
    },
    handleClick(value){
      console.log(value)
    }
  }
};
</script>



<style lang="scss">

</style> 