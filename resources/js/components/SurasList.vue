<template>

  <div id="theBook" class="card">
    <!-- <fixedheader> -->
      <div class="listWrap">
        <div :class="{ smallSuraItemBlock: isSmallList}" class="suraItemBlock" v-if="showList">
          <div v-if="loading" class="container spinner-box">
            <b-spinner label="Small Spinner" variant="info"></b-spinner>
          </div>
                

          <div v-if="!loading" class=" listTitle">
            <span class="btn">قائمة الكتاب</span>
          </div>
          <div
            :class="{ isActive: activeSura === index, smallList: isSmallList}"
            class="listItems btn"
            v-for="(suraIndexItem, index) in surasList"
            v-bind:key="index"
            @click="setSuraInPlay(suraIndexItem.fileName, index)"
          >
            <div
              v-if="!isSmallList"
            >
              {{suraIndexItem.suraName}}
            </div>
            <div  style="font-size: 11px;">
              <label  v-if="!isSmallList" class="list">سورة</label>
              <sup id="indexRender">{{parseInt(suraIndexItem.suraIndex, 10)}}</sup>
            </div>
          </div>

        </div>
        <div 
          v-if="!loading"
          class="listBtnsWrap"
          :class="{ smallbtnWrap: isSmallList}" 
        >        
          <div
            class="toggle-list btn btn-warning"
            :class="{ smallToggleBtn: isSmallList}"
            v-if="showList"
            @click="isSmallList=!isSmallList"
            > 
              <div 
                v-if="isSmallList"
              >
                  تكبير القائمة
              </div>
              <div 
                v-else
              >
                تصغير القائمة
              </div>
          </div>
          <div
            class="toggle-list btn btn-warning"
            v-if="showSura"
            :class="{ smallToggleBtn: isSmallList}"
            @click="showList=!showList"
            > 
            <div 
              v-if="showList"
            >
                اغلاق القائمة
            </div>
            <div 
              v-else
            >
              فتح القائمة
            </div>
          </div>
        </div>
      </div>
    <!-- </fixedheader> -->

    
    <div id="surasGroup">
      <Sura
        ref="screen1"
        :suraFileName="suraFileName"
        :suraName="suraName"
        :screen="1"
        v-on:changingScreen="changeScreen"
      ></Sura>
      <!-- <Sura
        ref="screen2"
        :suraFileName="suraFileName"
        :suraName="suraName"
        :screen="2"
        v-on:changingScreen="changeScreen"
      ></Sura> -->
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
      suraFileName: "001الفاتحة",
      showSura: true,
      isActive: false,
      loading: true,
      screen: 1,
      activeSura: 0, //0 to default to الفاتحة this can be dynamic later on for user experience purposes
      isSmallList: false,
      showList: true
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
      this.isSmallList = true;
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

<style>
.btn {
  border-color: #00000000 !important;
}
div#theBook {
  margin-top: 3px;
  padding: 6px;
  background: #093f900f;
}
.listWrap.vue-fixed-header{
  transition: BezierEasing(0.215, 0.61, 0.355, 1);
  position: inherit;
}    
.listWrap.vue-fixed-header--isFixed {
  position: fixed;
  left: 0;
  top: 0;
  width: 100vw;
  background: #f8f9fa;
  border: 1px solid #00000020;
  z-index: 1;
  animation: fadeIn 0.3s ease-out forwards;

}

@keyframes fadeIn {
  0% {
    /* opacity: 0; */
      /* transition-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1); */
  transition: BezierEasing(0.215, 0.61, 0.355, 1);

    transform: translateY(-74px);

  }
  100% {
    /* opacity: 1; */
      transition: BezierEasing(0.215, 0.61, 0.355, 1);

    transform: translateY(0);

  }
}
.listTitle {
  height: 38px;
  display: block;
  font-size: 45px;
  font-weight: 300;
  color: black;
  margin-left: 4px;
  float: right;
  display: flex;
}
.listTitle > span {
  font-size: 21.7px !important;
  display: block;
  font-size: 45px;
  font-weight: 300;
  color: black;
  padding: 15px 15px 19px 15px;
  background: #b8611738;
  padding: 0;
  padding-bottom: 7px;
  padding-left: 5px;
  padding-right: 5px;
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
}
.listItems label {
  cursor: pointer;
  margin-bottom: 0px;
}
.smallSuraItemBlock {
    max-width: 965px;
}
.smallList {
    width: 19px !important;
    height: 17px !important;
  }
.listItems {
  width: 53px;
  height: 38px;
  font-size: 12px;
  padding: 0;
  margin-bottom: 4px;
  margin-left: 4px;
  float: right;
  cursor: pointer;
  background-color: #17a2b838;
}
.toSmallList-enter-active, .toSmallList-leave-active{
    transition: transform 0.6s cubic-bezier(0.215, 0.61, 0.355, 1);
}
.toSmallList-enter .toSmallList-leave-to{
  opacity: 0;
}
.isActive {
  background: #1ec400;
  color: white;
}
#indexRender {
    top: -0.3em;
}
.listItems.btn:hover{
  background: #9fe83e4f;
}
.toggle-list.btn.btn-warning {
    width: 168px;
    font-size: 12px;
    margin-bottom: 4px;
}
.smallToggleBtn{
    width: 157px !important;
    height: 17px;
    font-size: 10px !important;
}
.smallToggleBtn:nth-child(2) {
    margin-right: -1px;
}
.toggle-list.btn:hover{
  color: white;
}
.listBtnsWrap {
  max-width: 341px;
  float: right;
}
.smallbtnWrap{
  max-width: 358px;
  margin-bottom: 5px !important;
  height: 21px;
  margin-top: -4px;}
</style>
