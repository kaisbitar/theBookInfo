<template>
<v-app>    
  <div class="quranList mb-5">
  <v-expansion-panels
    v-model="panel"
    class="quranList"
    hover
  ><v-text-field
    mb-2
    v-model="search"
    append-icon="mdi-magnify"
    label="ابحث اسم او رقم سورة"
    single-line
    hide-details
    class="mb-3  white--text"
  ></v-text-field>
    <v-expansion-panel class="quranList indigo lighten-1 mt-5 white--text" dark collapse>
      <v-expansion-panel-header fixed-header>      
        <template v-slot:default="{ open }">قاىًمة الكتاب
          <v-expansion-panel-content>
            <v-data-table
              item-key="Name"
              :dense="dense"
              loading
              :loading="loading"
              loading-text="جاري تحميل... الرجاء الانتظار"
              :headers="headers"
              fixed-header
              :items="quranIndex"
              class="elevation-1 indexTable"
              :headers-length="3"
              :height=400
              :search="search"
              @click:row="handleClick"
              hide-default-footer
              disable-pagination
            ></v-data-table>          
          </v-expansion-panel-content>
        </template>
      </v-expansion-panel-header>
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
        suraSelected: 'complete',
        headers: [
          { text: 'رقم السورة', value: 'suraIndex', class:"indigo lighten-5", width:120 },
          {
            text: 'اسم السورة',
            align: 'right',
            value: 'Name', 
            class:"indigo lighten-5", width:200
          }, 
          { text: 'عدد الايات', value: 'numberOfVerses',class:"indigo lighten-5" },{class:"indigo lighten-5", width:100}
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
        })
        .catch (function(err){
          alert(err);
        }).finally(() => (this.loading = false))
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

.indexTable.v-data-table-header{
  background: #E1BEE7; 
}
</style> 