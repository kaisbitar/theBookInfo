<template>
  <div class="IndexWrap">
    <div class="indexHeader">
      <b-button class="indexToggle btn btn-primary" focus-target="suraSearch" type="button" data-toggle="collapse" data-target="#quranIndex" aria-expanded="false" aria-controls="quranIndex">
          فتح - اغلاق
      </b-button> 
        </div>     
      <div class="collapse show" id="quranIndex" >
        <b-input autofocus 
          type="text"
          id="suraSearch"
          v-model="search"
          placeholder="ابحث عن سورة" 
        />
        <div v-if="loading" class="container spinner-box">
          <b-spinner label="Small Spinner" variant="info"></b-spinner>
        </div>
        <div v-if="!loading" class="list-group">
          <button  
            type="button" class="list-group-item list-group-item-action" 
            v-for="(indexItem, index) in filteredIndex" 
            :key="indexItem.suraIndex"
            @click="activateIndex(indexItem)"
            :class="{active: indexActive == indexItem.suraIndex}"
          >
            <div class="indexItemWrap" v-if="indexItem.fileName !== 'complete'">
              <div class="suraName"> سورة {{indexItem.Name}}</div>
              <div class="infoItem suraNumber">
                <small class="theText">سورة</small>
                <span class="theNumber">{{indexItem.suraIndex}}</span>
              </div> 
              <div class="infoItem verseNumber">
                <small class="theText">اية</small>
                <span class="theNumber">{{indexItem.numberOfVerses}}</span>
              </div>
            </div>
            <div class="completeQuranItem" v-else>
              <div class="">المصحف كاملا</div>
              <div class="infoItem verseNumber largeNumber">
                <small class="theText">اية</small>
                <span class="theNumber">{{indexItem.numberOfVerses}}</span>
              </div>
            </div>
          </button>
        </div>
    </div>           
  </div>
</template> 


<script>
import sura from './sura.vue'

export default {
  props: [],
  data() {
    return {
      quranIndex: [],
      indexActive: 0,
      loading: true,
      search: '',
      suraToPlay: []
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
    activateIndex(indexItem, fileName){
      this.indexActive = indexItem 
      this.suraToPlay = indexItem

      //tell board
      // console.log(this.$emit('suraItemClicked'));
      this.$emit('suraItemClicked', this.suraToPlay)
    }
  },
  computed: {
    filteredIndex(){
      if(!this.search) {
            return this.quranIndex;
        }
      return this.quranIndex.filter(
         post => 
      {
        //CHECK FOR NUMBERS
        if(/\d/.test(this.search)){
          this.search = parseInt(this.search)
          let searchString = this.search.toString()
          let indexString = post.suraIndex.toString()
            console.log(search)    
          if(searchString.includes(post.suraIndex)){
            return post.suraIndex
          }
        }
        return post.Name.includes(this.search) 
      })
    }
  },
  created(){
    this.fetchQuranIndex();
  }
};
</script>

<style scoped lang="scss">
.highlightText{
  background: yellow;
}
.suraName {
  margin-top: 5px;
}
.indexToggle{
  margin-bottom: 9px;
  margin-left: auto;
  margin-right: auto;
  display: block;
}
.list-group {
  max-height: 618px;
  overflow-y: scroll;
}
.IndexWrap {
    min-width: 270px;
}
.infoItem{
  display: inline-grid;
  margin: 3px;
  width: 31px;
}
.indexItemWrap {
  display: grid;
  grid-template-columns: 51% 17% 17%;;
}
.theNumber{
  margin-top:2px;
}
input#suraSearch {
  margin-bottom: 6px;
}
button.list-group-item.list-group-item-action{
  padding: 6px;
}
</style>
