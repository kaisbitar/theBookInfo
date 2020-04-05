<template>
  <v-card
    class="overflow-hidden"
    >
    <v-data-table
      item-key="Name"
      :loading="loading"
      loading-text="جاري تحميل السور... الرجاء الانتظار"
      :headers="headers"
      fixed-header 
      :items="quranIndex"
      class="elevation-1"
      :search="search"
      @click:row="activateSura"
      hide-default-footer
      disable-pagination
      height="445"
    ><template v-slot:top>
        <v-toolbar flat>
          <!-- <v-toolbar-title>القائمة</v-toolbar-title> -->
          <v-spacer></v-spacer>
          <v-text-field
            mb-2
            v-model="search"
            append-icon="mdi-magnify"
            label="ابحث عن سورة أو رقم"
            single-line
            hide-details
            class="mb-3  white--text"
          ></v-text-field>
          <!-- <v-spacer></v-spacer>
          أو
          <v-spacer></v-spacer> -->
          <!-- <v-tooltip dark color="red" bottom>
            <template v-slot:activator="{ on }">
              <v-btn color="warning" small dark v-on="on" @click="activateQuran()">حمّل المصحف</v-btn>
            </template>
            <span> بحاجة انترنت سريع</span>
          </v-tooltip> -->
        </v-toolbar>
      </template>  
    </v-data-table>          
  </v-card>  
</template>

<script>
  export default {
    data () {
      return {   
        quranIndex: [],
        search:'',
        headers: [
          { text: 'رقم السورة', value: 'suraIndex', class:"indigo lighten-5", 
            // width:120 
          },
          {
            text: 'اسم السورة',
            align: 'right',
            value: 'Name', 
            class:"indigo lighten-5", 
            // width:200
          }, 
          { text: 'عدد الآيات', value: 'numberOfVerses',class:"indigo lighten-5" }
          // { text: 'عدد الكلمات', value: 'NumberOfWords',class:"indigo lighten-5" },
          // { text: 'عدد الأحرف', value: 'NumberOfLetters',class:"indigo lighten-5" },
          // {class:"indigo lighten-5", width:100}
        ],
        loading: true  
      }
    },
    methods:{
      fetchQuranIndex(){
        fetch('api/quran/quranIndex',{method: "GET"}) 
        .then(res => res.json())
        .then(res =>{
          this.quranIndex = res
        })
        .catch (function(err){
          alert(err);
        }).finally(() => (this.loading = false))
      },
      activateSura(activateSura){
        //send sura to Board to play the sura in the Sura component
        this.$emit('plySra', activateSura)
        this.$emit('playSura', activateSura)
      },
      activateQuran(){
        this.$emit('plySra', 'المصحف')
      },
    },
    created(){
      this.fetchQuranIndex()
    }
  }
</script>


<style lang="scss" scoped>  
</style> 