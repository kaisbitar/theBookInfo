/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// require("./bootstrap");
import Vue from "vue";
// import BootstrapVue from "bootstrap-vue";
// import "bootstrap/dist/css/bootstrap.css";
// import "bootstrap-vue/dist/bootstrap-vue.css";
import "vuetify/dist/vuetify.min.css";
// import 'mdi/font/css/materialdesignicons.min.css';
import '@mdi/font/css/materialdesignicons.css'
// import 'vuetify/src/styles/styles.sass'
import 'vuetify/src/styles/variables.scss';
import ar from 'vuetify/es5/locale/ar';

import Vuetify from "vuetify";
window.Vue = require("vue");

// Vue.use(BootstrapVue);
Vue.use(Vuetify);

// Vue.use(FixedHeader)

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

Vue.component("Sura", require("./components/old/Sura.vue").default);
// Vue.component('verseInPlay', {  props: ['verseInPlay']}, require('./components/VersesList.vue').default);
Vue.component(
    "calculate-box",
    require("./components/old/CalculateBox.vue").default
);
Vue.component("suras-list", require("./components/old/SurasList.vue").default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component("board", require("./components/board/board.vue").default);
Vue.component("quranIndex", require("./components/board/boardComponents/Quran/quranIndex.vue").default);
Vue.component("sura", require("./components/board/boardComponents/Quran/sura.vue").default);
Vue.component("verses.vue", require("./components/board/boardComponents/Quran/verses.vue").default);




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
