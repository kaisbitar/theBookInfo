<template>
<b-toast id="example-toast" title="BootstrapVue" static no-auto-hide>
      {{toastMsg}}
    </b-toast>
  <!-- <div class="p-3 bg-secondary progress-bar-striped" style="min-height: 170px;"> -->
    <!-- <b-button class="mb-2" variant="primary" @click="$bvToast.show('example-toast')">
      Show toast
    </b-button> -->
    <!-- <b-toast id="example-toast" title="BootstrapVue" static no-auto-hide>
      Hello, world! This is a toast message.
    </b-toast> -->
  <!-- </div> -->
</template>

<script>
export default {
  props:["toastMsg", "toastOn"],
  watch:{ 
    "toastOn": function(){
      if(this.toastOn == true){
        this.showToast(this.toastMsg);
      }
    }
  },
  methods: {
    showToast: function(){
      this.toastOn = true; 
      this.$bvToast.show('example-toast');
    }
  }
}
</script>