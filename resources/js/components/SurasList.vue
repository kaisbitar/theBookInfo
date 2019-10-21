<template>
    <div> 
        <div id="quranIndex" class="card container-fluid" ref="quranIndexHeight">      
            <h2 class="indexTitle display-3 container-fluid" :class="{smallListTitle: smallList}" >
                <span class="badge badge-danger">قائمة الكتاب</span>
            </h2>
            <div class="container-fluid spinner-box">
                <b-spinner v-if="loading" small label="Small Spinner" variant="info"></b-spinner>
            </div>
            <ul  class="suraItemBlock block" :class="{smallList: smallList}">
                <li :class="{ isActive: activeSura === index, smallListItems: smallList}" class="suraIndexItem btn btn-info" v-for="(suraIndexItem, index) in surasList" v-bind:key="index" @click="setSuraInPlay(suraIndexItem.fileName, index)">
                    <label>  {{suraIndexItem.suraName}}</label>
                    <label style="font-size: 11px;" ><label :class="{ hide: smallList}">سورة</label> <sup>{{parseInt(suraIndexItem.suraIndex, 10)}}</sup></label>
                </li>
            </ul>
        </div>
        <!-- <div class="btn btn-success"></div> -->
        <Sura ref="changingSura" v-if="showSura" :suraFileName = "suraFileName" :suraName = "suraName" :quranIndexHeight= "quranIndexHeight"></Sura> 
    </div>
</template> 


<script>
    import Sura from './Sura.vue'
    export default {
        components:{
            Sura,
            props:['suraFileName', 'suraName','quranIndexHeight'],
        },
        data() {
            return {
                surasList: [],
                suraName: '',
                suraNumber: '',
                suraFileName: '',
                quranIndexHeight: '',
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
            this.quranIndexHeight = (this.$refs.quranIndexHeight.clientHeight)
        },
        computed:{ s: function(){this.quranIndexHeight = (this.$refs.quranIndexHeight.clientHeight)}
        },
        mounted(){
            this.$refs.quranIndexHeight.matchHeight

        }
    }
</script>

<style scoped>
    .indexTitle{
        width: 214px;
        font-size: 42px;
        margin-bottom: 3px;
    }
    .smallListTitle{
        width: 163px;
        font-size: 29px;
        transition: all 1s ease;
    }
    .indexTitle > span{
        font-weight: 400;
    }
    .spinner-box{
        width: 62px;
    }
    #quranIndex{
        display: block;
        margin-bottom: -11px;        
        margin-top: 3px;
    }
    .suraIndexItem{
        width: 75px;
        margin-bottom: 4px;
        margin-left: 4px;
        color: black;
        height: 51px;
        cursor: pointer;
        font-size: 14px;
    }
    .suraIndexItem label{
        cursor: pointer;
        margin-bottom: 0px;
    }
    /* .badge {
        background: yellowgreen;
        margin-left: 6px;
        color: white;
    } */
    .suraItemBlock{
        list-style: none;
        padding: 0;
        margin-left: 23px;
        padding-top: 6px;
        transition: all 1s ease;

    }
    .smallList {
        transition: all 1s ease;
        color: black;
        cursor: pointer;
        padding: 23px;
        padding-top: 2px;
    } 
    .smallListItems {
        width: 63px;
        margin-bottom: 4px;
        margin-left: 4px;
        color: black;
        height: 22px;
        cursor: pointer;
        font-size: 12px;
        padding: 0;
        font-weight: bolder;
        transition: all 1s ease;
    }
    .isActive{
        background: #28a745;
    }
    ul.verseBlock {
        text-align: justify;
        padding-right: 28px;
    }
</style>
