<template>
  <v-app>
    <v-toolbar color="blank" light class="custom-toolbar">
      <!-- <v-toolbar-title>Tour App</v-toolbar-title> -->
      <v-toolbar-title>
        <router-link target="_self"
          to="/"
          >
          <img src="/images/esplanad-logo-small.png" class="mt-4 mx-4" style="height: 50px;" />
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
        <v-btn text to="/notification" v-if="isLoggedIn"><span class="material-symbols-outlined pr-1"> notifications</span> Notification(s)</v-btn>
        <v-btn text to="/reminder" v-if="isLoggedIn"><span class="material-symbols-outlined pr-1"> notifications</span> Reminder(s)</v-btn>
        <v-btn text @click="toggleDropdown" v-if="isLoggedIn"> <!-- Add click event to toggle dropdown -->
          <v-menu v-model="dropdown" :close-on-content-click="false" offset-y>
              <template v-slot:activator="{ on }">
                  <span v-on="on" title="Notification">
                      <!-- <center><span class="material-symbols-outlined btn btn-info btn-md p-2">sms</span></center> -->
                      <center><span class="material-symbols-outlined btn btn-info btn-md p-2">sms</span></center>
                  </span>
              </template>
              <v-list style="min-width: 240px;">
                  <v-list-item @click="handleDropdownItemClick('Option 1')">Option 1</v-list-item> <!-- Replace 'Option 1' with your actual options -->
                  <v-list-item @click="handleDropdownItemClick('Option 2')">Option 2</v-list-item> <!-- Replace 'Option 2' with your actual options -->
                  <v-list-item @click="handleDropdownItemClick('Option 3')">Option 3</v-list-item> <!-- Replace 'Option 2' with your actual options -->
                  <v-list-item @click="handleDropdownItemClick('Option 4')">Option 4</v-list-item> <!-- Replace 'Option 2' with your actual options -->
                  <!-- Add more list items as needed -->
              </v-list>
          </v-menu>
        </v-btn>
        <!-- <div>
          <div class="fontsearch mr-1 mt-2">                        
              <button
                  type="button"
                  class="btn btn-info btn-md p-1"
                  @click="showAlert"
                  title="Notification"
                  >
                  <center><span class="material-symbols-outlined">sms</span></center>
              </button>
          </div>
        </div> -->

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
      isLoggedIn: !!localStorage.getItem('token'),
      dropdown: false
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
      if (confirm("Confirm to log out?")) {
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
      } else {
          // User cancelled logout, do nothing
          return false;
      }
  },
    logout_OLD() {
      if (confirm("Confirm to log out?")) {

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
      } else {
        // User cancelled logout, do nothing
        return false;
      }
    },

    showAlert() {
      alert("You clicked on the face!");
    },
    toggleDropdown() {
        this.dropdown = !this.dropdown;
    },
    handleDropdownItemClick(option) {
        // Handle click on dropdown items
        console.log('Selected option:', option);
        // Perform any necessary action here, like opening another page or executing a function
        // You can close the dropdown here if needed
        this.dropdown = false;
    },
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