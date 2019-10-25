<template>
  <div
    id="theBook"
    class="card"
  >
    <div class="suraItemBlock">
      <div
        v-if="loading"
        class="container spinner-box"
      >
        <b-spinner
          label="Small Spinner"
          variant="info"
        ></b-spinner>
      </div>
      <div
        v-if="!loading"
        class="indexTitle smallListTitle"
      >
        <span class="btn">قائمة الكتاب</span>
      </div>
      <div
        :class="{ isActive: activeSura === index}"
        class="suraIndexItem smallListItems btn"
        v-for="(suraIndexItem, index) in surasList"
        v-bind:key="index"
        @click="setSuraInPlay(suraIndexItem.fileName, index)"
      >
        <label>{{suraIndexItem.suraName}}</label>
        <label style="font-size: 11px;">
          <label class="smallList">سورة</label>
          <sup>{{parseInt(suraIndexItem.suraIndex, 10)}}</sup>
        </label>
      </div>
    </div>
    <div id="surasGroup">
      <Sura
        ref="screen1"
        :suraFileName="suraFileName"
        :suraName="suraName"
        :screen=1
        v-on:changingScreen="changeScreen"
      ></Sura>
      <Sura
        ref="screen2"
        :suraFileName="suraFileName"
        :suraName="suraName"
        :screen=2
        v-on:changingScreen="changeScreen"
      ></Sura>
    </div>
  </div>
</template> 


<script>
import Sura from "./Sura.vue";
export default {
  components: {
    Sura,
    props: ["suraFileName", "screen"]
  },
  data() {
    return {
      surasList: [],
      suraName: "",
      suraNumber: "",
      suraFileName: "",
      showSura: true,
      isActive: false,
      loading: true,
      screen: 1,
      activeSura: 0 //0 to default to الفاتحة this can be dynamic later on for user experience purposes
      // smallList: false
    };
  },
  methods: {
    fetchList() {
      fetch("api/quran-index", { method: "GET" })
        .then(res => res.json())
        .then(res => {
          this.surasList = res;
          this.loading = false;
        });
    },
    setSuraInPlay(fileName, index) {
      this.suraFileName = fileName;
      this.showSura = true;
      this.activeSura = index;
      this.isActive = true;
      this.suraNumber = parseInt(fileName, 10);
      this.smallList = true;
    },
    changeScreen(screen) {
      this.screen = screen;
    }
  },
  created() {
    this.fetchList();
  },
  updated() {
    if (this.screen == 1) {
      this.$refs.screen1.fetchSura;
    } else {
      this.$refs.screen2.fetchSura;
    }
  },

  computed: {},
  mounted() {}
};
</script>

<style scoped>
.btn {
  border-color: #00000020 !important;
}
div#theBook {
  margin-top: 3px;
  padding: 6px;
  background: #093f900f;
}
.indexTitle {
  margin-bottom: 4px;
  width: max-content;
  transition: all 1s ease;
}

.indexTitle > span {
  display: block;
  font-size: 45px;
  font-weight: 300;
  color: black;
  padding: 15px 15px 19px 15px;
  background: #b8611738;
  transition: all 1s ease;
}
.suraIndexItem {
  width: 75px;
  height: 51px;
  font-size: 14px;
  margin-bottom: 4px;
  margin-left: 4px;
  float: right;
  cursor: pointer;
  background-color: #17a2b838;
  transition: all 1s ease;
}
.suraIndexItem label {
  cursor: pointer;
  margin-bottom: 0px;
}
.suraItemBlock {
  transition: all 1s ease;
}
.smallList {
  transition: all 1s ease;
}
.smallListTitle {
  height: 38px;
  margin-left: 4px;
  float: right;
  transition: all 1s ease;
  display: flex;
}
.smallListTitle > span {
  font-size: 21.7px !important;
  padding: 0;
  padding-bottom: 7px;
  transition: all 1s ease;
  padding-left: 5px;
  padding-right: 5px;
}
.smallListItems {
  width: 53px;
  height: 38px;
  font-size: 12px;
  padding: 0;
  transition: all 0.2s ease;
}
.isActive {
  background: #9fe83e4f;
}
#surasGroup {
  display: grid;
  grid-template-columns: 50% 50%;
}
</style>
