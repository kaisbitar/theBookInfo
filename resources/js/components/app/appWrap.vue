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
        <quranIndex></quranIndex>

    </v-navigation-drawer>

    <v-app-bar 
      fixed
      dense
      floating
      flat
      short
      app
      dark
      class="purple d-flex"
    >
      <v-spacer></v-spacer>      
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <v-toolbar-title >الكتاب المرقوم</v-toolbar-title>
      <v-text-field
        label="Regular"
        single-line
        class="d-flex justify-center"
      ></v-text-field>
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
            <!-- <board></board> -->
            <v-tabs color="primary">
              <v-tab
            
              >
                السور
              </v-tab>
              <v-tab
              >
                حساب ال ١٩
              </v-tab>
              <v-tab-item><suraMap></suraMap></v-tab-item>
              <!-- <v-tab-item><theNineteen :fileName="'074المدثر'"></theNineteen></v-tab-item> -->
            </v-tabs>
            
          </v-flex>
        </v-layout>
      </v-container>
    </v-content>

    <v-footer
      color="purple"
      app
    >
      <v-spacer></v-spacer>
      <span class="white--text">&copy; 2019</span>
    </v-footer>
  </v-app>
</template>

<script>
import quranIndex from '../Quran/quranIndex'
import board from '../board/board.vue'
import theNineteen from '../board/boardComponents/calculations/theNineteen.vue'
import suraMap from '../suraMap/suraMap.vue'
export default {
    data(){
        return{
            drawer:false
        }
    }
}
</script>

<style lang="scss">
@import '~@/variables.scss';
.v-application {
  font-family: $body-font-family;
}
.v-application .display-1, .v-application .display-2,
.v-application .display-3, .v-application .display-4{
    font-family: $body-font-family !important;
}
.v-data-table td{
    // border:0px !important;     
}
.v-data-table td .verseText{
    border-bottom: 1px solid #ccc !important;
}
</style>