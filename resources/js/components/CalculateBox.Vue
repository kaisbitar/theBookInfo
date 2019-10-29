<template>
  <div>
    <div class="card">
        Calculate
    </div>
  </div>  
</template>



<script>
import Sura from "./Sura.vue";


export default {
  components: {
    Sura,
    props: ["verse"]
  },
    data() {
    return {
      verseList: [],
      verse: [],
    };
  },
  methods: {

  },
  computed:{
    addVerse(){
      console.log(this.verse);
    }
  }
}
</script>
