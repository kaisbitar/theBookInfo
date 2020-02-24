<template>
  <div class="suraWrap card">
    <div class="card-header text-center suraName">سورة{{suraTitle}}</div> 
    <div class="card-body">
        <button  
          type="button" class="list-group-item list-group-item-action" 
          v-for="(verse, index) in suraMap"
          :key="index"
          v-if="index!=='SuraLettersCount'" 
        >
          {{verse.verseText}}
        </button> 
    </div>

    <v-card
      class="mx-auto"
      max-width="344"
      outlined
    >
      <v-list-item three-line>
        <v-list-item-content>
          <div class="overline mb-4">OVERLINE</div>
          <v-list-item-title class="headline mb-1">Headline 5</v-list-item-title>
          <v-list-item-subtitle>Greyhound divisely hello coldly fonwderfully</v-list-item-subtitle>
        </v-list-item-content>
  
        <v-list-item-avatar
          tile
          size="80"
          color="grey"
        ></v-list-item-avatar>
      </v-list-item>
  
      <v-card-actions>
        <v-btn text>Button</v-btn>
        <v-btn text>Button</v-btn>
      </v-card-actions>
    </v-card>
 

  </div>
</template> 

<script>
export default {
  props: [],
  data() {
    return {
      suraToPlay:[],
      suraMap:[],
      fileName: [],
      suraTitle: ''
    }
  },
  computed: {},
  methods:{
    //methods running through suraItemClicked function in board component
    playThisSura(suraToPlay){
      this.suraToPlay = suraToPlay
      this.fileName = this.suraToPlay.fileName
      this.suraTitle = this.suraToPlay.Name
      this.fetchVerses(this.suraToPlay)
    },
    fetchVerses(){
      fetch("api/sura-map/" + this.fileName, { method: "GET" })
      .then(res => res.json())
      .then(res => {
        this.suraMap = res.versesMap
      });
    }
  },
  created(){
    this.fileName = '001الفاتحة'
    this.suraTitle = 'الفاتحة'
    this.fetchVerses()
  }
};
</script>

<style>
</style>
