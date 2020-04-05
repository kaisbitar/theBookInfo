<template>
  <v-app>
      <!-- {{vrsDtl}} -->
    <template>
      <v-row>
      <v-data-table
        :headers="lettOccHdr"
        :items="LetterOccurrences"
        class="elevation-1"
      >
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
  beforeDestroy(){  },
  created(){  }
};
</script>



<style lang="scss" scoped>
.v-data-table{
  width:200px;
}
</style> 