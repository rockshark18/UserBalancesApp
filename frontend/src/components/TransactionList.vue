<script setup>
import Const from '@/common/const';
</script>

<template>
  <div class="container">
    <h2 class="title">Transactions</h2>
    <!-- header-->
    <div class="px-2">
      <div class="row row-base py-2 text prevent-select">

        <div class="col-1 d-none d-sm-block align-self-start"
             @click="onSortClick(Const.TRANSACTION_SORT.ID)"
        >
          {{ getSortChar(Const.TRANSACTION_SORT.ID) }}ID
        </div>

        <div class="col-2 col-lg-1 align-self-start px-0 ps-1"
             @click="onSortClick(Const.TRANSACTION_SORT.TYPE)"
        >
          {{ getSortChar(Const.TRANSACTION_SORT.TYPE) }}Type
        </div>

        <div class="col-2 col-lg-1 text-end px-0"
             @click="onSortClick(Const.TRANSACTION_SORT.AMOUNT)"
        >
          {{ getSortChar(Const.TRANSACTION_SORT.AMOUNT) }}Amount
        </div>

        <div class="col-4 col-lg-7 ps-3"
             @click="onSortClick(Const.TRANSACTION_SORT.DESC)"
        >
          {{ getSortChar(Const.TRANSACTION_SORT.DESC) }}Description
        </div>

        <div class="col-4 col-sm-3 col-lg-2 text-end pe-3"
             @click="onSortClick(Const.TRANSACTION_SORT.DATE)"
        >
          {{ getSortChar(Const.TRANSACTION_SORT.DATE) }}Created
        </div>
      </div>
    </div>
    <TransactionListItem
        v-for="t in transactions"
        :key="t.id"
        :transaction="t"
        :search="search"
        class="px-2"
    />
  </div>
</template>

<script>
// components
import TransactionListItem from "@/components/TransactionListItem.vue";

export default {
  props: {
    transactions: {
      type: Array,
      required: true
    },
    search: {
      type: String,
      required: false,
    },
    sortBy: {
      type: String,
      required: true,
    },
    sortDir: {
      type: Number,
      required: true,
    },
    sortMetadata:{
      type: Object,
      required: false,
    }
  },
  components: {
    TransactionListItem,
  },
  data() {
    return {}
  },
  methods: {
    getSortChar(sortBy) {
      let char = ' '
      if (this.sortMetadata[sortBy]) {
        if (this.sortBy === sortBy) {
          if (this.sortDir === Const.SORT.ASC) {
            char = '⏶';//'↑'
          } else if (this.sortDir === Const.SORT.DESC) {
            char = '⏷';//'↓';
          }
        }
        return char + ' ';
      }
      return char;
    },
    // events
    onSortClick(sortBy) {
      this.$emit('sort', sortBy);
    }
  },
}
</script>

<style lang="scss" scoped>
.title {
  font-family: $primary-font;
  font-weight: 600;
  font-size: 20px;
  line-height: 30px;

  color: $primary-color;
}

.text {
  font-family: $primary-font;
  font-weight: 600;
  font-size: 16px;

  color: white;
}

.row {
  cursor: pointer;

  &-base {
    background-color: #555;
  }
}

@media (min-width: 0px) { // XS+
  .text {
    font-size: 12px;
  }
}

@media (min-width: 768px) { // MD+
  .text {
    font-size: 14px;
  }
}

@media (min-width: 1200px) { // XL+
  .text {
    font-size: 16px;
  }
}

</style>
