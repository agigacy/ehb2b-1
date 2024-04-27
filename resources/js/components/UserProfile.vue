<template>
  <v-container fluid>
    <v-row>
      <v-col cols="12" md="3">
        <v-card>
          <v-list>
            <v-list-item @click="currentPage = 'users'">
              <v-list-item-action>
                <span class="material-icons pr-1">face</span>
              </v-list-item-action>
              <v-list-item-content>My Profile</v-list-item-content>
            </v-list-item>
          </v-list>
        </v-card>
      </v-col>
      <v-col cols="12" md="9">
        <v-card v-if="currentPage === 'users'">
          <v-card-title>My Profile Details</v-card-title>
          <v-card-text>
            <v-row>
              <v-col cols="6">
                <v-col>Name: {{ editingUser.name }}</v-col>
                <v-col>Email: {{ editingUser.email }}</v-col>
                <v-col>Role: {{ editingUser.roles.map(role => role.name).join(', ') }}</v-col>
              </v-col>
              <v-col cols="6">
                <div>Group Information</div>
                <div>Group Name: {{ editingUser.groups.map(group => group.name).join(', ') }}</div>
                <div>SSM Number: {{ editingUser.groups.map(group => group.ssm_number).join(', ') }}</div>
                <div>Address: {{ editingUser.groups.map(group => group.address).join(', ') }}</div>
                <div>Phone: {{ editingUser.groups.map(group => group.phone).join(', ') }}</div>
                <div>Email: {{ editingUser.groups.map(group => group.email).join(', ') }}</div>
                <div>Website: {{ editingUser.groups.map(group => group.website).join(', ') }}</div>
              </v-col>
            </v-row>
          </v-card-text>
          <v-btn class="m-2" color="primary" @click="currentPage = 'editUser'">Edit My Details</v-btn>
        </v-card>
        <v-card v-if="currentPage === 'editUser'">
          <v-card-title>Edit User</v-card-title>
          <v-card-text>
            <v-form @submit.prevent="editUser">
              <v-text-field label="Name" type="text" v-model="editingUser.name" required></v-text-field>
              <v-text-field label="Email" type="email" v-model="editingUser.email" required></v-text-field>
              <v-text-field label="Password" type="password" v-model="editingUser.password" required></v-text-field>
              <v-btn @click="currentPage = 'users'">Cancel</v-btn>
              <v-btn type="submit" color="primary" >Save</v-btn>
            </v-form>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>
  
  <script>
  import axios from 'axios';
  // import VueApexCharts from 'vue-apexcharts'
  export default {
    data() {
      return {
        name: '',
        email: '',
        password: '',
        currentPage: 'users', // 'users', 'addUser', 'editUser', 'groups', 'addGroup', 'editGroup'
        searchUser: '',
        editingUser: {
          name: '',
          email: '',
          password: '',
        },
        users: [],
      }
    },
    mounted() {
      this.getUsers();
    },
    created() {
      axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('token')}`;
    },
    methods: {
      showUsersPage() {
        this.currentPage = 'users';
      },
     
      showEditUserPage(user) {
        this.editingUser = Object.assign({}, user);
        this.editingUserGroups = user.groups && user.groups.length > 0 ? user.groups[0].id : null;
        this.editingUserRoles = user.roles && user.roles.length > 0 ? user.roles[0].id : null;
        this.currentPage = 'editUser';
      },
      getUsers() {
        const userId = localStorage.getItem('user_id');
        axios.get(`/api/users/${userId}`)
          .then(response => {
              this.editingUser = response.data.data; // 假设返回的数据直接是用户对象
          })
          .catch(error => {
            console.log(error);
          });
      },
      editUser() {
        const userData = {
          ...this.editingUser,
        };
        if (this.editingUser.password) {
          userData.password = this.editingUser.password;
        }
        axios.put(`/api/users/current/${this.editingUser.id}`, userData)
        .then(response => {
          console.log(response.data);
          this.currentPage = 'users';
          this.getUsers();
        })
        .catch(error => {
          console.log(error);
        });
      },
    }
  };
  </script>