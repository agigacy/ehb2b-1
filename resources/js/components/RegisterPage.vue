<template>
  <v-app>
    <v-main>
      <v-container fill-height fluid>
        <v-layout align-center justify-center>
          <v-flex xs12 sm8 md4>
            <v-card>
              <v-card-title>Register</v-card-title>
              <v-card-text>
                <v-form @submit.prevent="register">
                  <v-text-field label="Name" type="text" v-model="name" required></v-text-field>
                  <v-text-field label="Email" type="email" v-model="email" required></v-text-field>
                  <v-text-field label="Password" type="password" v-model="password" required></v-text-field>
                  <v-btn type="submit">Register</v-btn>
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
      name: '',
      email: '',
      password: ''
    }
  },
  methods: {
    register() {
      axios.post('/api/register', {
        name: this.name,
        email: this.email,
        password: this.password
      })
      .then(response => {
        console.log(response.data);
        // Redirect to /foo page after successful registration
        this.$router.push('/foo');
      })
      .catch(error => {
        console.log(error);
      });
    }
  }
}
</script>