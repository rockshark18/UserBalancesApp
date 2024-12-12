<template>
  <Debug/>

  <div class="container">

    <div class="row mt-5">
      <div class="col-12 col-md-9 col-lg-7 col-xl-6 col-xxl-5 mx-auto mt-5">

        <h1 class="text-center">Login</h1>

        <form class="mt-4" @submit.prevent="login">

          <div class="row mb-3">
            <div class="col-12 p-0">
              <label for="email" class="label">Email</label>
            </div>
            <div class="col-12">
              <input id="email"
                     type="email"
                     class="input-email"
                     v-model="email"
                     required
              />
            </div>
          </div>

          <div class="row mb-2">
            <div class="col-12 p-0">
              <label for="password" class="label">Password</label>
            </div>
            <div class="col-12">
              <input id="password"
                     type="password"
                     class="input-password"
                     v-model="password"
                     required
              />
            </div>
          </div>

          <div class="row">
            <div class="col-12 p-0">
              <div class="label label-red">{{error}}</div>
            </div>
          </div>


          <button type="submit" class="button-login mt-2">Login</button>

        </form>

      </div>
    </div>

  </div>
</template>

<script>
// services
import {userService} from '@/services/services';
import {setToken} from '@/util/cookies';

// vue components
import Debug from "../components/common/Debug.vue";

export default {
  components: {Debug},
  data() {
    return {
      email: '',
      password: '',
      error: null,
    };
  },
  methods: {
    async login() {
      try {
        let response = await userService.login(this.email, this.password)
        if (response.data.success === true){
          console.log('set token = '+response.data.access_token)
          setToken(response.data.access_token);
          this.$router.push('/');
        }
      } catch (error) {
        this.error = error;
      }
    },
  },
};
</script>

<style lang="scss" scoped>

.label {
  font-family: $primary-font;
  font-weight: 600;
  font-size: 16px;
  line-height: 28px;

  padding: 6px 10px;
  border-radius: 8px;
  color: $primary-color;

  &-red{
    font-size: 14px;
    color: red;
  }
}

.button {
  &-login {
    background-color: $default-color;


    font-family: $primary-font;
    font-weight: 600;
    font-size: 16px;
    line-height: 28px;

    padding: 6px 24px;
    border-radius: 8px;
    color: white;
  }
}

</style>
