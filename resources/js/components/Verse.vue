<template>
    <div class="row justify-content-center">
        <div class="suraContainer" >
            <ul class="verseBlock shadow-sm p-3 mb-5 rounded" >
                <p class="detail" v-if="detailShow==true"> {{verseInPlay}}
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
        <verseInPlay :verseInPlay="verseInPlay"></verseInPlay>
    </div>
</template> 


<script>

    export default {
        props:['verseInPlay'],
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
                fetch(('api/verses-map/002البقرة'),{method: 'GET',})
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
    .detail{
        display: sticky;
    }
    .suraContainer{
        background: #eeeeee7d;
    }
    .shadow-sm {
        box-shadow: 0 0.125rem 0.25rem #C5E275 !important;
    }
</style>
