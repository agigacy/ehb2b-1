<template>
  <v-app>
    <v-toolbar color="indigo" dark class="custom-toolbar">
      <v-toolbar-title>Tour App</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-toolbar-items>
        <v-btn text to="/">Home Page</v-btn>
        <v-btn text to="/admin" v-if="isLoggedIn">Admin Page</v-btn>
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
  }
}
</script>
<style>
.custom-toolbar {
  max-height: 70px;
}
</style>