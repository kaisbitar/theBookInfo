/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from "vue";
import Vuetify from "vuetify";
import ar from 'vuetify/es5/locale/ar';
import "vuetify/dist/vuetify.min.css";
import '@mdi/font/css/materialdesignicons.css'
import { Laue } from 'laue';

window.Vue = require("vue");

Vue.use(Laue);
Vue.use(Vuetify);
Vue.use({
  install() {
    Vue.prototype.destroy = Vue.prototype.$destroy;
  },
});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component("vuetify", require("./components/vutifyplay.vue").default);

Vue.component("Sura", require("./components/z_old/Sura.vue").default);
// Vue.component('verseInPlay', {  props: ['verseInPlay']}, require('./components/VersesList.vue').default);
Vue.component(
    "calculate-box",
    require("./components/z_old/CalculateBox.vue").default
);
Vue.component("suras-list", require("./components/z_old/SurasList.vue").default);

//app wrapper
Vue.component("appWrap", require("./components/app/appWrap.vue").default);


Vue.component("board", require("./components/board/board.vue").default);
//list verses and suras
Vue.component("quranIndex", require("./components/Quran/quranIndex.vue").default);
Vue.component("sura", require("./components/Quran/sura.vue").default);
Vue.component("verses", require("./components/Quran/verses.vue").default);

//suraMap
Vue.component("suraMap", require("./components/suraMap/suraMap.vue").default);
Vue.component("test", require("./components/suraMap/test.vue").default);
Vue.component("verseCountChart", require("./components/suraMap/comp/verseCountChart.vue").default);


//indexes
Vue.component("suraIndexes", require("./components/suraMap/comp/indexes/suraIndexes.vue").default);
Vue.component("indexChart", require("./components/suraMap/comp/indexes/chart.vue").default);

//Occurences
Vue.component("suraOccurences", require("./components/suraMap/comp/occurences/suraOccurences.vue").default);
Vue.component("occurenceChart", require("./components/suraMap/comp/occurences/chart.vue").default);
Vue.component("occurenceTable", require("./components/suraMap/comp/occurences/table.vue").default);


//calculations 
Vue.component("theNineteen", require("./components/board/boardComponents/calculations/theNineteen.vue").default);

//calculations comp
Vue.component("verseDetails", require("./components/board/boardComponents/calculations/calculationComp/verseDetails.vue").default);
Vue.component("valuesSum", require("./components/board/boardComponents/calculations/calculationComp/valuesSum.vue").default);





/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: "#app",
    vuetify: new Vuetify({
      rtl: true, 
      lang: {
        locales: { ar },
        current: 'ar',
      },
    }),
  });

// const app = new Vue({
//     el: "#app"
// });
