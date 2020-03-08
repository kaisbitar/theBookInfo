<template>
  <v-app>
    <!-- <h1>الحسابات</h1> -->
    <v-data-table
    :items-per-page="400"
    loading
    :loading="loading"
    loading-text="جاري تحميل... الرجاء الانتظار"
    :items="verses"
    class="elevation-2 mt-0"
    :hesaders-length="4"
    :headers="headers"
    :single-expand="false"
    :expanded.sync="expanded"
    show-expand
    fixed-header 
    :height=400
    @click:row="handleClick"
    ><template v-slot:top>
      <v-toolbar flat>
        <v-toolbar-title>الآيات</v-toolbar-title>
        <v-spacer></v-spacer>
      </v-toolbar>
      </template>
      <template  v-slot:expanded-item="vrsDtal">
        <td  :colspan="600" class="indigo lighten-5">
          <tr><v-data-table :items="expanded"></v-data-table>
          </tr>
        </td>
      </template>        
    </v-data-table>
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
        headers: [
        {class:"indigo lighten-5"},
        { text: 'رقم الآية', value: 'index',class:"indigo lighten-5 pl-5" },
        { text: 'رقم الآية', value: 'index',class:"indigo lighten-5 pl-5" },
        { text: 'الآية', value: 'verseText',class:"indigo lighten-5" },
        { text: 'عدد الكلمات', value: 'NumberOfWords',class:"indigo lighten-5" },
        { text: 'عدد الأحرف', value: 'NumberOfLetters',class:"indigo lighten-5" },
        // { text: 'ورود الكلمات', value: 'WordOccurrences',class:"indigo lighten-5" },
        // { text: 'ورود الأحرف', value: 'LetterOccurrences',class:"indigo lighten-5" },
        // { text: 'ترتيب الكلمات', value: 'WordIndexes',class:"indigo lighten-5" },
        // { text: 'ترتيب الحروف', value: 'LetterIndexes',class:"indigo lighten-5" },
        // { text: 'القيمة العددية', value: 'LetterIndexes',class:"indigo lighten-5" },
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
      console.log(value)
      this.vrsDtal = value
      console.log(this.vrsDtal)
      this.vrsDtal = Object.entries(this.vrsDtal);
    }
  }
};
</script>



<style lang="scss">
// @import "bootstrap";
@import '~vuetify/src/styles/variables.scss';
.v-application{
  font-family: $body-font-family;
}
 .v-application--wrap {
    min-height: 50px !important;
} 
.qura-list .v-application {
  max-width: 700px;
}
</style> 