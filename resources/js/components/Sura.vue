<template>
    <div class="row justify-content-center">
        <div class="suraContainer container-fluid shadow-sm p-3 mb-5 rounded" >
            <div class="container-fluid spinner-box">
                <b-spinner v-if="loading" small label="Small Spinner" variant="success"></b-spinner>
            </div>
            <div v-if="showSura" class="suraBlock">
                <div class="titleBlock row justify-content-center">
                    <ul class="suraInfoBlock">
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
                            <span class="suraInfo badge badge-warning col-sm suraInfoWords">
                                عدد الآيات{{sura.NumberOfVerses}}
                            </span>
                        </h5>
                        <h2 class="suraName display-3" >سورة {{suraName}}</h2>
                    </div>
                                        
                </div>
                <ul v-if="showSura" class="versesBlock" >
                    <li class="verse list-inline" v-for="(verse, index) in verses" v-bind:key="index"  @click.prevent="showDetail(verse)">
                        <ul v-if="index!='SuraLettersCount'" class="SuraLettersCount">
                            <li>
                                <span class="verseInfo badge badge-primary">{{verse.NumberOfWords}} كلمة</span>
                            </li>
                            <li>
                                <span class="verseInfo badge badge-secondary">{{verse.NumberOfLetters}} حرف</span>
                            </li>
                        </ul>    
                        <!-- hidden inputs for holding data -->
                        <input type="hidden" v-model="verse.verseText">
                        <input type="hidden" v-model="verse.NumberOfLetters">
                        <input type="hidden" v-model="verse.NumberOfWords">
                        <!--  -->
                        <div style="display: grid;">
                            <span class="verseIndex badge badge-warning">
                                آية رقم: {{index}} 
                            </span>
                            <span>
                                {{verse.verseText}}
                            </span>
                        </div> 
                    </li>
                </ul>
            </div>
            <div class="starBlock"></div>
        </div>
    </div>
</template> 

<!-- Lib for stars -->
<script>

    export default {
        props: ['suraFileName', 'suraName'],
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
                });
            },  
        },
        mounted() {
        },
    }
</script>

<style scoped>
    .spinner-box{
        margin-left: auto;
        max-width: 50px;
    }
    .suraInfoBlock{
        list-style: none;
        margin-left: auto;    
        padding: 0;
        display: flex;
        margin: 0px;
        margin-bottom: -7px;
    }
    .suraInfoBlock li > h2 > span{
        width: 254px;
        text-align: center;
    }
    .suraInfo{
        width: 150px;
        margin-left: 4px;        
    }
    .suraName{
        text-align: right;
        font-size: 32px;
        text-align: center;
        margin-top: -6px;
    }
    .suraTitle{
        display: grid;
        max-width: 304px;
    }
    .titleBlock {
        display: grid;
    }
    .suraInfoWords{
        width:305px;
    }
    ul.SuraLettersCount {
        list-style: none;
        display: flex;
        padding: 0;
        font-size: 13px;
    }
    .suraContainer{
        background: #f8f9fa;
    }
    .verse {
        direction: rtl;        
        list-style: none;
        /* display: flex; */
        margin-bottom: 18px;
    }
    .verse a{
        color: #000;
    }
    .verse a:hover{
        color: red;
        text-decoration: none;
    }
    /* ul.suraBlock {
        text-align: justify;
        line-height: 2.2;
        transition: all 1s ease; 
    } */
    ul.versesBlock{
        text-align: justify;
        line-height: 2.2;
        transition: all 1s ease;
    }
    .detail{
        display: sticky;
    }
    .verseIndex{
        max-width: 103px;
    }
    .verseInfo{
        width: 50px;
        margin-left: 2px;
    }
</style>
