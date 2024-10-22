<template>
  <div class="row mb-0">
    <div class="col-6 col-md-4 col-lg-4 col-xl-5">
      <form
        action=""
        class="w-100"
        @submit.stop.prevent
        v-on:keyup.enter="applyFilter()"
      >
        <div class="input-group">
          <input
            type="search"
            placeholder="Search"
            v-model="searchQuerytext"
            class="search-field"
            id="search"
          />
        </div>
      </form>
    </div>

    <div class="col-6 col-md-4 col-lg-4 col-xl-5">
      <b-dropdown
        :text="selectedName() ? selectedName() : fieldtext"
        id="search-categoriess"
        class="w-100"
        variant="bg-white"
        no-caret
      >
        <b-dropdown-form v-for="(item, index) in allCategories" :key="index">
          <b-form-checkbox
            class="mb-1"
            :id="'checkbox-' + index"
            :value="item"
            v-model="selectedCategories"
            >{{ item.text }}</b-form-checkbox
          >
        </b-dropdown-form>
      </b-dropdown>
    </div>
    <div class="col-12 col-md-4 col-lg-4 col-xl-2 mt-2 mt-md-0">
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
  name: "searchCategories",
  props: ["type"],

  data() {
    return {
      fieldtext: "Select Categories",
      searchQuerytext: "",
      selectedCategories: [],
      allCategories: [],
    };
  },
  mounted() {
    this.getAllCategories();
    this.updateInputFieldName(); // Call the method initially
    window.addEventListener("resize", this.updateInputFieldName);
    // this.getAllCategories();
    // // Call the function on window resize
    // window.addEventListener("resize", this.updateInputFieldName);
  },
   destroyed() {
    window.removeEventListener("resize", this.updateInputFieldName);
  },

  methods: {
    updateInputFieldName: function () {
      console.log();
      if (window.innerWidth < 768) {
        this.fieldtext = "Categories";
      } else {
        this.fieldtext = "Select Categories";
      }
    },

    applyFilter: function () {
      var temparry = "";
      temparry = this.selectedCategories.map((item) => parseInt(item.id));
      var payload = {
        text: this.searchQuerytext,
        categories: temparry,
      };
      this.$emit("searchQuery", payload);
      // console.log(payload);
    },

    clearFilter() {
      (this.selectedCategories = []);
       (this.searchQuerytext = "");
      this.$emit("getaAllData");
    },
    selectedName() {
      return this.selectedCategories.map((item) => item.text).join(", ");
    },

    async getAllCategories() {
      var self = this;
      await this.$axios
        .$get("/getAllCategories")
        .then(function (response) {
          self.allCategories = response;
        })
        .catch(function (error) {
          self.$bvToast.toast(error, {
            title: "Warning",
            variant: "warning",
            solid: true,
          });
        });
    },
  },
};
</script>

<style>
.search-field {
  background-color: #f4f4f4;
  border: 0;
  border-radius: 50px;
  font-size: 15px;
  min-height: 46px;
  padding: 11px 16px;
  width: 100%;
}
.search-field::placeholder {
  color: #000;
}
.search-field:focus {
  box-shadow: none;
}
.search-field:focus-visible {
  outline: none;
}
#search-categoriess ul {
  overflow-y: scroll;
  height: 75vh;
}
#search-categoriess {
  min-height: 46px !important;
  padding: 4px 14px !important;
  background-color: #f4f4f4;
  border: 0;
  border-radius: 50px;
}
#search-categoriess button {
  text-align: left !important;
  overflow: hidden !important;
}
#search-categoriess button:focus {
  box-shadow: none;
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
