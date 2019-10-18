<template>
    <div> 

        <div id="quranIndex" class="container-fluid">      
            <div class="container-fluid spinner-box">
                <b-spinner v-if="loading" small label="Small Spinner" variant="info"></b-spinner>
            </div>
            <ul  class="suraItemBlock block" >
                <li  v-bind:class="{ isActive: activeSura === index}" class="suraIndexItem btn btn-info" v-for="(suraIndexItem, index) in surasList" v-bind:key="index" @click="setSuraInPlay(suraIndexItem.fileName, index)">
                    <label>  {{suraIndexItem.suraName}}</label>
                    <label>سورة {{parseInt(suraIndexItem.suraIndex, 10)}} </label>
                </li>
            </ul>
        </div>

        <Sura ref="changingSura" v-if="showSura" v-bind:suraFileName = "suraFileName"></Sura> 

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
                suraFileName:'001الفاتحة',
                showSura: true, 
                isActive: false,
                loading: true,
                activeSura: 0 //0 to default to الفاتحة this can be dynamic later on for user experience purposes
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
                console.log(this.suraName)
                this.$refs.changingSura.fetchVerse
            }
        }, 
        created() {
            this.fetchList()
        },
        updated(){
            this.$refs.changingSura.fetchVerse
        }
    }
</script>

<style scoped>
    .spinner-box{
        width: 62px;
    }
    #quranIndex{
        display: block;
    }
    .suraIndexItem{
        width: 101px;
        margin-bottom: 4px;
        margin-left: 4px;
        color: black;
        height: 104px;
        cursor: pointer;
    }
    .suraIndexItem label{
        cursor: pointer;
    }
    .badge {
        background: yellowgreen;
        margin-left: 6px;
        color: white;
    }
    .suraItemBlock{
        list-style: none;
        transition: all .2s ease-in-out;
        padding: 0;
        /* position: fixed; */
        max-height: 640px;
        overflow-y: overlay;
        overflow-x: hidden;
        margin-left: 23px;
        min-height: 647px;
    }
    .smallList {
        transition: all .2s ease-in-out;
    }
    .isActive{
        background: #28a745;
    }
    ul.verseBlock {
        text-align: justify;
        padding-right: 28px;
    }
    ::-webkit-scrollbar {
        width: 1em;
    }
    ::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.1);
    }
    ::-webkit-scrollbar-thumb {
        background-color: #6c757d;
        outline: 1px solid slategrey;
    }
</style>
