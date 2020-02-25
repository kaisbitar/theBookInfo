<template>
  <v-app>
    <div class="suraWrap card">
      <v-autocomplete
        :items="suraWithIndex"
        color="red"
        item-text="verseText"
        label="ابحث عن آية"
        return-object
        cache-items
      ></v-autocomplete>
      <!-- <v-text-field
        mb-2
        v-model="search"
        append-icon="mdi-magnify"
        label="ابحث عن آية او كلمة"
        single-line
        hide-details
        class="mb-3"
      ></v-text-field> -->
      <v-data-table
        loading
        :loading="loading"
        loading-text="جاري تحميل... الرجاء الانتظار"
        :items="suraWithIndex"
        class="elevation-2"
        :headers-length="4"
        :headers="headers"
        fixed-header 
        :height=400
        :search="search"
        @click:row="handleClick"
      ></v-data-table>
    </div>
  </v-app>
</template> 

<script>
export default {
  props: [],
  data() {
    return {
      suraMap:[],
      suraToPlay:[],
      fileName: [],
      suraIndex: 1,
      suraTitle: '',
      loading: true,
      search: '',
      model: null,
      autoSearch: null,
      headers: [
        { text: 'رقم الآية', value: 'index' },
        { text: 'الآية', value: 'verseText' },
        { text: 'عدد الكلمات', value: 'NumberOfWords' },
        { text: 'عدد الأحرف', value: 'NumberOfLetters' }
      ],
    }
  },
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
        this.suraMap = res.versesMap;

        //----
        //some obejct to array and then mapping stuff..
        this.suraMap = Object.entries(this.suraMap);
        this.suraMap = this.suraMap.map(post => {
          return post[1]
        })
        //---
        this.loading = false
      });
    },
    handleClick(value){
      console.log(value)
    },
  },
  created(){
    this.fileName = 'complete'
    this.suraTitle = 'الفاتحة'
    this.fetchVerses()
  },
  computed: {
    
    suraWithIndex() {
      return this.suraMap.map(
        (items, index) => ({
          ...items,
          index: index + 1
        }))
    },
    fields () {
      if (!this.model) return []

      return Object.keys(this.model).map(key => {
        return {
          key,
          value: this.model[key] || 'n/a',
        }
      })
    },
    items () {
      return this.entries.map(entry => {
        const Description = entry.Description.length > this.descriptionLimit
          ? entry.Description.slice(0, this.descriptionLimit) + '...'
          : entry.Description

        return Object.assign({}, entry, { Description })
      })
    },
  },

  watch: {
    autoSearch (val) {
      // Items have already been loaded
      if (this.items.length > 0) return

      // Items have already been requested
      if (this.isLoading) return

      this.isLoading = true

      // Lazily load input items
      fetch('https://api.publicapis.org/entries')
        .then(res => res.json())
        .then(res => {
          const { count, entries } = res
          this.count = count
          this.entries = entries
        })
        .catch(err => {
          console.log(err)
        })
        .finally(() => (this.isLoading = false))
    },
  },

};
</script>

<style>
</style>
