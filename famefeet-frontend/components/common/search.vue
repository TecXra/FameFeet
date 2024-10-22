<template>
  <div class="mb-0 d-sm-flex">
    <div class="mr-4 w-100">
      <form
        action=""
        class=""
        @submit.stop.prevent
        v-on:keyup.enter="applyFilter()"
      >
        <!-- <div class="p-1 searchbar rounded rounded-pill shadow-sm mb-0"> -->
        <div class="input-group">
          <input
            type="search"
            placeholder="Search"
            v-model="searchQuerytext"
            class="search-field"
          />
        </div>
        <!-- </div> -->
      </form>
    </div>

    <div class="mt-2 mt-sm-0">
      <div class="d-flex justify-content-center">
        <button class="btn ff-btn1-pink px-3 mr-2" @click="applyFilter()">
          <!-- <i class="fi fi-rr-filter" style="vertical-align: middle"></i> -->
          <span class="">Search</span>
        </button>
        <button class="btn ff-search-clear px-3" @click="clearFilter()">
          <!-- <i class="fi fi-rr-filter-slash" style="vertical-align: middle"></i> -->
          <span class="">Clear</span>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "search",

  data() {
    return {
      searchQuerytext: "",
    };
  },

  methods: {
    applyFilter() {
      var payload = {
        text: this.searchQuerytext,
      };
      this.$emit("searchQuery", payload);
      // console.log(payload);
    },
    clearFilter() {
      this.searchQuerytext = "";
      this.$emit("getaAllData");
    },
  },
};
</script>

<style lang="css" scoped>
.search-field {
  background-color: #f4f4f4;
  border: 0;
  border-radius: 50px;
  font-size: 15px;
  min-height: 46px;
  padding: 11px 16px;
  width: 100%;
}
.search-field:focus {
  box-shadow: none;
}
.search-field:focus-visible {
  outline: none;
}
.search-field::placeholder {
  color: #000;
}
.ff-search-clear {
  color: white;
  background-color: var(--secondary);
  padding: 10px 30px 10px 30px;
  font-size: 16px;
  font-weight: 500;
  box-shadow: rgb(28 27 27 / 45%) 0px 4px 29px -6px;
  border-radius: 100px;
}
.ff-search-clear:hover {
  cursor: pointer;
  background-color: transparent;
  outline: 2px solid var(--secondary);
  color: var(--secondary) !important;
}
</style>
