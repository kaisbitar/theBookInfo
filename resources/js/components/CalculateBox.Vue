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
          @click.prevent="putVerseToCal(index)"
        >
          {{index}}- {{verse.verseText}}
        </b-dropdown-item-button>
      </b-dropdown>
    </div>
    <div
      class="card"
      v-if="versesOn"
    >
      <div
        v-for="(verseToCal, indexCal) in this.versesToCal"
        v-bind:key="indexCal"
      >
        {{(verseToCal)}}
      </div>
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
      verse: [],
      versesToCal: [],
      versesOn: false,
      verseOn: false,
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
    putVerseToCal: function(index) {
      // this.toCalVerses(index);
      // this.versesToCal = index;
      $set(this.versesToCal, this.indexCal, this.verses[index]);
      // = this.verses[index];
      this.indexCal++;
      Vue.nextTick;
      console.log(this.verses[index]);
      // return this.versesToCal;
    },
    displayVersesToCal: function(verseToCal) {
      return this.versesToCal;
    }
  },
  computed: {
    verseToCal: function() {
      return this.versesToCal;
    }
    // toCalVerses() {
    //   this.versesToCal[this.indexCal] = this.verses[this.index];
    //   this.verseOn = true;
    //   this.indexCal++;
    //   console.log(this.toCalVerses);
    //   return this.versesToCal;
    // }
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
  mounted() {
    // this.putVerseToCal;
  }
};
</script>
