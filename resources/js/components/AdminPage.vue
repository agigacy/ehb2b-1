<template>
  <v-container fluid>
    <v-row>
      <v-col cols="12" md="3">
        <v-card>
          <v-list>
            <v-list-item @click="currentPage = 'dashboard'">
              <v-list-item-action>
                <v-icon>mdi-view-dashboard</v-icon>
              </v-list-item-action>
              <v-list-item-content>Dashboard</v-list-item-content>
            </v-list-item>
            <v-list-item @click="currentPage = 'users'">
              <v-list-item-action>
                <v-icon>mdi-account-multiple</v-icon>
              </v-list-item-action>
              <v-list-item-content>Users</v-list-item-content>
            </v-list-item>
            <v-list-item @click="currentPage = 'groups'">
              <v-list-item-action>
                <v-icon>mdi-account-group</v-icon>
              </v-list-item-action>
              <v-list-item-content>Groups</v-list-item-content>
            </v-list-item>
            <!-- Add more items here -->
          </v-list>
        </v-card>
      </v-col>
      <v-col cols="12" md="9">
        <v-card v-if="currentPage === 'dashboard'">
          <v-card-title>Dashboard</v-card-title>
          <v-card-text>
            <v-row>
              <v-col cols="12" sm="6" md="4">
                <!-- Grid 1 content here -->
                <v-sheet
                  class="v-sheet--offset mx-auto"
                  color="cyan"
                  elevation="12"
                  max-width="calc(100% - 32px)"
                >
                  <v-sparkline
                    :labels="labels"
                    :value="value"
                    color="white"
                    line-width="2"
                    padding="16"
                  ></v-sparkline>
                </v-sheet>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <!-- Grid 2 content here -->
                
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <!-- Grid 3 content here -->
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" sm="6" md="4">
                <!-- Grid 4 content here -->
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <!-- Grid 5 content here -->
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <!-- Grid 6 content here -->
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
        <v-card v-if="currentPage === 'users'">
          <v-card-title>Users</v-card-title>
          <v-card-text>
              <v-text-field v-model="searchUser" append-icon="mdi-magnify" label="Search" single-line hide-details></v-text-field>
              <v-data-table
                :headers="userHeaders"
                :items="users"
                :search="searchUser"
                :custom-filter="customFilter"
                :footer-props="{ itemsPerPageOptions: [5, 10, 25, 50] }"
              >
              <template v-slot:item.index="{ index }">
                {{ index + 1 }}
              </template>
              <template v-slot:item.group="{ item }">
                {{ item.groups?.map(group => group.name).join(', ') }}
              </template>
              <template v-slot:item.actions="{ item }">
                <v-btn small color="blue darken-1" text @click="showEditUserPage(item)">
                  <v-icon small>mdi-pencil</v-icon>
                  Edit
                </v-btn>
                <v-btn small color="red darken-1" text @click="startDeletingUser(item)">
                  <v-icon small>mdi-delete</v-icon>
                  Delete
                </v-btn>
              </template>
            </v-data-table>
            <v-btn @click="currentPage = 'addUser'">Add User</v-btn>
          </v-card-text>
        </v-card>
        <v-card v-if="currentPage === 'addUser'">
          <v-card-title>Add User</v-card-title>
          <v-card-text>
            <v-form @submit.prevent="addUser">
              <v-text-field label="Name" type="text" v-model="name" required></v-text-field>
              <v-text-field label="Email" type="email" v-model="email" required></v-text-field>
              <v-text-field label="Password" type="password" v-model="password" required></v-text-field>
              <v-select
                label="Groups"
                v-model="newUserGroups"
                :items="groups"
                item-value="id"
                item-text="name"
                >
              </v-select>
              <v-select
                label="Roles"
                v-model="newUserRoles"
                :items="roles"
                item-value="id"
                item-text="name"
              >
              </v-select>
              <v-btn @click="currentPage = 'users'">Back</v-btn>
              <v-btn type="submit">Add User</v-btn>
            </v-form>
          </v-card-text>
        </v-card>
        <v-card v-if="currentPage === 'editUser'">
          <v-card-title>Edit User</v-card-title>
          <v-card-text>
            <v-form @submit.prevent="editUser">
              <v-text-field label="Name" type="text" v-model="editingUser.name" required></v-text-field>
              <v-text-field label="Email" type="email" v-model="editingUser.email" required></v-text-field>
              <v-text-field label="Password" type="password" v-model="editingUser.password" required></v-text-field>
              <v-select
              label="Groups"
              v-model="editingUserGroups"
              :items="groups"
              item-value="id"
              item-text="name"
              >
              </v-select>
              <v-select
                label="Roles"
                v-model="editingUserRoles"
                :items="roles"
                item-value="id"
                item-text="name"
              >
              </v-select>
              <v-btn @click="currentPage = 'users'">Cancel</v-btn>
              <v-btn type="submit">Save</v-btn>
            </v-form>
          </v-card-text>
        </v-card>
        <v-card v-if="currentPage === 'groups'">
          <v-card-title>Groups</v-card-title>
          <v-card-text>
            <v-data-table :headers="groupHeaders" :items="groups" :footer-props="{ itemsPerPageOptions: [5, 10, 25, 50] }">
              <template v-slot:item.index="{ index }">
                {{ index + 1 }}
              </template>
              <template v-slot:item.sp="{ item }">
                <v-switch disabled :input-value="item.sp"></v-switch>
              </template>
              <template v-slot:item.tier1="{ item }">
                <v-switch disabled :input-value="item.tier1"></v-switch>
              </template>
              <template v-slot:item.tier2="{ item }">
                <v-switch disabled :input-value="item.tier2"></v-switch>
              </template>
              <template v-slot:item.tier3="{ item }">
                <v-switch disabled :input-value="item.tier3"></v-switch>
              </template>
              <template v-slot:item.actions="{ item }">
                <v-btn small color="blue darken-1" text @click="showEditGroupPage(item)">
                  <v-icon small>mdi-pencil</v-icon>
                  Edit
                </v-btn>
                <v-btn small color="red darken-1" text @click="startDeletingGroup(item)">
                  <v-icon small>mdi-delete</v-icon>
                  Delete
                </v-btn>
              </template>
            </v-data-table>
            <v-btn @click="currentPage = 'addGroup'">Add Group</v-btn>
          </v-card-text>
        </v-card>
        <v-card v-if="currentPage === 'addGroup'">
          <v-card-title>Add Group</v-card-title>
          <v-card-text>
            <v-form @submit.prevent="addGroup">
              <v-text-field label="Name" type="text" v-model="newGroup.name" required></v-text-field>
              <v-row>
                <v-col cols="3">
                  <v-switch label="SP" v-model="newGroup.sp"></v-switch>
                </v-col>
                <v-col cols="3">
                  <v-switch label="Tier 1" v-model="newGroup.tier1" @change="handleAddTier1Change"></v-switch>
                </v-col>
                <v-col cols="3">
                  <v-switch label="Tier 2" v-model="newGroup.tier2" @change="handleAddTier2Change"></v-switch>
                </v-col>
                <v-col cols="3">
                  <v-switch label="Tier 3" v-model="newGroup.tier3" @change="handleAddTier3Change"></v-switch>
                </v-col>
              </v-row>
              <v-btn @click="currentPage = 'groups'">Back</v-btn>
              <v-btn type="submit">Add Group</v-btn>
            </v-form>
          </v-card-text>
        </v-card>
        <v-card v-if="currentPage === 'editGroup'">
          <v-card-title>Edit Group</v-card-title>
          <v-card-text>
            <v-form @submit.prevent="editGroup">
              <v-text-field label="Name" type="text" v-model="editingGroup.name" required></v-text-field>
              <v-row>
                <v-col cols="3">
                  <v-switch label="SP" v-model="editingGroup.sp"></v-switch>
                </v-col>
                <v-col cols="3">
                  <v-switch label="Tier 1" v-model="editingGroup.tier1" @change="handleTier1Change"></v-switch>
                </v-col>
                <v-col cols="3">
                  <v-switch label="Tier 2" v-model="editingGroup.tier2" @change="handleTier2Change"></v-switch>
                </v-col>
                <v-col cols="3">
                  <v-switch label="Tier 3" v-model="editingGroup.tier3" @change="handleTier3Change"></v-switch>
                </v-col>
              </v-row>
              <v-btn @click="currentPage = 'groups'">Cancel</v-btn>
              <v-btn type="submit">Save</v-btn>
            </v-form>
          </v-card-text>
        </v-card>
        <v-dialog v-model="confirmDelete" max-width="500px">
          <v-card>
            <v-card-title class="headline">Are you sure you want to delete this ?</v-card-title>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="green darken-1" text @click="confirmDelete = false">Cancel</v-btn>
              <v-btn color="red darken-1" text @click="confirmDeleteItem">Confirm</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      name: '',
      email: '',
      password: '',
      currentPage: 'dashboard', // 'users', 'addUser', 'editUser', 'groups', 'addGroup', 'editGroup'
      searchUser: '',
      editingUser: null,
      editingGroup: null,
      userToDelete: null,
      confirmDelete: false,
      itemToDelete: null,
      editingUserGroups: '',
      editingUserRoles: '',
      users: [],
      groups: [],
      roles: [],
      userHeaders: [
        { text: 'No', value: 'index' },
        { text: 'Name', value: 'name' },
        { text: 'Groups', value: 'group' },
        { text: 'Email', value: 'email' },
        { text: 'Actions', value: 'actions' },
      ],
      groupHeaders: [
        { text: 'No', value: 'index' },
        { text: 'Name', value: 'name' },
        { text: 'Special', value: 'sp' },
        { text: 'Tier 1', value: 'tier1' },
        { text: 'Tier 2', value: 'tier2' },
        { text: 'Tier 3', value: 'tier3' },
        { text: 'Actions', value: 'actions' },
      ],
      newGroup: {
        name: '',
        sp: false,
        tier1: false,
        tier2: false,
        tier3: false,
      },
      labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
      value: [10, 15, 7, 20, 10],
    }
  },
  mounted() {
    this.getUsers();
    this.getGroups();
    this.getRoles();
  },
  created() {
    axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('token')}`;
  },
  methods: {
    showUsersPage() {
      this.currentPage = 'users';
    },
    showAddUserPage() {
      this.currentPage = 'addUser';
    },
    showEditUserPage(user) {
      this.editingUser = Object.assign({}, user);
      this.editingUserGroups = user.groups && user.groups.length > 0 ? user.groups[0].id : null;
      this.editingUserRoles = user.roles && user.roles.length > 0 ? user.roles[0].id : null;
      this.currentPage = 'editUser';
    },
    getUsers() {
      axios.get('/api/users')
      .then(response => {
        this.users = response.data;
      })
      .catch(error => {
        console.log(error);
      });
    },
    addUser() {
      axios.post('/api/register', {
        name: this.name,
        email: this.email,
        password: this.password,
        groups: this.newUserGroups,
        roles: this.newUserRoles
      })
      .then(response => {
        console.log(response.data);
        // Redirect to users page after successful addition
        this.currentPage = 'users';
        this.getUsers();
        // Reset the form fields
        this.name = '';
        this.email = '';
        this.password = '';
        this.newUserGroups = [];
        this.newUserRoles = [];
      })
      .catch(error => {
        console.log(error);
      });
    },
    editUser() {
      const userData = {
        ...this.editingUser,
        groups: this.editingUserGroups,
        roles: this.editingUserRoles
      };
      if (this.editingUser.password) {
        userData.password = this.editingUser.password;
      }
      axios.put(`/api/users/${this.editingUser.id}`, userData)
      .then(response => {
        console.log(response.data);
        this.currentPage = 'users';
        this.getUsers();
      })
      .catch(error => {
        console.log(error);
      });
    },
    startDeletingUser(user) {
    this.itemToDelete = user;
    this.confirmDelete = true;
    },
    customFilter(value, searchUser, item) {
      return (
        String(item.name).includes(searchUser) ||
        String(item.email).includes(searchUser) ||
        item.groups.map(group => group.name).join(', ').includes(searchUser)
      );
    },
    

    showGroupsPage() {
      this.currentPage = 'groups';
    },
    showAddGroupPage() {
      this.currentPage = 'addGroup';
    },
    showEditGroupPage(group) {
      this.editingGroup = Object.assign({}, group);
      this.currentPage = 'editGroup';
    },

    getGroups() {
      axios.get('/api/groups')
      .then(response => {
        this.groups = response.data;
      })
      .catch(error => {
        console.log(error);
      });
    },
    addGroup() {
  if (!this.newGroup.sp && !this.newGroup.tier1 && !this.newGroup.tier2 && !this.newGroup.tier3) {
    alert('Please select at least one Tier.');
    return;
  }
  axios.post('/api/groups', this.newGroup)
    .then(response => {
      console.log(response.data);
      // Redirect to groups page after successful addition
      this.currentPage = 'groups';
      this.getGroups();
      // Reset the form fields
      this.newGroup = {
        name: '',
        sp: false,
        tier1: false,
        tier2: false,
        tier3: false,
      };
    })
    .catch(error => {
      console.log(error);
    });
},
    editGroup() {
      if (!this.editingGroup.sp && !this.editingGroup.tier1 && !this.editingGroup.tier2 && !this.editingGroup.tier3) {
        alert('Please select at least one Tier.');
        return;
      }
      axios.put(`/api/groups/${this.editingGroup.id}`, this.editingGroup)
        .then(response => {
          console.log(response.data);
          // Redirect to groups page after successful update
          this.editinggroup = null;
          this.currentPage = 'groups';
          this.getGroups();
        })
        .catch(error => {
          console.log(error);
        });
    },
    startDeletingGroup(group) {
      this.itemToDelete = group;
      this.confirmDelete = true;
    },
    handleAddTier1Change(value) {
      if (value) {
        this.newGroup.tier2 = true;
        this.newGroup.tier3 = true;
      }
    },
    handleAddTier2Change(value) {
      if (value) {
        this.newGroup.tier3 = true;
      } else {
        this.newGroup.tier1 = false;
      }
    },
    handleAddTier3Change(value) {
      if (!value) {
        this.newGroup.tier1 = false;
        this.newGroup.tier2 = false;
      }
    },
    handleTier1Change(value) {
      if (value) {
        this.editingGroup.tier2 = true;
        this.editingGroup.tier3 = true;
      }
    },
    handleTier2Change(value) {
      if (value) {
        this.editingGroup.tier3 = true;
      } else {
        this.editingGroup.tier1 = false;
      }
    },
    handleTier3Change(value) {
      if (!value) {
        this.editingGroup.tier1 = false;
        this.editingGroup.tier2 = false;
      }
    },

    getRoles() {
      axios.get('/api/roles')
      .then(response => {
        this.roles = response.data;
      })
      .catch(error => {
        console.log(error);
      });
    },


    confirmDeleteItem() {
      if (this.currentPage === 'users') {
        axios.delete(`/api/users/${this.itemToDelete.id}`)
          .then(() => {
            // Remove the user from the users array
            this.users = this.users.filter(u => u.id !== this.itemToDelete.id);
            this.confirmDelete = false;
          })
          .catch(error => {
            console.log(error);
          });
      } else if (this.currentPage === 'groups') {
        axios.delete(`/api/groups/${this.itemToDelete.id}`)
          .then(() => {
            // Remove the group from the groups array
            this.groups = this.groups.filter(g => g.id !== this.itemToDelete.id);
            this.confirmDelete = false;
          })
          .catch(error => {
            console.log(error);
          });
      }
    },

  }
};
</script>