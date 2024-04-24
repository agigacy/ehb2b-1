<template>
  <v-app>
    <v-toolbar color="indigo" dark class="custom-toolbar">
      <!-- <v-toolbar-title>Tour App</v-toolbar-title> -->
      <v-toolbar-title><img src="/images/esplanad-logo-small.png" class="mt-4" style="height: 50px;" /></v-toolbar-title>
      <v-spacer></v-spacer>
      <v-toolbar-items>
        <v-btn text to="/">Home Page</v-btn>
        <v-btn text to="/admin" v-if="isLoggedIn && canViewAdminPage">Admin Page</v-btn>
        <v-btn text to="/report" v-if="isLoggedIn">Report Page</v-btn>
        <v-btn text to="/tour" v-if="isLoggedIn">Tour Page</v-btn>
        <v-btn text to="/tourpackage" v-if="isLoggedIn">Tour Package</v-btn>
        <v-btn text to="/agent" v-if="isLoggedIn">Agent Page</v-btn>
        <v-btn text to="/login" v-if="!isLoggedIn">Login</v-btn>
        <v-btn text @click.prevent="logout" v-if="isLoggedIn">Logout</v-btn>
      </v-toolbar-items>
    </v-toolbar>
    <v-main>
      <router-view></router-view>
    </v-main>
  </v-app>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      isLoggedIn: !!localStorage.getItem('token')
    }
  },
  created() {
    if (this.isLoggedIn) {
      axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('token')}`;
    }
  },
  watch: {
    '$route': function() {
      this.isLoggedIn = !!localStorage.getItem('token');
    }
  },
  computed: {
    // 判断用户是否有 admin_page_view 权限
    canViewAdminPage() {
    const permissions = JSON.parse(localStorage.getItem('permissions') || '[]');
    const userid = JSON.parse(localStorage.getItem('user_id') || '[]');
    console.log("Permissions from localStorage:", permissions); // 输出权限数据
    const hasPermission = permissions.includes('admin_page_view');
    console.log("Can view admin page:", hasPermission); // 输出是否有权限
    console.log("User ID" , userid)
    return hasPermission;
    
  }
  },
  methods: {
    logout() {
      // Send a request to the logout API
      axios.post('/api/auth/logout', {}, {
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('token')}`
        }
      })
      .then(() => {
        // Remove the token from localStorage
        localStorage.removeItem('token');

        // Redirect to the login page
        this.$router.push('/');
      })
      .catch(error => {
        console.log(error);
      });
    }
  },
  // mounted() {
  //   if (this.isLoggedIn) {
  //     axios.get('/api/users').then(response => {
  //       // 假设后端返回的用户信息在 response.data 中
  //       this.currentUser = response.data;
  //     }).catch(error => {
  //       console.error("获取用户信息失败:", error);
  //     });
  //   }
  // },
}
</script>
<style>
.custom-toolbar {
  max-height: 70px;
}
</style>