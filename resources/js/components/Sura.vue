<template>
    <div class="suraBlock card">
        <div v-if="loading" class="container-fluid spinner-box">
            <b-spinner label="Spinner" variant="success"></b-spinner>
        </div>
            <fixedheader v-if="showSura" :threshold="matchHeight">
                <div class="titleContainer card-header">
                <div class="titleBlock">
                    <div class="suraInfoBlock ">
                        <span class="suraInfo btn btn-custom-orange col-sm">
                            عدد الكلمات {{sura.NumberOfWords}}
                        </span>
                        <span class="suraInfo btn btn-secondary col-sm">
                            عدد الحروف {{sura.NumberOfLetters}}
                        </span>
                    </div>
                    <div class="suraTitle">
                        <div class="suraInfo btn btn-warning col-sm suraVersesNum ">
                            عدد الآيات {{sura.NumberOfVerses}}
                        </div>
                        <div class="suraName btn btn-success" >سورة {{suraName}}</div>
                    </div>
                    <!-- <SearchSura ref="searchSura" v-if="showSura" :verses = "verses">SearchSura</SearchSura>                          -->
                </div>
                </div>
            </fixedheader>
            <div v-if="showSura" class="versesBlock" >
                <div class="verse card" v-for="(verse, index) in verses" v-bind:key="index"  @click.prevent="showDetail(verse)">
                    <div v-if="index!='SuraLettersCount'" class="SuraLettersCount">
                        <span class="verseInfo btn btn-custom-orange">{{verse.NumberOfWords}} كلمة</span>
                        <span class="verseInfo btn btn-secondary">{{verse.NumberOfLetters}} حرف</span>
                    </div>  
                    <span class="verseIndex btn btn-warning">
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
    .btn{
        padding: 0;
        color: #000;
    }
    .spinner-box {
        margin-top: 15px;
    }
    .suraInfoBlock {
        display: flex;
    }
    .suraInfoBlock li > h2 > span {
        width: 254px;
        text-align: center;
    }
    .suraInfo {
        margin: 0px 1px 2px 1px;        
    }
    .suraName {
        width: 303px;
        font-size: 32px;
        padding-bottom: 9px;
        color: black;
        
    }
    .suraTitle {
        max-width: 304px;
    }
    .titleContainer  {
        padding: 4px 0px 4px 0px;
        background-color: #fbf5ef;
        transition: all 1s ease; 
    }
    .titleBlock {
        max-width: 306px;
        margin: auto;
        transition: all 1s ease; 
    }
    .titleContainer.vue-fixed-header--isFixed {
        position: fixed;
        left: 0;
        top: 0;
        width: 100vw;
        background: #f8f9fa;
        border: 1px solid #00000020;
        z-index: 1;
        transition: all .11s ease; 
    }
    .suraContainer {
        /* min-height: 512px; */
    }
    .suraVersesNum{
    }
    .SuraLettersCount {
        width: 128px;
        margin-left: auto;
        margin-right: auto;
    }

    .verse {
        margin-left: 3px;
        margin-bottom: 3px;
        padding: 2px;
        float: right;
        background: #f6eeef6b;
    }
    .verse a {
        color: #000;
    }
    .verse a:hover {
        color: red;
        text-decoration: none;
    }
    .versesBlock {
        padding: 3px 3px 3px 1px;
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
        font-size: 14px;
    }
    .verseInfo .verseIndex  {
        font-size: 14px;
    }
    .btn-custom-orange{
        background-color: #ff750094;
        border-color: #e17c25;
    }
    .btn-secondary{
        background-color: #6c757db0;
    }
    .btn-warning{
        background-color: #ffc10796;
    }
    .btn-success{
        background-color: #28a74557;
    }
    .verseText {
        text-align: center;
        margin-bottom: 5px;
    }
</style>
