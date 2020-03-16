<template>
    <v-container>
        <v-row>
            <p class="font-weight-black mt-2">المجموع</p>
            <v-chip-group>
                
                <v-icon small>mdi-equal</v-icon>
            </v-chip-group>
            <v-chip-group v-for="(score, index) in scoresGroup" :key="index">
                <v-chip>
                    {{score}}
                </v-chip>
                <v-icon v-if="!(index==scoresGroup.length-1)" small>mdi-plus</v-icon>
            </v-chip-group>
            <v-chip-group>
                <v-icon small v-if="(scoresGroup.length!=0)" >mdi-equal</v-icon>
                <v-chip color="yellow">
                    {{sum}}
                </v-chip>
            </v-chip-group>
        </v-row>
        <v-row>
            <p class="font-weight-black mt-3">حساب القسمة</p>            
            <v-chip-group>
                <v-icon small>mdi-equal</v-icon>
                <v-chip color="yellow">
                    {{sum}}
                </v-chip>
                <v-icon small>mdi-division</v-icon> 
                <v-chip>19</v-chip>
                <v-icon small>mdi-equal</v-icon>
                <v-chip :class="resultColor">{{division19}}</v-chip>
            </v-chip-group>
        </v-row>
    </v-container>
</template>


<script>
export default {
  components:{},
  props: ["scoresGroup"],
  data() {
    return {
        scoresSum: 0,
        division :0
    }
  },
  computed: {
    sum(){
        this.scoresSum = this.scoresGroup.reduce((a, b) => a + b, 0)
        return this.scoresSum
    },
    division19(){
        this.division = this.scoresSum/19
        return this.scoresSum/19
    },
    resultColor(){
        if(this.scoresSum==0){
            return 'yellow'
        }else if(this.division % 1 === 0){
            return 'success lighten-1'
        }else{
            return 'error lighten-1'
        }
    }
  },
  methods:{},
  created(){}
};
</script>



<style lang="scss">
</style> 