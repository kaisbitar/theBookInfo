<template>
    <div> 
        <div id="quranIndex" class="card" ref="quranIndexHeight">      
            <div  class="suraItemBlock" :class="{smallList: smallList}">
                <div v-if="loading" class="container spinner-box">
                    <b-spinner  label="Small Spinner" variant="info"></b-spinner>
                </div>
                <div v-if="!loading" class="indexTitle" :class="{smallListTitle: smallList}" >
                    <span class="btn">قائمة الكتاب</span>
                </div>
                <div v-scroll-to="'#quranIndex'" :class="{ isActive: activeSura === index, smallListItems: smallList}" class="suraIndexItem btn" v-for="(suraIndexItem, index) in surasList" v-bind:key="index" @click="setSuraInPlay(suraIndexItem.fileName, index)">
                    <label>  {{suraIndexItem.suraName}}</label>
                    <label style="font-size: 11px;" >
                        <label :class="{ hide: smallList}">سورة</label> 
                        <sup>{{parseInt(suraIndexItem.suraIndex, 10)}}</sup>
                    </label>
                </div>
            </div>
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
                let windos = this.$el.querySelector("#quranIndex");
                // return 
                scroll = (0)
                console.log(scroll) 
                // windos.scrollDown = scroll -200
            }
        }, 
        created() {
            this.fetchList()
        },
        updated(){
            this.$refs.changingSura.fetchSura
            this.quranIndexHeight = (this.$refs.quranIndexHeight.clientHeight)
            // console.log(this.quranIndexHeight) 
            // return
            //     var container = this.$ref.quranIndexHeight.querySelector(".quranIndex");
            //     container.scrollDown = container.scrollHeight;
        },
        computed:{ s: function(){this.quranIndexHeight = (this.$refs.quranIndexHeight.clientHeight)}
        },
        mounted(){
            this.$refs.quranIndexHeight.matchHeight

        }
    }
</script>

<style scoped>
    .btn{
        border-color: rgba(0, 0, 0, 0.125) !important;
    }
    div#quranIndex {
        margin-top: 15px;
        padding: 15px;
        background: #093f900f;
    }
    .spinner-box{
        width: 62px;
    }
    .indexTitle{
        margin-bottom: 4px;
        width: max-content;
        transition: all 1s ease;
    }
    .indexTitle > span{
        display: block;
        font-size: 45px;
        font-weight: 300;
        color: black;
        padding: 15px 15px 19px 15px;
        background: #b8611738;
        transition: all 1s ease;
    }
    .suraIndexItem{
        width: 75px;
        height: 51px;
        font-size: 14px;
        margin-bottom: 4px;
        margin-left: 4px;
        float: right;
        color: black;
        cursor: pointer;
        background-color: #17a2b838;
        transition: all 1s ease;
    }
    .suraIndexItem label{
        cursor: pointer;
        margin-bottom: 0px;
    }
    .suraItemBlock {
        transition: all 1s ease;
    }
    .smallList {
        transition: all 1s ease;
    } 
    .smallListTitle {
        height: 48px;
        margin-left: 4px;
        float: right;
        transition: all 1s ease;
    }
    .smallListTitle > span {
        font-size: 26px !important;
        padding: 0;
        padding-bottom: 8px;
        transition: all 1s ease;
        padding-left: 5px;
        padding-right: 5px;
    }
    .smallListItems {
        width: 63px;
        height: 22px;
        font-size: 12px;
        padding: 0;
        font-weight: bolder;
        transition: all 1s ease;
    }
    .isActive{
        background: #9fe83e4f;
    }

</style>
