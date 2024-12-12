<template>
  <div class="container p-0">
    <div class="row row-base px-0 py-2 text" :class="typeClass">
      <div class="col-1 d-none d-sm-block align-self-start">{{ entity.id }}</div>
      <div class="col-2 col-lg-1 align-self-start px-0  ps-1">{{ entity.type }}</div>
      <div class="col-2 col-lg-1 text-end px-0">{{ entity.amount }}</div>
      <div class="col-4 col-lg-7" v-html="descHighlighted"></div>
      <div class="col-4 col-sm-3 col-lg-2 text-end ">{{ entity.created_at }}</div>
    </div>
  </div>
</template>

<script>
import Const from '@/common/const';

export default {
  props: {
    transaction: {
      type: Object,
      required: true,
    },
    search: {
      type: String,
      required: false,
    }
  },
  data() {
    return {
      entity: null,
      typeClass: "",
    }
  },
  created() {
    this.init();
  },
  computed: {
    descHighlighted() {
      if (this.search) {
        const search = this.search.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'); // ekranirovanie / security
        const regex = new RegExp(search, 'gi');
        return this.entity.desc.replace(regex, (match) => `<b>${match}</b>`);
      } else {
        return this.entity.desc
      }
    }
  },
  methods: {
    init() {
      this.entity = this.transaction;
      if (this.entity.type === Const.TRANSACTION_TYPE.INCOME) {
        this.typeClass = 'row-income';
      } else if (this.entity.type === Const.TRANSACTION_TYPE.EXPENSE) {
        this.typeClass = 'row-expense';
      }
    },
  },
}
</script>

<style lang="scss" scoped>
.text {
  font-family: $primary-font;
  font-weight: 500;
  font-size: 16px;

  color: $primary-color;
}

.row {
  cursor: pointer;

  &-base {
    border-bottom: 1px solid #ddd;
  }

  &-income {
    background-color: #edffed;

    &:hover {
      background-color: #ccffcc;
    }
  }

  &-expense {
    background-color: #ffeded;

    &:hover {
      background-color: #ffdddd;
    }
  }
}

@media (min-width: 0px) { // XS+
  .text {
    font-size: 11px;
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
