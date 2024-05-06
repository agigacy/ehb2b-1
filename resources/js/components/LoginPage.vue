<template>
  <!-- <v-app style="background-color: gray; no-repeat center center; background-size: cover;"> -->
  <v-app style="background: url('images/esp_backgrond.jpg') no-repeat center center / cover;">
    <v-main>
      <v-container fill-height fluid>
        <v-layout align-center justify-center>
          <v-flex xs12 sm8 md4>
            <v-card>
              <v-card-title>B2B Login <sup class="pl-2">v1.0.1</sup></v-card-title>
              <v-card-text>
                <v-form @submit.prevent="login">
                  <v-text-field label="Email" type="email" v-model="email" required></v-text-field>
                  <v-text-field label="Password" type="password" v-model="password" required></v-text-field>
                  <div v-if="loginError" class="error-message">{{ loginError }}</div>
                  <v-btn type="submit">Login</v-btn>
                </v-form>
              </v-card-text>
            </v-card>
          </v-flex>
        </v-layout>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      email: '',
      password: '',
      loginError: ''
    }
  },
  methods: {
    login() {
      axios.post('/api/auth/login', {
        email: this.email,
        password: this.password,
        device_name: 'browser'
      })
      .then(response => {
        // 保存 token
        localStorage.setItem('token', response.data.token);
        // 保存用户 ID
        localStorage.setItem('user_id', response.data.user_id);
        localStorage.setItem('username', response.data.username);
        // 保存角色和权限信息
        localStorage.setItem('roles', JSON.stringify(response.data.roles));
        localStorage.setItem('permissions', JSON.stringify(response.data.permissions));
         // 检查并保存权限数据
        // if (response.data.permissions) {
        //   localStorage.setItem('permissions', JSON.stringify(response.data.permissions));
        // } else {
        //   console.error("No permissions data received");
        // }

        // 导航到管理员页面
        this.$router.push('/admin');
      })
      .catch(error => {
        // 设置登录错误消息
        if (error.response && error.response.data) {
          // 这里假设后端返回的错误信息在 error.response.data 中
          // 你可能需要根据你的API响应结构调整这里的代码
          this.loginError = 'Email or password is incorrect.';
        } else {
          this.loginError = 'An error occurred. Please try again.';
        }
      });
    }
  }
}
</script>
<style>
.error-message {
  color: red;
  margin-bottom: 10px;
}
</style>