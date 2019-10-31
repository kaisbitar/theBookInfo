<template>
  <div>
    <div>
      <b-dropdown
        size="lg"
        text="Large"
        class="m-2"
      >
        <b-dropdown-item-button
          v-for="(suraIndexItem, index) in surasList"
          v-bind:key="index"
          @click.prevent="fetchVerses(suraIndexItem.fileName)"
        >
          {{suraIndexItem.suraName}} {{suraIndexItem.suraIndex}}
        </b-dropdown-item-button>
      </b-dropdown>
      <b-dropdown
        v-if="versesOn"
        size="lg"
        text="Large"
        class="m-2"
      >
        <b-dropdown-item-button
          v-for="(verse, index) in verses"
          v-bind:key="index"
          v-on:click="putVerseToCal(index, verse)"
        >
          {{index}}- {{verse.verseText}}
        </b-dropdown-item-button>
      </b-dropdown>
    </div>
    <div
      class="card"
      v-if="calBox"
    >
     <div class="badge badge-warning" v-for="verseToCal in versesToCal">{{(verseToCal)}}</div> 
    </div>
  </div>
</template>

<style scoped>
body {
  direction: ltr;
}
</style>

<script>
import Sura from "./Sura.vue";

export default {
  data() {
    return {
      surasList: [],
      verses: [],
      versesToCal: [],
      versesOn: false,
      calBox: false,
      indexCal: 0
    };
  },
  methods: {
    fetchVerses: function(suraFileName) {
      console.log(suraFileName);
      fetch("api/verses-map/" + suraFileName, { method: "GET" })
        .then(res => res.json())
        .then(res => {
          this.verses = res;  
          this.versesOn = true;
        });
    },
    putVerseToCal: function(index, verse) {
      this.versesToCal.push({verse: verse.verseText, verseIndex: index});
      this.calBox = true;
      return this.versesToCal;
    }
  },
  computed: {
  },
  created() {
    fetchListCal: {
      fetch("api/quran-index", { method: "GET" })
        .then(res => res.json())
        .then(res => {
          this.surasList = res;
        });
    }
  },
  updated() {},
  mounted() { }
};
</script>
