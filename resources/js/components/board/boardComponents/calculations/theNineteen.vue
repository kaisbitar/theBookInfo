<template>
  <v-app>
    <!-- <h1>الحسابات</h1> -->
    <v-data-table
    :headers="headers"
    :items="headers"
    :single-expand="singleExpand"
    :expanded.sync="expanded"
    item-key="name"
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
  </v-data-table>
    <!-- <v-data-table
      :items-per-page="400"
      loading
      :loading="loading"
      loading-text="جاري تحميل... الرجاء الانتظار"
      :items="verses"
      class="elevation-2 mt-0"
      :hesaders-length="4"
      :headers="headers"
      :single-expand="singleExpand"
      :expanded.sync="expanded"
      show-expand
      fixed-header 
      :height=400
      @click:row="handleClick"
    >
      <template v-slot:top>
      <v-toolbar flat>
          <v-toolbar-title>حساب التسعة عشر</v-toolbar-title>
          <v-spacer></v-spacer>
      </v-toolbar>
      </template>
      <template  v-slot:expanded-item="vrsDtal">
        <td  :colspan="600" class=" lighten-5">
          <v-simple-table
          >
            <template v-slot:default>
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Calories</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="dtl in vrsDtal.item">
                  {{dtl}}
                </tr>
              </tbody>
            </template>
          </v-simple-table>
        </td>
      </template>        
    </v-data-table> -->
    <div class="my-2">
      <v-btn small color="error" v-if="verses != []"  @click="verses=[]">مسح</v-btn>
    </div>
  </v-app>
</template> 


<script>

export default {
  components:{
  },
  props: [],
  data() {
    return {
        verses: [],
        expanded:[],
        loading: null,
        index:0,
        vrsDtal: [],
        WordIndexes:[],
                singleExpand: false,

        headers: [
        {class:"indigo lighten-5"},
        { text: 'رقم الآية', value: 'index',class:"indigo lighten-5 pl-5" },
        { text: 'رقم الآية', value: 'index',class:"indigo lighten-5 pl-5" },
        { text: 'الآية', value: 'verseText',class:"indigo lighten-5" },
        { text: 'عدد الكلمات', value: 'NumberOfWords',class:"indigo lighten-5" },
        { text: 'عدد الأحرف', value: 'NumberOfLetters',class:"indigo lighten-5" }
      ]
    }
  },
  computed: {},
  methods:{
    adThsVrs(verse){
        this.verses.push(verse)
        this.loading = false
    },
    handleClick(value){
    }
  }
};
</script>



<style lang="scss">
// @import "bootstrap";
// @import '~vuetify/src/styles/variables.scss';
.v-application{
  // font-family: $body-font-family;
}
 .v-application--wrap {
    min-height: 50px !important;
} 
.qura-list .v-application {
  max-width: 700px;
}
</style> 