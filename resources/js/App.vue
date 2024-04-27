<template>
  <v-app>
    <v-toolbar color="blank" light class="custom-toolbar">
      <!-- <v-toolbar-title>Tour App</v-toolbar-title> -->
      <v-toolbar-title>
        <router-link target="_self"
          to="/"
          >
          <img src="/images/esplanad-logo-small.png" class="mt-4" style="height: 50px;" /> <small>B2B 1.0</small>
        </router-link>                            
      </v-toolbar-title>
      <v-spacer></v-spacer>
      <v-toolbar-items>
        <v-btn text to="/">Home</v-btn>
        <v-btn text to="/admin" v-if="isLoggedIn && canViewAdminPage">Admin</v-btn>
        <v-btn text to="/report" v-if="isLoggedIn">Report</v-btn>
        <v-btn text to="/tour" v-if="isLoggedIn">Tour Setting</v-btn>
        <v-btn text to="/tourpackage" v-if="isLoggedIn">Tour Booking</v-btn>
        <v-btn text to="/agent" v-if="isLoggedIn">Agent</v-btn>
        <v-btn text to="/login" v-if="!isLoggedIn">Login</v-btn>
        <v-btn text to="/userprofile" v-if="isLoggedIn"><span class="material-icons pr-1">face</span> <h6> {{ $username() }} ({{ $userId() }})</h6></v-btn>
        <v-btn text to="/notification" v-if="isLoggedIn"><span class="material-symbols-outlined pr-1"> notifications</span> Notification</v-btn>
        <v-btn text @click.prevent="logout" v-if="isLoggedIn">Logout</v-btn>
        <div class="container-fluid w-100 p-0 control_top">
            <!-- <notification-component class="w-100" v-if="!($route.path == '/timer') && !($route.path == '/test5')"></notification-component> -->
            <!-- <notification-component class="w-100 mb-0"></notification-component> -->
            <!-- <span class="material-icons mt-4">face</span> -->
            <!-- <span class="material-icons">&#xE87C;</span> -->
        </div>
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
    };
    const user_id = localStorage.getItem('user_id');
  },
  watch: {
    '$route': function() {
      this.isLoggedIn = !!localStorage.getItem('token');
    }
  },
  computed: {
    // 判断用户是否有 admin_page_view 权限
    // userId() {
    //   return localStorage.getItem('user_id');
    // },
    // username() {
    //   return localStorage.getItem('username');
    // },
    canViewAdminPage() {
    const permissions = JSON.parse(localStorage.getItem('permissions') || '[]');
    const userid = JSON.parse(localStorage.getItem('user_id') || '[]');
    const username = localStorage.getItem('username')
    console.log("Permissions from localStorage:", permissions); // 输出权限数据
    const hasPermission = permissions.includes('admin_page_view');
    console.log("Can view admin page:", hasPermission); // 输出是否有权限
    console.log("User ID" , userid)
    console.log("User Name" , username)
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