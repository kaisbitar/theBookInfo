<template>
<v-app>    
  <div class="quranList">
  <v-expansion-panels
  absolute 
    multiple         
    v-model="panel"
    class="quranList"
  >
    <v-expansion-panel class="quranList">
      <v-expansion-panel-header fixed-header>قاىًمة الكتاب</v-expansion-panel-header>
      <v-expansion-panel-content>
        <v-text-field
          mb-2
          v-model="search"
          append-icon="mdi-magnify"
          label="ابحث اسم او رقم سورة"
          single-line
          hide-details
        ></v-text-field>
        <v-data-table
          item-key="Name"
          :dense="dense"
          loading
          :loading="loading"
          loading-text="جاري تحميل... الرجاء الانتظار"
          :headers="headers"
          fixed-header
          :items="quranIndex"
          class="elevation-1"
          :headers-length="3"
          show-select
          :height=400
          :search="search"
          @click:row="handleClick"
        ></v-data-table>          
      </v-expansion-panel-content>
    </v-expansion-panel>
  </v-expansion-panels>

  </div>
  <!-- <v-simple-table 
    :dense="dense"
    fixed-header
    loading
    loading-text="جاري تحميل... الرجاء الانتظار" 
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
  </v-simple-table>  -->
  </v-app>
</template>

<script>
  export default {
    data () {
      return {   
        quranIndex: [],
        search:'',
        panel: [0],
        suraSelected: '001الفاتحة',
        headers: [
          {
            text: 'اسم السورة',
            align: 'right',
            value: 'Name',
          }, 
          { text: 'رقم السورة', value: 'suraIndex' },
          { text: 'عدد الايات', value: 'numberOfVerses' }
        ],
        dense:false,
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
      },
      activateSura(value){
        // this.$emit('suraItemClicked', row)
        console.log(value)
      },
      handleClick(value) {
        this.$emit('suraItemClicked', value)
        console.log(value)
        },
    },
    created(){
      this.fetchQuranIndex()
    }
  }
</script>


<style lang="scss" scoped>  

</style> 