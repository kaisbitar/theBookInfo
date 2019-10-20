<template>
    <div> 

        <div id="quranIndex" class="shadow-sm p-3 mb-5 rounded container-fluid">      
            <div class="container-fluid spinner-box">
                <b-spinner v-if="loading" small label="Small Spinner" variant="info"></b-spinner>
            </div>
            <ul  class="suraItemBlock block" :class="{smallList: smallList}">
                <li :class="{ isActive: activeSura === index, smallListItems: smallList}" class="suraIndexItem btn btn-info" v-for="(suraIndexItem, index) in surasList" v-bind:key="index" @click="setSuraInPlay(suraIndexItem.fileName, index)">
                    <label>  {{suraIndexItem.suraName}}</label>
                    <label :class="{ hide: smallList}">سورة {{parseInt(suraIndexItem.suraIndex, 10)}} </label>
                </li>
            </ul>
        </div>

        <Sura ref="changingSura" v-if="showSura" :suraFileName = "suraFileName" :suraName = "suraName"></Sura> 

    </div>

</template> 


<script>
    import Sura from './Sura.vue'
    export default {
        components:{
            Sura,
            props:['suraFileName', 'suraName'],
        } ,
        data() {
            return {
                surasList: [],
                suraName: '',
                suraNumber: '',
                suraFileName:'',
                showSura: true, 
                isActive: false,
                loading: true,
                activeSura: 0, //0 to default to الفاتحة this can be dynamic later on for user experience purposes
                smallList: false
            }
        },
        methods: {
            fetchList(){
                fetch(('api/quran-index'),{method: 'GET',})
                .then(res => res.json())
                .then(res => {
                    this.surasList = res
                    this.loading = false
                })
            },
            setSuraInPlay(fileName, index){ 
                this.suraFileName = fileName
                this.showSura = true
                this.activeSura = index;
                this.isActive =  true
                this.suraNumber = parseInt(fileName, 10);
                this.suraName = this.suraFileName.replace(/[0-9]/g, '');
                this.$refs.changingSura.fetchSura
                this.smallList = true
            }
        }, 
        created() {
            this.fetchList()
        },
        updated(){
            this.$refs.changingSura.fetchSura
        }
    }
</script>

<style scoped>
    .spinner-box{
        width: 62px;
    }
    #quranIndex{
        display: block;
        /* background: #eed191; */
    }
    .suraIndexItem{
        width: 75px;
        margin-bottom: 4px;
        margin-left: 4px;
        color: black;
        height: 81px;
        cursor: pointer;
        font-size: 14px;
        /* border-color: #000000;
        box-shadow: 0 0.09rem 0.1rem #000; */
    }
    .suraIndexItem label{
        cursor: pointer;
        margin-bottom: 0px;
    }
    .badge {
        background: yellowgreen;
        margin-left: 6px;
        color: white;
    }
    .suraItemBlock{
        list-style: none;
        padding: 0;
        margin-left: 23px;
        transition: all 1s ease;

    }
    .smallList {
        transition: all 1s ease;
        color: black;
        cursor: pointer;
    }
    .smallListItems {
        width: 51px;
        margin-bottom: 4px;
        margin-left: 4px;
        color: black;
        height: 22px;
        cursor: pointer;
        font-size: 12px;
        padding: 0;
        font-weight: bolder;
        /* text-shadow: 0 0.09rem 0.1rem #000; */
        transition: all 1s ease;

    }
    .isActive{
        background: #28a745;
    }
    ul.verseBlock {
        text-align: justify;
        padding-right: 28px;
    }
    /* ::-webkit-scrollbar {
        width: 1em;
    }
    ::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.1);
    }
    ::-webkit-scrollbar-thumb {
        background-color: #6c757d;
        outline: 1px solid slategrey;
    } */
</style>
