<template>
  <div class="container-fluid">
    <div class="search-wrapper">
      <input type="text" v-model="search" placeholder="Search title.." />
      <label>Search title:</label>
    </div>
    <div class="wrapper">
      <div class="card" v-for="(post,key) in filteredList" :key="key">
        <a v-bind:href="post.link" target="_blank">
          <img v-bind:src="post.img" />
          <small>posted by: {{ post.author }}</small>
          {{ post.title }}
        </a>
      </div>
    </div>
  </div>
</template> 


<script>
class Post {
  constructor(title, link, author, img) {
    this.title = title;
    this.link = link;
    this.author = author;
    this.img = img;
  }
}

export default {
  props: ["verses"],
  data() {
    return {
      search: "",
      postList: [this.verses]
    };
  },
  computed: {
    filteredList() {
      return this.postList.filter(post => {
        // console.log(post.verseText)
        // return
        // return post.verseText.includes(this.search)
      });
    }
  }
};
</script>

<style>
</style>
