<template>
    <div>
        <div class="row justify-content-center" v-for="suraName in surasList">
        {{suraName}}
        </div>
    </div>
</template> 


<script>
    export default {
        data() {
            return {
                surasList: [],
                suraName: ''
            }
        },
        methods: {
            fetchList(){
                fetch(('api/suras-list'),{method: 'GET',})
                .then(res => res.json())
                .then(res => {
                    this.surasList = res;console.log(this.surasList)
                    this.suraName = this.surasList.suraName;
                })
            }
        },
        mounted() {
            this.fetchList();
        },
    }
</script>

<style scoped>

</style>
