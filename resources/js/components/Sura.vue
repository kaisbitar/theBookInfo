<template>
    <div class="container-fluid p-0">
        <div class="suraContainer" >
            <div class="container-fluid spinner-box">
                <b-spinner v-if="loading" small label="Small Spinner" variant="success"></b-spinner>
            </div>
            <div v-if="showSura" class="suraBlock card">
                <fixedheader :threshold="matchHeight">
                    <div class="titleBlock row justify-content-center">
                        <ul class="suraInfoBlock ">
                            <li>
                                <h5>
                                    <span class="suraInfo badge badge-primary col-sm">
                                        عدد الكلمات {{sura.NumberOfWords}}
                                    </span>
                                </h5>
                            </li>
                            <li>
                                <h5>
                                    <span class="suraInfo badge badge-secondary col-sm">
                                        عدد الحروف {{sura.NumberOfLetters}}
                                    </span>
                                </h5>
                            </li>
                        </ul>
                        <div class="suraTitle">
                            <h5>
                                <span class="suraInfo badge badge-warning col-sm suraInfoWords ">
                                    عدد الآيات{{sura.NumberOfVerses}}
                                </span>
                            </h5>
                            <h2 class="suraName display-3" >سورة {{suraName}}</h2>
                        </div>
                        <SearchSura ref="searchSura" v-if="showSura" :verses = "verses">SearchSura</SearchSura>                         
                    </div>
                    
                </fixedheader>
                <div class="row justify-content-center">
                    <ul v-if="showSura" class="versesBlock" >
                        <div class="card-body">
                            <li class="verse card" v-for="(verse, index) in verses" v-bind:key="index"  @click.prevent="showDetail(verse)">
                                <div v-if="index!='SuraLettersCount'" class="SuraLettersCount row justify-content-center">
                                    <li>
                                        <span class="verseInfo badge badge-primary">{{verse.NumberOfWords}} كلمة</span>
                                    </li>
                                    <li>
                                        <span class="verseInfo badge badge-secondary">{{verse.NumberOfLetters}} حرف</span>
                                    </li>
                                </div>  
                                <span class="verseIndex badge badge-warning">
                                        آية رقم: {{index}} 
                                    </span>  
                                <!-- hidden inputs for holding data -->
                                <input type="hidden" v-model="verse.verseText">
                                <input type="hidden" v-model="verse.NumberOfLetters">
                                <input type="hidden" v-model="verse.NumberOfWords">
                                <!--  -->
                                <div class="verseText container-fluid">
                                    <span>
                                        {{verse.verseText}}
                                    </span>
                                </div> 
                            </li>
                        </div>                  
                    </ul>       
                </div>
            </div>
        </div> 
    </div>
</template> 

<!-- Lib for stars -->
<script>
    import SearchSura from './SearchSura.vue'
    export default {
        components:{
            SearchSura,
            props:["verses"]
        },
        props: ['suraFileName', 'suraName','quranIndexHeight'],
        data() { 
            return {
            sura: [],
            verses: [],
            verse: [],
            detailShow: false,
            loading: false,
            showSura: false,
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
            fetchVerses: function(){
                if(this.suraFileName == ''){
                    this.loading= false
                    return;
                }
                fetch(('api/verses-map/' + this.suraFileName),{method: 'GET',})
                .then(res => res.json())
                .then(res=> {
                    this.verses = res
                    this.showSura = true
                    this.loading= false
                });
                                
            }, 
            fetchSura: function(){
                this.showSura = false
                if(this.suraFileName == ''){
                    this.loading= false
                    return;
                }
                this.loading= true 
                fetch(('api/sura-map/' + this.suraFileName),{method: 'GET',})
                .then(res => res.json())
                .then(res=> {
                    this.sura.NumberOfLetters = res.NumberOfLetters
                    this.sura.NumberOfVerses = res.NumberOfVerses
                    this.sura.NumberOfWords = res.NumberOfWords
                    this.fetchVerses
                    this.matchHeight
                });
            },
            matchHeight: function(){
                return (this.quranIndexHeight)/2
            }            
        },
        mounted () {
        }
    }
</script>

<style scoped>
    .spinner-box {
        margin-left: auto;
        max-width: 50px;
    }
    .suraInfoBlock {
        list-style: none;
        margin-left: auto;    
        padding: 0;
        display: flex;
        margin: 0px;
        margin-bottom: -7px;
    }
    .suraInfoBlock li > h2 > span {
        width: 254px;
        text-align: center;
    }
    .suraInfo {
        width: 150px;
        margin-left: 4px;        
    }
    .suraName {
        text-align: right;
        font-size: 32px;
        text-align: center;
        margin-top: -6px;
    }
    .suraTitle {
        display: grid;
        max-width: 304px;
    }
    .titleBlock {
        display: grid;
        transition: all 1s ease; 
    }
    .titleBlock.vue-fixed-header--isFixed {
        position: fixed;
        left: 0;
        top: 0;
        width: 100vw;
        background: #f8f9fa;
        border: 1px solid #ccc;
        z-index: 1;
        transition: all .11s ease; 
    }
    .suraContainer {
        min-height: 512px;
    }
    .suraInfoWords{
        width:305px;
    }
    ul.SuraLettersCount {
        list-style: none;
        display: flex;
        padding: 0;
        font-size: 13px;
        width: 112px;
    }
    .SuraLettersCount {
        width: 128px;
        margin-left: auto;
        margin-right: auto;
    }
    .suraBlock.card {
        padding-top: 24px;
        margin-top: 15px;
    }
    .verse {
        direction: rtl;
        list-style: none;
        margin-bottom: 3px;
        float: right;
        margin-left: 3px;
        padding: 0px;
        background: #f6eeef6b;
    }
    .verse a {
        color: #000;
    }
    .verse a:hover {
        color: red;
        text-decoration: none;
    }
    ul.versesBlock {
        text-align: justify;
        line-height: 2.2;
        padding: 0px;
        transition: all 1s ease;
    }
    .detail {
        display: sticky;
    }
    .verseIndex {
        width: 128px;
        margin-left: auto;
        margin-right: auto;
    }
    .verseInfo {
        width: 60px;
        margin-left: 2px;
        margin-right: 2px;
    }
    .verseText {
        text-align: center;
    }
</style>
