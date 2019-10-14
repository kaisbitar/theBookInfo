<template>
    <div class="row justify-content-center">
        <div class="" >
            <ul class="verseBlock" >
                <p class="detail" v-if="detailShow==true"> 
                    {{verse.verseText}}
                    Number of Letters:{{verse.NumberOfLetters}} 
                    Number of Words:{{verse.NumberOfWords}}
                </p>
                <li class="verse" v-for="(verse, index) in verses" v-bind:key="index"  @click.prevent="showDetail(verse)">
                    <input type="hidden" v-model="verse.verseText">
                    <input type="hidden" v-model="verse.NumberOfLetters">
                    <input type="hidden" v-model="verse.NumberOfWords">
                    {{verse.verseText}}
                    <label  v-if="index!='SuraLettersCount'" class="badge star">{{index}}</label>
                </li>
            </ul>
            <div class="starBlock">
            </div>
        </div>
    </div>
</template> 


<script>
    export default {
        data() {
            return {
            verses: [],
            verse: {
                    verseText: '',
                },
            detailShow: false
            }
        },
        methods: {
            fetchVerse(){
                fetch(('api/verses-map'),{method: 'GET',})
                .then(res => res.json())
                .then(res=> {
                    this.verses = res
                });
            },
            showDetail(verse){ 
                console.log(verse)
                this.verse.verseText = verse.verseText
                this.verse.NumberOfLetters = verse.NumberOfLetters
                this.verse.NumberOfWords = verse.NumberOfWords
                this.detailShow = true;
                return this.verse
            }
        },
        mounted() {
            this.fetchVerse();
        },
    }
</script>

<style scoped>
    .verse {
        direction: rtl;        
        list-style: none;
        display: inline;
    }
    .verse a{
        color: #000;
    }
    .verse a:hover{
        color: red;
        text-decoration: none;
    }
    .badge.star {
        background: yellowgreen;
        margin-left: 6px;
        color: white;
    }
    ul.verseBlock {
        text-align: justify;
    }
    #diamond {
      width: 0;
      height: 0;
      border: 50px solid transparent;
      border-bottom-color: red;
      position: relative;
      top: -50px;
    }
    #diamond:after {
      content: '';
      position: absolute;
      left: -50px;
      top: 50px;
      width: 0;
      height: 0;
      border: 50px solid transparent;
      border-top-color: red;
    }
    .detail{
        display: sticky;
    }
</style>
