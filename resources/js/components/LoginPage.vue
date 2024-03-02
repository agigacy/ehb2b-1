<template>
  <v-app style="background-color: gray; no-repeat center center; background-size: cover;">
    <v-main>
      <v-container fill-height fluid>
        <v-layout align-center justify-center>
          <v-flex xs12 sm8 md4>
            <v-card>
              <v-card-title>Login</v-card-title>
              <v-card-text>
                <v-form @submit.prevent="login">
                  <v-text-field label="Email" type="email" v-model="email" required></v-text-field>
                  <v-text-field label="Password" type="password" v-model="password" required></v-text-field>
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
      password: ''
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
        // Save the token
        localStorage.setItem('token', response.data.token);
        this.$router.push('/admin');
      })
      .catch(error => {
        console.log(error);
      });
    }
  }
}
</script>