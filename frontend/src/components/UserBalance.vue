<template>
  <div class="container p-0">
    <div class="text-end">
      <div class="text">Current balance: {{ balance }}</div>
    </div>
  </div>
</template>

<script>
// services
import {userBalanceService} from '@/services/services';
import {removeToken} from "@/util/cookies";

export default {
  data() {
    return {
      userbalance: null,
    }
  },
  async mounted() {
    await this.loadUserbalance();
  },
  computed: {
    balance() {
      if (this.userbalance) {
        return this.userbalance.balance;
      }
      return '--';
    }
  },
  methods: {
    async loadUserbalance() {
      try {
        this.userbalance = await userBalanceService.getBalance();
      } catch (error) {
        removeToken();
      }
      try {
      } catch (e) {
        throw e;
      }
    },
  },
}
</script>

<style lang="scss" scoped>
.text {
  font-family: $primary-font;
  font-weight: 600;
  font-size: 16px;

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

