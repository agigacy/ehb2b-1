<template>
  <v-container fluid>
    <v-row>
      <v-col cols="12" md="2" class="bg-light-blue">
        <v-card>
          <v-list>
            <!-- <v-list-item @click="currentPage = 'dashboard'">
              <v-list-item-action>
                <span class="material-symbols-outlined">dashboard </span>
              </v-list-item-action>
              <v-list-item-content :class="{ 'active': currentPage === 'dashboard' }">Dashboard</v-list-item-content>
            </v-list-item> -->

            <v-list-item @click="currentPage = 'dashboard'" class="d-flex align-center">
              <v-list-item-content :class="{ 'active': currentPage === 'dashboard' }">
                <span class="material-symbols-outlined mr-2">dashboard</span>
                Dashboard
              </v-list-item-content>
            </v-list-item>

            <v-list-item v-if="canViewUser" @click="currentPage = 'users'" class="d-flex align-center">
              <v-list-item-content :class="{ 'active': currentPage === 'users' }">
                <span class="material-symbols-outlined">person </span>
                Users
              </v-list-item-content>
            </v-list-item>

            <!-- <v-list-item @click="currentPage = 'agentsUsers'">
              <v-list-item-action>
                <v-icon>mdi-account-multiple</v-icon>
              </v-list-item-action>
              <v-list-item-content>Agents</v-list-item-content>
            </v-list-item> -->

            <v-list-item v-if="canViewGroup" @click="currentPage = 'groups'" class="d-flex align-center">
              <v-list-item-content :class="{ 'active': currentPage === 'groups' }">
                <span class="material-symbols-outlined">group </span>
                Groups
              </v-list-item-content>
            </v-list-item>

            <v-list-item @click="currentPage = 'roles'">
              <v-list-item-content :class="{ 'active': currentPage === 'roles' }" class="d-flex align-center">
                <span class="material-symbols-outlined">rule </span>
                Roles
              </v-list-item-content>
            </v-list-item>

            <v-list-item @click="currentPage = 'permissions'">
              <v-list-item-content :class="{ 'active': currentPage === 'permissions' }" class="d-flex align-center">
                <span class="material-symbols-outlined">manage_accounts </span>
                Permissions
              </v-list-item-content>
            </v-list-item>
            <v-list-item @click="currentPage = 'activeLogins'">
              <v-list-item-content :class="{ 'active': currentPage === 'activeLogins' }" class="d-flex align-center">
                <span class="material-symbols-outlined">login</span>
                Active Logins
              </v-list-item-content>
            </v-list-item>
            <!-- Add more items here -->
          </v-list>
        </v-card>
      </v-col>
      <v-col cols="12" md="10">
        <v-card v-if="currentPage === 'dashboard'">
          <v-card-title class="py-2 px-4" style="background-color: bisque; width: 100%; padding-left: 28px; font-size: 14px; font-weight: bold">Dashboard</v-card-title>
          <v-card-text>
            <!-- <v-row>
              <v-col>
                User ID: {{ $userId() }}
              </v-col>
              <v-col>
                Username: {{ $username() }}
              </v-col>
            </v-row> -->        

            <v-row>
              <v-col cols="12" sm="6" md="4">
                <v-card-title class="justify-center"><h6>Total User Group</h6></v-card-title>
                <apexchart v-if="groupDataLoaded" type="donut" :options="groupChartOptions" :series="groupSeries"></apexchart>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <!-- Grid 5 content here -->
                <v-card-title class="justify-center"><h6>Polar User Group</h6></v-card-title>
                <apexchart v-if="groupDataLoaded" type="polarArea" :options="groupChartOptions" :series="groupSeries"></apexchart>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <!-- Grid 6 content here -->
                <v-card-title class="justify-center"><h6>User Group with SP</h6></v-card-title>
                <apexchart v-if="groupDataLoaded" type="polarArea" :options="groupChartOptions2" :series="groupSeries"></apexchart>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" sm="6" md="4">
                <v-card-title class="justify-center"><h6>Total User Group</h6></v-card-title>
                <apexchart v-if="groupDataLoaded" type="donut" :options="groupChartOptions" :series="groupSeries"></apexchart>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <!-- Grid 5 content here -->
                <v-card-title class="justify-center"><h6>Polar User Group</h6></v-card-title>
                <apexchart v-if="groupDataLoaded" type="polarArea" :options="groupChartOptions" :series="groupSeries"></apexchart>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <!-- Grid 6 content here -->
                <v-card-title class="justify-center"><h6>User Group with SP</h6></v-card-title>
                <apexchart v-if="groupDataLoaded" type="donut" :options="groupChartOptions2" :series="groupSeries"></apexchart>
              </v-col>
            </v-row>
            
          </v-card-text>
        </v-card>
        <v-card v-if="currentPage === 'users'">
          <!-- <v-card-title>Users</v-card-title> -->
          <v-card-title class="py-2 px-4" style="background-color: bisque; width: 100%; padding-left: 28px; font-size: 14px; font-weight: bold">Users</v-card-title>
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
              <template v-slot:item.name="{ item }">
                {{ item.name.charAt(0).toUpperCase() + item.name.slice(1)  }}
              </template>
              <template v-slot:item.group="{ item }">
                {{ item.groups?.map(group => group.name).join(', ') }}
              </template>
              <template v-slot:item.role="{ item }">
                {{ item.roles?.map(role => role.name).join(', ') }}
              </template>
              <template v-slot:item.actions="{ item }">
                <v-btn v-if="canEditAdminPage || canEditUser" small color="blue darken-1" text @click="showEditUserPage(item)">
                  <v-icon small>mdi-pencil</v-icon>
                  Edit
                </v-btn>
                <v-btn v-if="canDeleteAdminPage || canDeleteUser" small color="red darken-1" text @click="startDeletingUser(item)">
                  <v-icon small>mdi-delete</v-icon>
                  Delete
                </v-btn>
              </template>
            </v-data-table>
            <v-btn v-if="canCreateAdminPage || canCreateUser" @click="currentPage = 'addUser'">Add User</v-btn>
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
        <!-- <v-card v-if="currentPage === 'agentsUsers'">
          <v-card-title>AgentsUsers</v-card-title>
          <v-card-text>
              <v-text-field v-model="searchUser" append-icon="mdi-magnify" label="Search" single-line hide-details></v-text-field>
              <v-data-table
                :headers="userHeaders"
                :items="users"
                :search="searchUser"
                :custom-filter="customAgentFilter"
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
        </v-card> -->
        <!-- <v-card v-if="currentPage === 'addUser'">
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
        </v-card> -->
        <v-card v-if="currentPage === 'groups'">
          <!-- <v-card-title>Groups</v-card-title> -->
          <v-card-title class="py-2 px-4" style="background-color: bisque; width: 100%; padding-left: 28px; font-size: 14px; font-weight: bold">Groups</v-card-title>
          <v-card-text>
            <v-data-table :headers="groupHeaders" :items="groups" :footer-props="{ itemsPerPageOptions: [5, 10, 25, 50] }">
              <template v-slot:item.index="{ index }">
                {{ index + 1 }}
              </template>
              <template v-slot:item.sp="{ item }">
                <v-switch disabled :input-value="item.sp" style="opacity: 0.7"></v-switch>
              </template>
              <template v-slot:item.tier1="{ item }">
                <v-switch disabled :input-value="item.tier1" style="opacity: 0.7"></v-switch>
              </template>
              <template v-slot:item.tier2="{ item }">
                <v-switch disabled :input-value="item.tier2" style="opacity: 0.7"></v-switch>
              </template>
              <template v-slot:item.tier3="{ item }">
                <v-switch disabled :input-value="item.tier3" style="opacity: 0.7"></v-switch>
              </template>
              <template v-slot:item.actions="{ item }">
                <v-btn v-if="canEditAdminPage || canEditGroup" small color="blue darken-1" text @click="showEditGroupPage(item)">
                  <v-icon small>mdi-pencil</v-icon>
                  Edit
                </v-btn>
                <v-btn v-if="canDeleteAdminPage || canDeleteGroup" small color="red darken-1" text @click="startDeletingGroup(item)">
                  <v-icon small>mdi-delete</v-icon>
                  Delete
                </v-btn>
              </template>
            </v-data-table>
            <v-btn v-if="canCreateAdminPage || canCreateGroup" @click="currentPage = 'addGroup'">Add Group</v-btn>
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
              <v-row>
                <v-text-field label="SSM Number" type="text" v-model="newGroup.ssm_number" required></v-text-field>
              </v-row>
              <v-row>
                <v-text-field label="Address" type="text" v-model="newGroup.address" required></v-text-field>
              </v-row>
              <v-row>
                <v-text-field label="Phone" type="text" v-model="newGroup.phone" required></v-text-field>
              </v-row>
              <v-row>
                <v-text-field label="Email" type="text" v-model="newGroup.email" required></v-text-field>
              </v-row>
              <v-row>
                <v-text-field label="Website" type="text" v-model="newGroup.website" required></v-text-field>
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
              <v-row>
                <v-text-field label="SSM Number" type="text" v-model="editingGroup.ssm_number" required></v-text-field>
              </v-row>
              <v-row>
                <v-text-field label="Address" type="text" v-model="editingGroup.address" required></v-text-field>
              </v-row>
              <v-row>
                <v-text-field label="Phone" type="text" v-model="editingGroup.phone" required></v-text-field>
              </v-row>
              <v-row>
                <v-text-field label="Email" type="text" v-model="editingGroup.email" required></v-text-field>
              </v-row>
              <v-row>
                <v-text-field label="Website" type="text" v-model="editingGroup.website" required></v-text-field>
              </v-row>
              <v-btn @click="currentPage = 'groups'">Cancel</v-btn>
              <v-btn type="submit">Save</v-btn>
            </v-form>
          </v-card-text>
        </v-card>
        <v-card v-if="currentPage === 'roles'">
          <!-- <v-card-title>Roles</v-card-title> -->
          <v-card-title class="py-2 px-4" style="background-color: bisque; width: 100%; padding-left: 28px; font-size: 14px; font-weight: bold">Roles</v-card-title>
          <v-card-text>
            <v-data-table :headers="roleHeaders" :items="roles" :footer-props="{ itemsPerPageOptions: [5, 10, 25, 50] }">
              <template v-slot:item.index="{ index }">
                {{ index + 1 }}
              </template>
              <template v-slot:item.actions="{ item }">
                <v-btn small color="blue darken-1" text @click="showEditRolePage(item)">
                  <v-icon small>mdi-pencil</v-icon>
                  Edit
                </v-btn>
                <v-btn small color="red darken-1" text @click="startDeletingRole(item)">
                  <v-icon small>mdi-delete</v-icon>
                  Delete
                </v-btn>
              </template>
            </v-data-table>
            <v-btn @click="currentPage = 'addRole'">Add Role</v-btn>
          </v-card-text>
        </v-card>
        <v-card v-if="currentPage === 'addRole'">
          <v-card-title>Add Role</v-card-title>
          <v-card-text>
            <v-form @submit.prevent="addRole">
              <v-text-field label="Name" type="text" v-model="newRole.name" required></v-text-field>
              <v-btn @click="currentPage = 'roles'">Back</v-btn>
              <v-btn type="submit">Add Role</v-btn>
            </v-form>
          </v-card-text>
        </v-card>
        <v-card v-if="currentPage === 'editRole'">
          <v-card-title>Edit Role</v-card-title>
          <v-card-text>
            <v-form @submit.prevent="editRole">
              <v-text-field label="Name" type="text" v-model="editingRole.name" required></v-text-field>
              <v-btn @click="currentPage = 'roles'">Cancel</v-btn>
              <v-btn type="submit">Save</v-btn>
            </v-form>
          </v-card-text>
        </v-card>
        <v-card v-if="currentPage === 'permissions'">
          <!-- <v-card-title>Permissions</v-card-title> -->
          <v-card-title class="py-2 px-4" style="background-color: bisque; width: 100%; padding-left: 28px; font-size: 14px; font-weight: bold">Permissions</v-card-title>
          <v-card-text>
            <v-data-table
              :headers="permissionHeaders"
              :items="permissions"
              :items-per-page="5"
              class="elevation-1"
            >
              <template v-slot:item.actions="{ item }">
                <v-btn small color="blue darken-1" text @click="assignPermissionToUser(item.id)" :disabled="!selectedUser">
                  Assign to User
                </v-btn>
                <v-btn small color="green darken-1" text @click="assignPermissionToRole(item.id)" :disabled="!selectedRole">
                  Assign to Role
                </v-btn>
              </template>
            </v-data-table>
          </v-card-text>
        </v-card>
        <v-card v-if="currentPage === 'activeLogins'">
          <!-- <v-card-title>Active Logins</v-card-title> -->
          <v-card-title class="py-2 px-4" style="background-color: bisque; width: 100%; padding-left: 28px; font-size: 14px; font-weight: bold">Active User(s) Login</v-card-title>
          <v-card-text>
            <v-data-table
                :headers="loginHeaders"
                :items="logins"
                :items-per-page="5"
                class="elevation-1"
              >
                <template v-slot:item="{ item }">
                  <tr>
                    <td>{{ item.username.charAt(0).toUpperCase() + item.username.slice(1)  }} <span v-show="item.username == getUsername()" style="color: #b5b5b5;">(You)</span></td> <!-- 显示用户名 -->
                    <td>{{ $formatDate(item.updated_at) }}</td> <!-- 显示最后使用时间作为登录时间 -->
                    <td>
                      <v-btn small color="red" @click="kickUser(item.id)" style="color: #FFF">
                        Kick
                      </v-btn>
                    </td>
                  </tr>
                </template>
              </v-data-table>
          </v-card-text>
        </v-card>
        <v-dialog v-model="kickDialog" persistent max-width="490">
          <v-card>
            <v-card-title class="headline">Confirm Action</v-card-title>
            <v-card-text>Are you sure you want to kick this user?</v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="kickDialog = false">Cancel</v-btn>
              <v-btn color="red darken-1" text @click="confirmKick">Confirm</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
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
import VueApexCharts from 'vue-apexcharts'
export default {
  components: {
    apexchart: VueApexCharts,
  },
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
        { text: 'Roles', value: 'role' },
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
      roleHeaders: [
        { text: 'No', value: 'index' },
        { text: 'Name', value: 'name' },
        { text: 'Actions', value: 'actions' },
      ],
      newRole: {
        name: '',
      },
      editingRole: null,
      selectedUser: null,
      selectedRole: null,
      permissions: [], // 确保这里填充了你的权限数据
      permissionHeaders: [
        { text: 'Permission Name', value: 'name' },
        { text: 'Actions', value: 'actions', sortable: false },
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
      //   chartOptions: {
      //   chart: {
      //     id: 'basic-bar'
      //   },
      //   xaxis: {
      //     categories: ['Users', 'Groups', 'Roles']
      //   }
      // },
      groupSeries: [],
      groupChartOptions: {
        chart: {
          type: 'donut',
        },
        labels: [], // 这里将用于显示组名
      },
      groupChartOptions2: {
        chart: {
          type: 'polarArea',
        },
        labels: [], // 这里将用于显示组名
      },
      groupDataLoaded: false,
      logins: [], // 存储登录信息的数组
      loginHeaders: [
      { text: 'User', value: 'username' }, // 使用 API 返回的用户名字段
      { text: 'Last logged in at', value: 'updated_at' }, // 使用 updated_at 作为登录时间
      ],
      kickDialog: false,
      userIdToKick: null,
    }
  },
  mounted() {
    this.getUsers();
    this.getGroups().then(() => {
      this.groupSeries = this.groups.map(group => group.users_count);
      // this.groupChartOptions.labels = this.groups.map(group => group.name);
      // this.groupChartOptions2.labels = this.groups.filter(group => group.sp === 1).map(group => group.name);
      this.groupChartOptions2.labels = [...new Set(this.groups.map(group => {
        const tour = this.groups.find(group => group.id === group.name);        
        return group ? group.name.slice(0, 10) + '..' : '';
      }))];
      this.groupChartOptions.labels = [...new Set(this.groups.map(group => {
        const tour = this.groups.find(group => group.id === group.name);        
        return group ? group.name.slice(0, 10) + '..' : '';
      }))];
      this.groupDataLoaded = true;
    });
    // this.getGroups();
    this.getRoles();
    // this.loadData();
    this.getPermissions();
    this.fetchActiveLogins();
  },
  created() {
    axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('token')}`;
  },
  computed: {
    // 判断用户是否有 admin_page_view 权限
    canCreateAdminPage() {
    const permissions = JSON.parse(localStorage.getItem('permissions') || '[]');
    const hasCreatePermission = permissions.includes('admin_page_create');
    console.log("Can create admin page:", hasCreatePermission); // 输出是否有权限
    return hasCreatePermission;
    },
    canEditAdminPage() {
      const permissions = JSON.parse(localStorage.getItem('permissions') || '[]');
      const hasEditPermission = permissions.includes('admin_page_edit');
      console.log("Can edit admin page:", hasEditPermission); // 输出是否有权限
      return hasEditPermission;
    },
    canDeleteAdminPage() {
      const permissions = JSON.parse(localStorage.getItem('permissions') || '[]');
      const hasDeletePermission = permissions.includes('admin_page_delete');
      console.log("Can delete admin page:", hasDeletePermission); // 输出是否有权限
      return hasDeletePermission;
    },
    canViewUser() {
      const permissions = JSON.parse(localStorage.getItem('permissions') || '[]');
      const hasViewUserPermission = permissions.includes('user_view');
      console.log("Can view user:", hasViewUserPermission); // 输出是否有权限
      return hasViewUserPermission;
    },
    canCreateUser() {
      const permissions = JSON.parse(localStorage.getItem('permissions') || '[]');
      const hasCreateUserPermission = permissions.includes('user_create');
      console.log("Can create user:", hasCreateUserPermission); // 输出是否有权限
      return hasCreateUserPermission;
    },
    canEditUser() {
      const permissions = JSON.parse(localStorage.getItem('permissions') || '[]');
      const hasEditUserPermission = permissions.includes('user_edit');
      console.log("Can edit user:", hasEditUserPermission); // 输出是否有权限
      return hasEditUserPermission;
    },
    canDeleteUser() {
      const permissions = JSON.parse(localStorage.getItem('permissions') || '[]');
      const hasDeleteUserPermission = permissions.includes('user_delete');
      console.log("Can delete user:", hasDeleteUserPermission); // 输出是否有权限
      return hasDeleteUserPermission;
    },
    canViewGroup() {
      const permissions = JSON.parse(localStorage.getItem('permissions') || '[]');
      const hasViewGroupPermission = permissions.includes('group_view');
      console.log("Can view group:", hasViewGroupPermission); // 输出是否有权限
      return hasViewGroupPermission;
    },
    canCreateGroup() {
      const permissions = JSON.parse(localStorage.getItem('permissions') || '[]');
      const hasCreateGroupPermission = permissions.includes('group_create');
      console.log("Can create group:", hasCreateGroupPermission); // 输出是否有权限
      return hasCreateGroupPermission;
    },
    canEditGroup() {
      const permissions = JSON.parse(localStorage.getItem('permissions') || '[]');
      const hasEditGroupPermission = permissions.includes('group_edit');
      console.log("Can edit group:", hasEditGroupPermission); // 输出是否有权限
      return hasEditGroupPermission;
    },
    canDeleteGroup() {
      const permissions = JSON.parse(localStorage.getItem('permissions') || '[]');
      const hasDeleteGroupPermission = permissions.includes('group_delete');
      console.log("Can delete group:", hasDeleteGroupPermission); // 输出是否有权限
      return hasDeleteGroupPermission;
    },
    // userId() {
    //   return localStorage.getItem('user_id');
    // }
  },
  methods: {
  //   loadData() {
  //   // 加载数据的逻辑...
  //   // 假设数据加载完成后，更新chartSeries
  //   this.chartSeries = [{
  //     name: '数量',
  //     data: [10, 20, 30] // 示例数据
  //   }];
  // },
    kickUser(userId) {
      this.userIdToKick = userId;
      this.kickDialog = true; // 打开确认对话框
    },
    confirmKick() {
      if (this.userIdToKick) {
        axios.delete(`/api/kick-user/${this.userIdToKick}`)
          .then(response => {
            this.logins = this.logins.filter(login => login.id !== this.userIdToKick);
            this.$toast.success('User kicked successfully');
            this.fetchActiveLogins();
          })
          .catch(error => {
            console.error("Error kicking user:", error);
            this.$toast.error('Failed to kick user');
          });
      }
      this.kickDialog = false; // 关闭对话框
      this.userIdToKick = null; // 清除存储的用户ID
    },
    // kickUser(tokenId) {
    //   axios.delete(`/api/kick-user/${tokenId}`)
    //     .then(response => {
    //       this.logins = this.logins.filter(login => login.id !== tokenId);
    //       this.$toast.success('User kicked successfully');
    //     })
    //     .catch(error => {
    //       console.error("Error kicking user:", error);
    //       this.$toast.error('Failed to kick user');
    //     });
    // },
    fetchActiveLogins() {
      // 使用 Axios 或其他 HTTP 客户端来从您的 API 获取数据
      axios.get('/api/active-logins')
        .then(response => {
          this.logins = response.data;
        })
        .catch(error => {
          console.error("Error fetching active logins:", error);
        });
    },
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
        // this.userCount = response.data.length;
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
      // return (
      //   String(item.name).includes(searchUser) ||
      //   String(item.email).includes(searchUser) ||
      //   item.groups.map(group => group.name).join(', ').includes(searchUser)
      // );
    //   return (
    // item.is_agent === 1 &&
    // (
    //   String(item.name).includes(searchUser) ||
    //   String(item.email).includes(searchUser) ||
    //   item.groups.map(group => group.name).join(', ').includes(searchUser)
    // )
    
  // );
  console.log(item.is_agent); // 确认这个函数被调用，并输出 is_agent 的值
  return item.is_agent === 1;
    },
  //   customAgentsFilter(value, searchUser, item) {
  //     // return (
  //     //   String(item.name).includes(searchUser) ||
  //     //   String(item.email).includes(searchUser) ||
  //     //   item.groups.map(group => group.name).join(', ').includes(searchUser)
  //     // );
  //     return (
  //   item.is_agent === 1 &&
  //   (
  //     String(item.name).includes(searchUser) ||
  //     String(item.email).includes(searchUser) ||
  //     item.groups.map(group => group.name).join(', ').includes(searchUser)
  //   )
  // );
  //   },
    

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
      return axios.get('/api/groups')
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
        this.roleCount = response.data.length;
      })
      .catch(error => {
        console.log(error);
      });
    },
    showRolesPage() {
      this.currentPage = 'roles';
    },
    showAddRolePage() {
      this.currentPage = 'addRole';
    },
    showEditRolePage(role) {
      this.editingRole = Object.assign({}, role);
      this.currentPage = 'editRole';
    },
    editRole() {
      const roleData = {
        ...this.editingRole,
        guard_name: 'web'
      };
      axios.put(`/api/roles/${this.editingRole.id}`, roleData)
      .then(response => {
        console.log(response.data);
        this.currentPage = 'roles';
        this.getRoles();
      })
      .catch(error => {
        console.log(error);
      });
    },
    addRole() {
      const roleData = {
          ...this.newRole,
          guard_name: 'web'  // 添加 guard_name 属性
        };
      axios.post('/api/roles', roleData)
      .then(response => {
        console.log(response.data);
        this.currentPage = 'roles';
        this.getRoles();
      })
      .catch(error => {
        console.log(error);
      });
    },
    assignPermissionToUser(permissionId) {
      if (!this.selectedUser) {
        alert('Please select a user.');
        return;
      }
      // 发送请求到后端 API，为用户分配权限
      axios.post(`/api/users/${this.selectedUser}/permissions`, { permissionId })
        .then(() => {
          alert('Permission assigned to user successfully.');
        })
        .catch(error => {
          console.error('Error assigning permission to user:', error);
        });
    },
    assignPermissionToRole(permissionId) {
      if (!this.selectedRole) {
        alert('Please select a role.');
        return;
      }
      // 发送请求到后端 API，为角色分配权限
      axios.post(`/api/roles/${this.selectedRole}/permissions`, { permissionId })
        .then(() => {
          alert('Permission assigned to role successfully.');
        })
        .catch(error => {
          console.error('Error assigning permission to role:', error);
        });
    },
    getPermissions() {
      axios.get('/api/permissions')
      
        .then(response => {
          this.permissions = response.data;
        })
        .catch(error => {
          console.error('Error fetching permissions:', error);
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
    getUsername() {
      return this.$username(); // Call the globally declared $username method
    }

  }
};
</script>
<style  scoped>
</style>