<template>
  <v-app>
      <!-- {{vrsDtl}} -->
     <template>
  <!-- <v-container fluid>
    <v-data-iterator
      :items="vrsDtlArr"
      :items-per-page.sync="itemsPerPage"
      hide-default-footer
    >
      <template v-slot:header>
        <v-toolbar
          class="mb-2"
          color="indigo darken-5"
          dark
          flat
        >
          <v-toolbar-title>This is a header</v-toolbar-title>
        </v-toolbar>
      </template>

      <template v-slot:default="props">
        <v-row>
          <v-col
            v-for="item in props.items"
            :key="item.verseIndx"
            cols="12"
            sm="6"
            md="4"
            lg="3"
          >
            <v-card>
              <v-card-title class="subheading font-weight-bold">{{ item[0] }}</v-card-title>

              <v-divider></v-divider>

              <v-list dense>
                <v-list-item>
                  <v-list-item-content>OCR:</v-list-item-content>
                  <v-list-item-content class="align-end">{{ item[0] }}: {{ item[1] }}</v-list-item-content>
                </v-list-item> -->

                <!-- <v-list-item>
                  <v-list-item-content>Fat:</v-list-item-content>
                  <v-list-item-content class="align-end">{{ item.fat }}</v-list-item-content>
                </v-list-item>

                <v-list-item>
                  <v-list-item-content>Carbs:</v-list-item-content>
                  <v-list-item-content class="align-end">{{ item.carbs }}</v-list-item-content>
                </v-list-item>

                <v-list-item>
                  <v-list-item-content>Protein:</v-list-item-content>
                  <v-list-item-content class="align-end">{{ item.protein }}</v-list-item-content>
                </v-list-item>

                <v-list-item>
                  <v-list-item-content>Sodium:</v-list-item-content>
                  <v-list-item-content class="align-end">{{ item.sodium }}</v-list-item-content>
                </v-list-item>

                <v-list-item>
                  <v-list-item-content>Calcium:</v-list-item-content>
                  <v-list-item-content class="align-end">{{ item.calcium }}</v-list-item-content>
                </v-list-item>

                <v-list-item>
                  <v-list-item-content>Iron:</v-list-item-content>
                  <v-list-item-content class="align-end">{{ item.iron }}</v-list-item-content>
                </v-list-item> -->
              <!-- </v-list>
            </v-card>
          </v-col>
        </v-row>
      </template>

      <template v-slot:footer>
        <v-toolbar
          class="mt-2"
          color="indigo"
          dark
          flat
        >
          <v-toolbar-title class="subheading">This is a footer</v-toolbar-title>
        </v-toolbar>
      </template>
    </v-data-iterator>
  </v-container> -->
  <v-row>
  <v-data-table
    :headers="lettOccHdr"
    :items="LetterOccurrences"
    class="elevation-1"
  >
  
     <!-- <template v-slot:default="props"> -->
        <!-- <td v-for="header in headers"> -->
        <!-- {{props}} -->
        <!-- </td> -->
      <!-- </template> -->
  </v-data-table>
  <v-data-table
    :headers="wrdIndxHdr"
    :items="WordIndexes"
    class="elevation-1"
  ></v-data-table>
  </v-row>
     </template>
  </v-app>
</template> 


<script>

export default {
  components:{
  },
  props: ["vrsDtl"],
  data() {
    return {
      itemsPerPage: 10,
      lettOccHdr:[
        {text:"الحرف", value:'0'},
        {text:"التكرار", value:'1'}
      ],
      wrdIndxHdr:[
        {text:"الكلمة", value:'0'},
        {text:"الموقع", value:'1'}
      ]
    }
  },
  computed: {
    WordIndexes(){
    
      var result = Object.entries(this.vrsDtl.WordIndexes)
      for(var i=0; i<= (result).length-1; i++){        
        result[i][1] = result[i][1].toString()
        result[i] = Object.assign({}, result[i]); 
      }
        return result
    },
    LetterOccurrences(){

      var result = Object.entries(this.vrsDtl.LetterOccurrences)
      for(var i=0; i<= (result).length-1; i++){        
        result[i] = Object.assign({}, result[i]); 
      }
      return result
    }    
  },
  methods:{
  },
  beforeDestroy(){
    // this.WordIndexes.destroy ()?
    this.$destroy
    // console.log(this.WordIndexes)

  },
  created(){  }
};
</script>



<style lang="scss" scoped>
.v-data-table{
  width:200px;
}
</style> 