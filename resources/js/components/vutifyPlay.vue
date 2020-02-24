<template>
<v-app>
  <v-data-table
    item-key="Name"
    :dense="dense"
    loading
    :loading="loading"
    loading-text="جاري تحميل... الرجاء الانتظار"
    :headers="headers"
    :items="quranIndex"
    :headers-length="3"
    :height=200
  ></v-data-table>
  <v-col cols="6" md="3">
        <v-switch v-model="dense" label="تصغير/تكبير" class="mx-4"></v-switch>
      </v-col>
  </v-app>
</template>

<script>
  export default {
    data () {
      return {   
        quranIndex: [],
        headers: [
          {
            text: 'اسم السورة',
            align: 'right',
            value: 'Name',
          },
          { text: 'رقم السورة', value: 'suraIndex' },
          { text: 'عدد الايات', value: 'numberOfVerses' }
        ],
        dense: true,
        loading: true
      }
    },
    methods:{
      fetchQuranIndex(){
        fetch('api/quran-index',{method: "GET"})
        .then(res => res.json())
        .then(res =>{
          this.quranIndex = res
          this.loading = false
        })
        .catch (function(err){
          alert(err);
        });
      }
    },
    created(){
      this.fetchQuranIndex()
    }
  }
</script>


<style lang="scss">
  @import '~vuetify/src/styles/variables.scss';
.v-application{
  font-family: $body-font-family;
}
</style> 

<!-- 
  <v-simple-table 
  :dense="dense"
  fixed-header 
  height="300px">
    <template v-slot:default>
      <thead>
        <tr>
          <th class="text-right">اسم السورة</th>
          <th class="text-right">رقم السورة</th>
          <th class="text-right">عدد الايات</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in quranIndex" :key="item.name">
          <td>{{ item.Name }}</td>
          <td>{{ item.suraIndex }}</td>
          <td>{{ item.numberOfVerses }}</td>
        </tr>
      </tbody>
    </template>
  </v-simple-table> -->