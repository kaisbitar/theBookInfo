<template>
    <div>
        <div>
            <b-spinner v-if="loading" small label="Small Spinner" variant="info"></b-spinner>
        </div>
        <!-- <button @click="isActive = !isActive">show</button> -->
        <ul  class="suraItemBlock block" >
            <li  v-bind:class="{ smallList: isActive}" class="suraIndexItem btn btn-info" v-for="(suraIndexItem, index) in surasList" v-bind:key="index" @click="setSuraInPlay(suraIndexItem.fileName)">
                <label> سورة {{suraIndexItem.suraName}}</label>
                <label>{{suraIndexItem.suraIndex}} </label>
            </li>
        </ul>
    </div>
</template> 


<script>
// import verseInPlay from './Verse.vue';

    export default {
        //  components: {
        //     verseInPlay
        // },
        data() {
            return {
                surasList: [],
                suraName: '',
                isActive: true,
                loading: true,
                verseInPlay: '001الفاتحة'
            }
        },
        methods: {
            fetchList(){
                fetch(('api/quran-index'),{method: 'GET',})
                .then(res => res.json())
                .then(res => {
                    this.surasList = res;console.log(this.surasList)
                    this.suraName = this.surasList.suraName
                    this.loading = false
                })
            },
            setSuraInPlay(fileName){
                this.verseInPlay = fileName;console.log(this.verseInPlay)
            }
        },
        mounted() {
            this.fetchList();
        },
    }
</script>

<style scoped>
    .suraIndexItem{
        width: 101px;
        margin-bottom: 4px;
        margin-left: 4px;
        color: black;
        height: 104px;
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
        position: fixed;
        max-height: 640px;
        max-width: 332px;
        overflow-y: overlay;
        overflow-x: hidden;
        margin-left: 23px;
        min-height: 647px;
    }
    .smallList {
        /* transform: scale(0.5); */
        transition: all .2s ease-in-out;
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
