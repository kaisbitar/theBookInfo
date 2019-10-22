<template>
  <div
    id="theBook"
    class="card"
    ref="theBookHeight"
  >
    <div class="suraItemBlock smallList">
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
        class="indexTitle smallList"
      >
        <span class="btn">قائمة الكتاب</span>
      </div>
      <div
        v-scroll-to="'#theBook'"
        :class="{ isActive: activeSura === index}"
        class="suraIndexItem btn"
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
    <div v-if="showSura">
      <!-- <Sura
        ref="changingSura"
        v-for="(sura, index) in surasList"
        v-bind:key="index"
        :suraFileName="suraFileName"
        :suraName="suraName"
        :theBookHeight="theBookHeight"
      ></Sura> -->
      <Sura
        ref="changingSura"
        :suraFileName="suraFileName"
        :suraName="suraName"
        :theBookHeight="theBookHeight"
      ></Sura>
    </div>
  </div>
  <!-- <div class="btn btn-success"></div> -->
</template> 


<script>
import Sura from "./Sura.vue";
export default {
  components: {
    Sura,
    props: ["suraFileName", "suraName", "theBookHeight"]
  },
  data() {
    return {
      surasList: [],
      suraName: "",
      suraNumber: "",
      suraFileName: "",
      theBookHeight: "",
      showSura: true,
      isActive: false,
      loading: true,
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
      this.suraName = this.suraFileName.replace(/[0-9]/g, "");
      this.$refs.changingSura.fetchSura;
      this.smallList = true;
      let windos = this.$el.querySelector("#theBook");
      scroll = 0;
      console.log(scroll);
      // windos.scrollDown = scroll -200
    }
  },
  created() {
    this.fetchList();
  },
  updated() {
    this.$refs.changingSura.fetchSura;
    this.theBookHeight = this.$refs.theBookHeight.clientHeight;
  },
  computed: {
    s: function() {
      this.theBookHeight = this.$refs.theBookHeight.clientHeight;
    }
  },
  mounted() {
    this.$refs.theBookHeight.matchHeight;
  }
};
</script>

<style scoped>
.btn {
  border-color: #00000020 !important;
}
div#theBook {
  margin-top: 3px;
  padding: 3px;
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
  color: black;
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
  height: 48px;
  margin-left: 4px;
  float: right;
  transition: all 1s ease;
}
.smallListTitle > span {
  font-size: 26px !important;
  padding: 0;
  padding-bottom: 7px;
  transition: all 1s ease;
  padding-left: 5px;
  padding-right: 5px;
}
.smallListItems {
  width: 63px;
  height: 22px;
  font-size: 12px;
  padding: 0;
  /* font-weight: bolder; */
  transition: all 1s ease;
}
.isActive {
  background: #9fe83e4f;
}
</style>
