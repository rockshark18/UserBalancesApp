<template>
  <div class="container py-1 mt-3">

    <div class="row p-0">
      <div class="col-3 col-md-2 p-0">
        <div class="text">Search:</div>
      </div>
      <div class="col-9 col-md-10">
        <input id="search"
               type="text"
               class="input-text"
               v-model="searchString"
        />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      searchString: '',
    }
  },
  mounted() {
  },
  methods: {
    handleSearchStringChange() {
      this.searchString = this.ltrim(this.searchString);
      this.$emit('searchChanged', this.searchString);
    },
    ltrim(str) {
      if (!str) return str;
      return str.replace(/^\s+/g, '');
    },
  },
  watch: {
    searchString(newValue, oldValue) {
      this.handleSearchStringChange();
    },
  },
}
</script>

<style lang="scss" scoped>
.text {
  font-family: $primary-font;
  font-weight: 500;
  font-size: 18px;
  line-height: 28px;

  padding: 6px 10px;
  border-radius: 8px;
  color: $primary-color;
}

@media (min-width: 0px) { // XS+
  .text {
    font-size: 14px;
  }
}

@media (min-width: 768px) { // MD+
  .text {
    font-size: 16px;
  }
}

@media (min-width: 1200px) { // XL+
  .text {
    font-size: 18px;
  }
}

</style>

