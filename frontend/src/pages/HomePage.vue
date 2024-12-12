<template>
  <Debug/>

  <div class="container-fluid busy-line p-0">
    <div v-if="busy" class="progress busy-line" style="--bs-progress-border-radius: 0">
      <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%; border-radius: 0"></div>
    </div>
  </div>

  <Navbar/>

  <div class="content mt-2">
    <!-- busy -->
    <!--
    <div class="container text-center busy-line mt-3">
      <div v-if="busy">
        <div class="spinner-grow busy-item mx-1" role="status"></div>
        <div class="spinner-grow busy-item mx-1" role="status"></div>
        <div class="spinner-grow busy-item mx-1" role="status"></div>
        <div class="spinner-grow busy-item mx-1" role="status"></div>
        <div class="spinner-grow busy-item mx-1" role="status"></div>
      </div>
    </div>
    -->

    <UserBalance ref="userBalance"/>
    <SearchBar
        @searchChanged="onSearchChanged"
    />
    <TransactionList
        :key="refreshKey"
        class="my-2"
        :transactions="transactions"
        :search="searchString"
        :sortBy="sortBy"
        :sortDir="sortDir"
        @sort="onSort"
        :sortMetadata="sortMetadata"
    />
  </div>

  <Footer class="mt-4"/>
</template>

<script>
import Const from '@/common/const';
import {formatDateTime} from '@/util/datetimeFormatter';

// services
import {transactionService} from '@/services/services';

// vue components
import Navbar from "@/components/common/Navbar.vue";
import Footer from "@/components/common/Footer.vue";
import Debug from "@/components/common/Debug.vue";
import TransactionList from "@/components/TransactionList.vue";
import SearchBar from "@/components/SearchBar.vue";
import UserBalance from "@/components/UserBalance.vue";

export default {
  components: {
    Debug,
    Footer,
    Navbar,
    TransactionList,
    SearchBar,
    UserBalance,
  },
  data() {
    return {
      transactions: [],
      searchString: null,

      // sort default
      sortBy: Const.TRANSACTION_SORT.DATE,
      sortDir: Const.SORT.ASC,

      refreshKey: 0,

      busy: false,

      sortMetadata: {
        [Const.TRANSACTION_SORT.ID]: {'field': 'id'},
        [Const.TRANSACTION_SORT.TYPE]: {'field': 'type'},
        [Const.TRANSACTION_SORT.AMOUNT]: {'field': 'amount', 'convertToNumber': true},
        [Const.TRANSACTION_SORT.DESC]: {'field': 'desc'},
        [Const.TRANSACTION_SORT.DATE]: {'field': 'created_at'},
      },
    }
  },
  async mounted() {
    await this.loadTransactions();

    this.$nextTick(() => {
      this.initTimer();
    });
  },
  methods: {
    async loadTransactions() {
      this.busy = true;
      try {
        this.transactions = await transactionService.get(
            this.searchString,
            Const.HOME_PAGE_TRANSACTIONS_LIMIT
        );
        // post process
        this.transactions.forEach((t) => {
          t.created_at = formatDateTime(t.created_at);
          t.type = this.capitalizeFirstLetter(t.type.toLowerCase());
        });
        this.sort();
        this.busy = false;
      } catch (e) {
        throw e;
      }
    },
    capitalizeFirstLetter(str) {
      return str[0].toUpperCase() + str.slice(1);
    },
    sort(sortBy, sortDir) {
      if (sortBy == null) {
        sortBy = this.sortBy;
      }
      if (sortDir == null) {
        sortDir = this.sortDir;
      }

      let metaItem = this.sortMetadata[sortBy];
      if (metaItem) {
        this.sortDir = sortDir
        if (this.sortDir === Const.SORT.DESC) {
          this.transactions.sort((a, b) => {
            let va = a[metaItem.field];
            let vb = b[metaItem.field];
            if (metaItem.convertToNumber) {
              va = Number(va);
              vb = Number(vb);
            }

            if (va < vb) {
              return -1
            }
            if (va >= vb) {
              return 1
            }
            return 0
          })
        } else if (this.sortDir === Const.SORT.ASC) {
          this.transactions.sort((a, b) => {
            let va = a[metaItem.field];
            let vb = b[metaItem.field];
            if (metaItem.convertToNumber) {
              va = Number(va);
              vb = Number(vb);
            }

            if (va < vb) {
              return 1
            }
            if (va >= vb) {
              return -1
            }
            return 0
          })
        }
      }
    },
    //events
    onSort(sortBy) {
      if (this.sortBy === sortBy) { // change dir
        let dir = this.sortDir

        if (dir === Const.SORT.ASC) {
          this.sort(sortBy, Const.SORT.DESC)
        } else if (dir === Const.SORT.DESC) {
          this.sort(sortBy, Const.SORT.ASC)
        }
      } else {
        this.sortBy = sortBy
        this.sort(sortBy, Const.SORT.ASC)
      }
      this.refresh()
    },
    refresh() {
      this.refreshKey++;
    },

    onSearchChanged(searchString) {
      this.searchString = searchString;
      this.loadTransactions();
    },

    initTimer(){
      setInterval(() => {
        this.$refs.userBalance.loadUserbalance();
        this.loadTransactions();
      }, Const.AUTO_REFRESH_MS);
    }
  },
}
</script>

<style lang="scss" scoped>
.content {
  background-color: $primary-background-color;
  min-height: 650px;
}
.busy{
  &-line{
    height: 11px;
    background-color: #eeeeee;

  }
}

</style>
