<template>
    <div class="row justify-content-center">
        <div class="suraContainer" >
            <div class="container-fluid spinner-box">
                <b-spinner v-if="loading" small label="Small Spinner" variant="success"></b-spinner>
            </div>
            <ul v-if="!loading" class="verseBlock shadow-sm p-3 mb-5 rounded" >
                <p class="detail" v-if="detailShow==true"> 
                    <!-- {{verseInPlay}} -->
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
        props:{ 
            suraFileName: '',
            watch: {
                suraFileName: function(){console.log(this.changingSura.fetchVerse)}
            }
        },
        data() {
            return {
            verses: [],
            verse: {
                    verseText: '',
                },
            detailShow: false,
            loading: true
            }
        },
        methods: { 
            showDetail(verse){ 
                this.verse.verseText = verse.verseText
                this.verse.NumberOfLetters = verse.NumberOfLetters
                this.verse.NumberOfWords = verse.NumberOfWords
                this.detailShow = true;
                return this.verse
            }
        },
        computed: {
            fetchVerse: function(){
                this.loading= true
                fetch(('api/verses-map/' + this.suraFileName),{method: 'GET',})
                .then(res => res.json())
                .then(res=> {
                    this.verses = res
                    this.loading= false
                });
            },   
        },
        mounted() {   
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
