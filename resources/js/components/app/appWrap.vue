<template>
  <v-app id="inspire">
    <v-navigation-drawer
      v-model="drawer"
      app
      right
    >
      <v-list dense>
        <v-list-item @click="">
          <v-list-item-action>
            <v-icon>mdi-home</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Home</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-item @click="">
          <v-list-item-action>
            <v-icon>mdi-book-open-outline</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Account</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
        <!-- <quranIndex></quranIndex> -->

    </v-navigation-drawer>

    <v-app-bar
      app
      color="cyan"
      dark
    >
      <v-spacer></v-spacer>
      <v-toolbar-title right>الكتاب المرقوم</v-toolbar-title>
      <v-app-bar-nav-icon right @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
    </v-app-bar>

    <v-content>
      <v-container
        fluid
        fill-height
      >
        <v-layout
          justify-center
          align-center
        >
          <v-flex text-medium-center>
            <board></board>
          </v-flex>
        </v-layout>
      </v-container>
    </v-content>

    <v-footer
      color="cyan"
      app
    >
      <v-spacer></v-spacer>
      <span class="white--text">&copy; 2019</span>
    </v-footer>
  </v-app>
</template>

<script>
import quranIndex from '../board/boardComponents/Quran/quranIndex'
import board from '../board/board.vue'
export default {
    data(){
        return{
            drawer:true
        }
    }
}
</script>

<style lang="scss">
@import '~@/variables.scss';
.v-application{
  font-family: $body-font-family;
}
.v-data-table td{
    // border:0px !important;     
}
.v-data-table td .verseText{
    border-bottom: 1px solid #ccc !important;
}
</style>