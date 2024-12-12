<template>
  <div class="container-fluid header py-4">
    <div class="container">
      <div class="row">
        <div class="col-12 col-md-5">
          <div class="header__title link" @click="$router.push('/')">
            User balances app
          </div>
        </div>
        <div class="col-12 col-md-3 mt-3 mt-md-auto my-auto">
          <div class="menu-block">
            <span v-for="mi in menuItems"
                  :key="mi.title"
                  class="menu-block__item me-5"
            >
              <a class="link" @click="$router.push(mi.link)">{{ mi.title }}</a>
          </span>
          </div>
        </div>
        <div class="col-12 col-md-4 mt-md-auto my-auto">
          <div class="float-end">
            <span class="userinfo">{{ userLogin }}</span>
            <button class="ms-2 btn-logout" @click="logout()">Logout</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
// services
import {userService} from '@/services/services';
import {removeToken} from "@/util/cookies";

export default {

  data() {
    return {
      user: null,
      menuItems: [
        {title: 'Home', link: '/'},
        {title: 'About', link: '/about'},
      ],
    }
  },
  async mounted() {
    await this.loadUser()
  },
  methods: {
    async loadUser() {
      try {
        let response = await userService.getUser()
        if (response.data.success === true) {
          this.user = response.data.user;
        } else {
          removeToken();
        }
      } catch (error) {
        removeToken();
      }
    },

    async logout(){
      try {
        let response = await userService.logout()
        if (response.data.success === true) {
          this.user = response.data.user;
          removeToken();
        }
      } catch (error) {
        removeToken();
      }
    }
  },
  computed: {
    userLogin() {
      if (this.user && this.user.email) {
        return this.user.email;
      }
      return '';
    }
  }
}
</script>

<style lang="scss" scoped>
.header {
  background-color: #eeeeee;

  &__title {
    font-family: $primary-font;
    font-weight: 500;
    font-size: 20px;
    line-height: 28px;

    padding: 6px 10px;
    border-radius: 8px;
    color: $primary-color;
  }
}

.menu-block {
  &__item {
    font-family: $primary-font;
    font-weight: 500;
    font-size: 16px;

    border-radius: 8px;
    color: $primary-color;
  }

  &__item:hover {
    text-decoration: underline;
  }
}

.userinfo {
  font-family: $primary-font;
  font-weight: 600;
  font-size: 14px;

  border-radius: 8px;
  color: $primary-color;
}

.link {
  cursor: pointer;
}

a {
  color: $primary-color;
}

@media (min-width: 0px) { // XS+
  .header {
    &__title {
      font-size: 20px;
      padding: 0;
    }
  }

  .menu-block {
    &__item {
      font-size: 14px;
    }
  }

  .userinfo {
    font-size: 12px;
  }
}

.btn-logout{
  border: 1px solid $primary-color !important;
  border-radius: 4px;
  padding: 4px 8px;
}


@media (min-width: 768px) { // MD+
  .menu-block {
    &__item {
      font-size: 16px;
    }
  }
}

@media (min-width: 1200px) { // XL+
  .header {
    &__title {
      font-size: 22px;
      padding: 0;
    }
  }
  .userinfo {
    font-size: 15px;
  }
}

</style>
