<template>
    <div class="row justify-content-center">
        <div class="suraContainer container-fluid shadow-sm p-3 mb-5 rounded" >
            <div class="container-fluid spinner-box">
                <b-spinner v-if="loading" small label="Small Spinner" variant="success"></b-spinner>
            </div>
            <h2 class="suraName display-3" v-if="!loading" :class="{hide:suraName === ''}">سورة {{suraName}}</h2>
            <ul v-if="!loading" :class="{hide:suraName === ''}" class="suraBlock" >
                
                <li class="verse list-inline" v-for="(verse, index) in verses" v-bind:key="index"  @click.prevent="showDetail(verse)">
                    <ul v-if="index!='SuraLettersCount'" class="SuraLettersCount"><li><span class="badge badge-primary">{{verse.NumberOfWords}} كلمة</span></li>
                    <li><span class="badge badge-secondary">{{verse.NumberOfLetters}} حرف</span></li></ul>
                    <input type="hidden" v-model="verse.verseText">
                    <input type="hidden" v-model="verse.NumberOfLetters">
                    <input type="hidden" v-model="verse.NumberOfWords">
                    {{verse.verseText}}
                    <label  v-if="index!='SuraLettersCount'" class="badge star">{{index}}</label>
                    <!-- <p class="detail" v-if="detailShow==true">  -->
                    <!-- {{verseInPlay}} -->
                    
                <!-- </p> -->
                </li>
            </ul>
            <div class="starBlock"></div>
        </div>
    </div>
</template> 


<script>

    export default {
        props:{ 
            suraFileName: '',
            suraName:''
        },
        data() {
            return {
            verses: [],
            verse: {
                    verseText: '',
                },
            detailShow: false,
            loading: false
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
                if(this.suraFileName == ''){
                    return;
                }
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
    ul.SuraLettersCount {
        list-style: none;
        display: flex;
    }
    .spinner-box{
        margin-left: auto;
        max-width: 50px;
    }
    .suraName{
        text-align: right;
        font-size: 32px;
    }
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
    .star {
        padding: 5px;
        font-size: 75%;
        line-height: 1;
        text-align: center;
        border-radius: 1.25rem;
        transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        width: 28px;
        background: #28a745;
        color: white;
    }
    ul.suraBlock {
        text-align: justify;
        line-height: 2.2;
        transition: all 1s ease;
    }
    .detail{
        display: sticky;
    }
    .suraContainer{
        background: #f8f9fa;
    }
    /* .shadow-sm {
        box-shadow: 0 0.125rem 0.25rem #C5E275 !important; */
    /* } */
</style>
