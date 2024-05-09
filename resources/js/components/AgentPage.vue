<template>
  <v-container fluid>
    <v-row>
      <v-col cols="12" md="2" class="bg-light-blue">
        <v-card>
          <v-list>
            <v-list-item @click="currentPage = 'dashboard'">
              <v-list-item-action>
                <!-- <v-icon>mdi-view-dashboard</v-icon> -->
                <span class="material-symbols-outlined">dashboard </span>
              </v-list-item-action>
              <v-list-item-content>Dashboard</v-list-item-content>
            </v-list-item>
            <v-list-item v-if="canViewBooking" @click="currentPage = 'bookings'">
              <v-list-item-action>
                <!-- <v-icon>mdi-account-multiple</v-icon> -->
                <span class="material-symbols-outlined">airplane_ticket </span>
              </v-list-item-action>
              <v-list-item-content>Bookings</v-list-item-content>
            </v-list-item>
            <!-- <v-list-item @click="currentPage = 'passengers'">
              <v-list-item-action>
                <v-icon>mdi-account-passenger</v-icon>
              </v-list-item-action>
              <v-list-item-content>Passenges</v-list-item-content>
            </v-list-item> -->
            <!-- Add more items here -->
          </v-list>
        </v-card>
      </v-col>
      <v-col cols="12" md="10">
        <v-card v-if="currentPage === 'dashboard'">
          <v-card-title>Dashboard</v-card-title>
          <v-card-text>

            <v-row>
              <v-col cols="12" sm="6" md="4">
                <v-card-title class="justify-center"><h6>Total Booking (Unpaid)</h6></v-card-title>
                <apexchart v-if="groupDataLoaded" type="donut" :options="groupChartOptions" :series="groupSeries"></apexchart>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <!-- Grid 5 content here -->
                <v-card-title class="justify-center"><h6>Polar Total Booking</h6></v-card-title>
                <apexchart v-if="groupDataLoaded" type="polarArea" :options="groupChartOptions" :series="groupSeries"></apexchart>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <!-- Grid 6 content here -->
                <v-card-title class="justify-center"><h6>Another Booking Group</h6></v-card-title>
                <apexchart v-if="groupDataLoaded" type="pie" :options="groupChartOptions" :series="groupSeries"></apexchart>
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
                <apexchart v-if="groupDataLoaded" type="donut" :options="groupChartOptions" :series="groupSeries"></apexchart>
              </v-col>
            </v-row>

          </v-card-text>
        </v-card>
        <v-card v-if="currentPage === 'bookings'">
          <v-card-title>Bookings</v-card-title>
          <v-card-text>
            <v-data-table :headers="bookingHeaders" :items="bookings" :footer-props="{ itemsPerPageOptions: [5, 10, 25, 50] }">
              <template v-slot:item.index="{ index }">
                {{ index + 1 }}
              </template>
              <template v-slot:item.tour_id="{ item }">
                {{ item.tour.package_name }}
              </template>
              <template v-slot:item.pax="{ item }">
                <!-- {{ item.tour.user_id }} -->
                {{ item.total / item.tour.tier1 }}
              </template>
              <template v-slot:item.user_id="{ item }">
                {{ item.user.name }}
              </template>
              <template v-slot:item.total="{ item }">
                {{ item.total.toFixed(2) }}
              </template>
              <template v-slot:item.actions="{ item }">
                <v-btn small color="blue darken-1" text @click="showBookingDetails(item)">
                  <v-icon small>mdi-eye</v-icon>
                  View
                </v-btn>
                <!-- <v-btn small color="blue darken-1" text @click="showEditBookingPage(item)">
                  <v-icon small>mdi-pencil</v-icon>
                  Edit
                </v-btn> -->
                <v-btn v-if="canDeleteBooking" small color="red darken-1" text @click="startDeletingBooking(item)">
                  <v-icon small>mdi-delete</v-icon>
                  Delete
                </v-btn>
              </template>
            </v-data-table>
            <!-- <v-btn @click="currentPage = 'addBooking'">Add Booking</v-btn> -->
          </v-card-text>
        </v-card>
        <v-card v-if="currentPage === 'bookingDetails'">
          <v-card-title v-if="currentBooking && currentBooking.user">{{ currentBooking.user.name }}'s Booking</v-card-title>
          <v-card-text v-if="currentBooking">
            <p>Tour: {{ currentBooking.tour.package_name }}</p>
            <p>Travel Date: {{ currentBooking.date }}</p>
            <p>Total Amount: RM {{ currentBooking.total.toFixed(2) }}</p>
            <h3>Passenger(s):</h3>
            <v-data-table :headers="passengerHeaders" :items="currentBooking.passengers" :footer-props="{ itemsPerPageOptions: [5, 10, 25, 50] }">
            <template v-slot:item.index="{ index }">
                {{ index + 1 }}
            </template>
              <template v-slot:item.actions="{ item }">
                <v-btn v-if="canEditBooking" small color="blue darken-1" text @click="showEditPassengerPage(item)">
                  <v-icon small>mdi-pencil</v-icon>
                  Edit
                </v-btn>
                <!-- <v-btn small color="red darken-1" text @click="startDeletingPassenger(item)">
                  <v-icon small>mdi-delete</v-icon>
                  Delete
                </v-btn> -->
              </template>
          </v-data-table>
          </v-card-text>
        </v-card>
        <!-- <v-card v-if="currentPage === 'addBooking'">
          <v-card-title>Add Booking</v-card-title>
          <v-card-text>
            <v-form @submit.prevent="addBooking">
              <v-text-field label="Tour" type="text" v-model="tour_id" required></v-text-field>
              <v-text-field label="User" type="text" v-model="user_id" required></v-text-field>
              <v-text-field label="Date" type="text" v-model="date" required></v-text-field>
              <v-text-field label="Total" type="text" v-model="total" required></v-text-field>
              <v-btn @click="currentPage = 'bookings'">Back</v-btn>
              <v-btn type="submit">Add Booking</v-btn>
            </v-form>
          </v-card-text>
        </v-card> -->
        <!-- <v-card v-if="currentPage === 'editBooking'">
          <v-card-title>Edit Booking</v-card-title>
          <v-card-text>
            <v-form @submit.prevent="editBooking">
              <v-text-field label="Tour" type="text" v-model="editingBooking.tour_id" required></v-text-field>
              <v-text-field label="User" type="text" v-model="editingBooking.user_id" required></v-text-field>
              <v-text-field label="Date" type="text" v-model="editingBooking.date" required></v-text-field>
              <v-text-field label="Total" type="text" v-model="editingBooking.total" required></v-text-field>
              <v-btn @click="currentPage = 'bookings'">Cancel</v-btn>
              <v-btn type="submit">Save</v-btn>
            </v-form>
          </v-card-text>
        </v-card> -->
        <!-- <v-card v-if="currentPage === 'passengers'">
          <v-card-title>Passengers</v-card-title>
          <v-card-text>
            <v-data-table :headers="passengerHeaders" :items="passengers" :footer-props="{ itemsPerPageOptions: [5, 10, 25, 50] }">
              <template v-slot:item.index="{ index }">
                {{ index + 1 }}
              </template>
             
              <template v-slot:item.actions="{ item }">
                <v-btn small color="blue darken-1" text @click="showEditPassengerPage(item)">
                  <v-icon small>mdi-pencil</v-icon>
                  Edit
                </v-btn>
                <v-btn small color="red darken-1" text @click="startDeletingPassenger(item)">
                  <v-icon small>mdi-delete</v-icon>
                  Delete
                </v-btn>
              </template>
            </v-data-table>
            <v-btn @click="currentPage = 'addPassenger'">Add Passenger</v-btn>
          </v-card-text>
        </v-card> -->
        <!-- <v-card v-if="currentPage === 'addPassenger'">
          <v-card-title>Add Passenger</v-card-title>
          <v-card-text>
            <v-form @submit.prevent="addPassenger">
              <v-text-field label="Booking ID" type="text" v-model="booking_id" required></v-text-field>
              <v-text-field label="Designation" type="text" v-model="designation" required></v-text-field>
              <v-text-field label="Name" type="text" v-model="name" required></v-text-field>
              <v-text-field label="Passport" type="text" v-model="passport" required></v-text-field>
              <v-text-field label="Date Of Birth" type="text" v-model="date_of_birth" required></v-text-field>
              <v-text-field label="Phone Number" type="text" v-model="hp" required></v-text-field>
              <v-text-field label="Remark" type="text" v-model="remark"></v-text-field>
              <v-btn @click="currentPage = 'passengers'">Back</v-btn>
              <v-btn type="submit">Add Passenger</v-btn>
            </v-form>
          </v-card-text>
        </v-card> -->
        <v-card v-if="currentPage === 'editPassenger'">
          <v-card-title>Edit Passenger</v-card-title>
          <v-card-text>
            <v-form @submit.prevent="editPassenger">
              <v-text-field label="Designation" type="text" v-model="editingPassenger.designation" required></v-text-field>
              <v-text-field label="Name" type="text" v-model="editingPassenger.name" required></v-text-field>
              <v-text-field label="Passport" type="text" v-model="editingPassenger.passport" required></v-text-field>
              <v-text-field label="Date Of Birth" type="text" v-model="editingPassenger.date_of_birth" required></v-text-field>
              <v-text-field label="Phone Number" type="text" v-model="editingPassenger.hp" required></v-text-field>
              <v-text-field label="Remark" type="text" v-model="editingPassenger.remark"></v-text-field>
              <!-- <v-file-input
                label="Passport Upload"
                @change="file => handlePassportUpload(file)"
                accept="image/*"
                :rules="[v => !!v || 'Passport upload is required']"
              ></v-file-input> -->
              <v-file-input
                label="Passport Upload"
                @change="handlePassportUpload"
                accept="image/*"
                :rules="[v => !!v || 'Passport upload is required']"
              ></v-file-input>
              <v-img
                :src="editingPassenger.passport_upload_url"
                alt="Passport Upload"
                style="max-width: 500px;"
              ></v-img>
              <v-spacer style="padding-bottom: 40px;"></v-spacer>
              <v-btn @click="currentPage = 'bookingDetails'">Cancel</v-btn>
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
import VueApexCharts from 'vue-apexcharts';

export default {
  components: {
    apexchart: VueApexCharts,
  },

  data() {
    return {
      currentPage: 'dashboard', // 'bookings', 'addBooking', 'editBooking', 'passengers', 'addPassenger', 'editPassenger'
      editingBooking: null,
      // bookingToDelete: null,
      // confirmDelete: false,
      // itemToDelete: null,
      confirmDelete: false,
      currentBooking: null,
      bookings: [],
      passengers: [],
      passenger:{
        passport_upload_url: '',
      },
      editingPassenger:{
        passport_upload_url: '',
      },
      bookingHeaders: [
        { text: 'No', value: 'index' },
        { text: 'Tour', value: 'tour_id' },
        { text: 'PAX (tempo)', value: 'pax' },
        { text: 'User/Agent', value: 'user_id' },
        { text: 'Date', value: 'date' },
        { text: 'Total (RM)', value: 'total' },
        { text: 'Actions', value: 'actions' },
      ],
      passengerHeaders: [
        { text: 'No', value: 'index' },
        // { text: 'Booking ID', value: 'booking_id' },
        { text: 'Name', value: 'name' },
        { text: 'Passport', value: 'passport' },
        { text: 'Phone Number', value: 'hp' },
        { text: 'Designation', value: 'designation' },
        { text: 'Actions', value: 'actions' },
      ],
      labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
      value: [10, 15, 7, 20, 10],
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
      users: [],
      userTotals: [],
      editingPassenger:{},
      // editingPassenger: {
      //   passport_upload: '',
      //   passport_upload_url: '',
      //   passport_upload_file: null,
      // },
    }
  },
  mounted() {
    this.getBookings();
    this.getPassengers();
    this.getUsers();
    this.getGroups().then(() => {
      // this.groupSeries = this.bookings.map(booking => booking.total);
      this.groupSeries = Object.values(this.bookings.reduce((acc, booking) => {
        if (!acc[booking.user_id]) {
          acc[booking.user_id] = 0;
        }
        acc[booking.user_id] += booking.total;
        return acc;
      }, {}));

      // this.groupChartOptions.labels = this.bookings.map(booking => booking.total);
      // this.groupChartOptions.labels = this.bookings.map(booking => booking.user_id);
      
      // Simple - show all unique user id
      // this.groupChartOptions.labels = [...new Set(this.bookings.map(booking => booking.user_id))];

      // Simple - show all user name based on users array
      // this.groupChartOptions.labels = this.bookings.map(booking => {
      //   const user = this.users.find(user => user.id === booking.user_id);
      //   return user? user.name : '';
      // });

      this.groupChartOptions.labels = [...new Set(this.bookings.map(booking => {
        const user = this.users.find(user => user.id === booking.user_id);
        return user? user.name : '';
      }))];


      // this.groupChartOptions.labels = this.getUserTotals(userName, totalAmount);
      // this.groupChartOptions.labels = this.getUserTotals().map(userTotals.userName => userTotals.totalAmount);
      // this.groupChartOptions.labels = this.bookings.reduce((acc, booking) => ({ ...acc, [booking.user_id]: (acc[booking.user_id] || 0) + booking.total }), {});
      // this.groupChartOptions2.labels = this.bookings.filter(booking => booking.sp === 1).map(booking => group.name);
      this.groupDataLoaded = true;
    });
    // After fetching both users and bookings, update chart labels
    // this.getGroups().then(() => {
    //   this.groupSeries = this.groups.map(group => group.users_count);
    //   this.groupChartOptions.labels = this.groups.map(group => group.name);
    //   this.groupChartOptions2.labels = this.groups.filter(group => group.sp === 1).map(group => group.name);
    //   this.groupDataLoaded = true;
    // });
  },
  computed: {
    canViewBooking() {
      const permissions = JSON.parse(localStorage.getItem('permissions') || '[]');
      const hasBookingViewPermission = permissions.includes('booking_view');
      console.log("Can view booking:", hasBookingViewPermission); // 输出是否有权限
      return hasBookingViewPermission;
    },
    canCreateBooking() {
      const permissions = JSON.parse(localStorage.getItem('permissions') || '[]');
      const hasBookingCreatePermission = permissions.includes('booking_create');
      console.log("Can create booking:", hasBookingCreatePermission); // 输出是否有权限
      return hasBookingCreatePermission;
    },
    canEditBooking() {
      const permissions = JSON.parse(localStorage.getItem('permissions') || '[]');
      const hasBookingEditPermission = permissions.includes('booking_edit');
      console.log("Can edit booking:", hasBookingEditPermission); // 输出是否有权限
      return hasBookingEditPermission;
    },
    canDeleteBooking() {
      const permissions = JSON.parse(localStorage.getItem('permissions') || '[]');
      const hasBookingDeletePermission = permissions.includes('booking_delete');
      console.log("Can delete booking:", hasBookingDeletePermission); // 输出是否有权限
      return hasBookingDeletePermission;
    },
  },
  created() {
    axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('token')}`;
  },
  methods: {
    // handlePassportUpload(e) {
    //     const file = e.target.files[0]; // 获取文件
    //     if (file) {
    //         // 创建文件的 URL 用于预览
    //         const fileURL = URL.createObjectURL(file);
    //         this.editingPassenger.passport_upload_url = fileURL;
    //         // 保存文件对象用于后续上传
    //         this.editingPassenger.passport_upload = file;
    //     } else {
    //         this.editingPassenger.passport_upload_url = '';
    //         this.editingPassenger.passport_upload = null;
    //     }
    // },
    handlePassportUpload(files) {
        const file = files[0]; // 获取第一个文件
        if (file) {
            // 创建文件的 URL 用于预览
            const fileURL = URL.createObjectURL(file);
            this.editingPassenger.passport_upload_url = fileURL;
            // 保存文件对象用于后续上传
            this.editingPassenger.passport_upload = file;
        } else {
            this.editingPassenger.passport_upload_url = '';
            this.editingPassenger.passport_upload = null;
        }
    },
    // beforeDestroy() {
    //     if (this.editingPassenger.passport_upload_url) {
    //         URL.revokeObjectURL(this.editingPassenger.passport_upload_url);
    //     }
    // },
    showBookingsPage() {
      this.currentPage = 'bookings';
    },
    showAddBookingPage() {
      this.currentPage = 'addBooking';
    },
    showEditBookingPage(booking) {
      this.editingBooking = Object.assign({}, booking);
      this.currentPage = 'editBooking';
    },
    getBookings() {
      axios.get('/api/bookings')
        .then(response => {
          this.bookings = response.data;
        })
        .catch(error => {
          console.log(error);
        });
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
    addBooking() {
      axios.post('/api/bookings', {
        name: this.name,
      })
      .then(response => {
        console.log(response.data);
        // Redirect to bookings page after successful addition
        this.currentPage = 'bookings';
        this.getBookings();
        // Reset the form fields
        this.name = '';
        this.email = '';
        this.password = '';
      })
      .catch(error => {
        console.log(error);
      });
    },
    editBooking() {
      const bookingData = {
        ...this.editingBooking,
      };
      axios.put(`/api/bookings/${this.editingBooking.id}`, bookingData)
      .then(response => {
        console.log(response.data);
        this.currentPage = 'bookings';
        this.getBookings();
      })
      .catch(error => {
        console.log(error);
      });
    },
    showBookingDetails(booking) {
      this.currentBooking = booking;
      this.currentPage = 'bookingDetails';
    },
    startDeletingBooking(booking) {
    this.itemToDelete = booking;
    this.confirmDelete = true;
    },

    showPassengersPage() {
      this.currentPage = 'passengers';
    },
    showAddPassengerPage() {
      this.currentPage = 'addPassenger';
    },
    showEditPassengerPage(passenger) {
      this.editingPassenger = Object.assign({}, passenger);
      // this.editingPassenger.passport_upload_url = this.passengers.[passenger].passport_upload_url;
      // this.editingPassenger.passport_upload_url = 'http://localhost:8000/storage/passports/OdWLEKmkJuWIB3SZWXBgNNWCyqOo5XAq0Rqk0M03.png';
      this.currentPage = 'editPassenger';
    },

    getPassengers() {
      axios.get('/api/passengers')
        .then(response => {
          this.passengers = response.data;
          // if (this.passengers.length > 0) {
          //   // 假设我们设置第一个乘客为编辑对象
          //   this.editingPassenger = this.passengers[0];
          // }
          // const baseUrl = process.env.BASE_URL.endsWith('/') ? process.env.BASE_URL : process.env.BASE_URL + '/';
          // this.editingPassenger.passport_upload_url = response.data.passport_upload ? baseUrl + response.data.passport_upload : '';
          // this.editingPassenger = response.data;
          // this.editingPassenger.passport_upload_url = response.data.passport_upload ? process.env.BASE_URL + response.data.passport_upload : '';
          if (this.currentBooking) {
            this.currentBooking.passengers = this.passengers.filter(passenger => passenger.booking_id === this.currentBooking.id);
          }
        })
        .catch(error => {
          console.log(error);
        });
    },
    addPassenger() {
      axios.post('/api/passengers', {
        booking_id: this.booking_id,
        name: this.name,
        passport: this.passport,
        passport_upload: this.passport_upload,
        designation: this.designation,
        date_of_birth: this.date_of_birth,
        hp: this.hp,
        remark: this.remark,
      })
      .then(response => {
        console.log(response.data);
        // Redirect to passengers page after successful addition
        this.currentPage = 'passengers';
        this.getPassengers();
        this.booking_id = '';
        this.name = '';
        this.passport = '';
        this.passport_upload = '';
        this.designation = '';
        this.date_of_birth = '';
        this.hp = '';
        this.remark = '';
        // Reset the form fields
        this.name = '';
      })
      .catch(error => {
        console.log(error);
      });
    },
    editPassenger() {
      axios.put(`/api/passengers/${this.editingPassenger.id}`, this.editingPassenger)
        .then(response => {
          console.log(response.data);
          // Redirect to passengers page after successful update
          this.editingpassenger = null;
          this.getPassengers();
          this.getBookings();
          this.currentPage = 'bookingDetails';
        })
        .catch(error => {
          console.log(error);
        });
    },
   
    startDeletingPassenger(passenger) {
      this.itemToDelete = passenger;
      this.confirmDelete = true;
    },

    
    confirmDeleteItem() {
      if (this.currentPage === 'bookings') {
        axios.delete(`/api/bookings/${this.itemToDelete.id}`)
          .then(() => {
            // Remove the booking from the bookings array
            this.bookings = this.bookings.filter(u => u.id !== this.itemToDelete.id);
            this.confirmDelete = false;
          })
          .catch(error => {
            console.log(error);
          });
      } else if (this.currentPage === 'passengers') {
        axios.delete(`/api/passengers/${this.itemToDelete.id}`)
          .then(() => {
            // Remove the passenger from the passengers array
            this.passengers = this.passengers.filter(g => g.id !== this.itemToDelete.id);
            this.confirmDelete = false;
          })
          .catch(error => {
            console.log(error);
          });
      }
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

    getUserTotals() {
      const userTotals = this.users.map(user => {
        const totalAmount = this.bookings
          .filter(booking => booking.user_id === user.id)
          .reduce((total, booking) => total + booking.total, 0);

        return {
          userName: user.name,
          totalAmount: totalAmount
        };
      });

      return userTotals;
    },

    getUsername_old() {
      return this.bookings.map(booking => {
        const correspondingUser = this.users.find(user => user.id === booking.user_id);
        return correspondingUser ? correspondingUser.name : ''; // Return user name if found, otherwise empty string
      });

      // const userTotals = this.users.map(user => {
      //   const totalAmount = this.bookings
      //     .filter(booking => booking.user_id === user.id)
      //     .reduce((total, booking) => total + booking.total, 0);

      //   return {
      //     userName: user.name,
      //     totalAmount: totalAmount
      //   };
      // });

    }

  }
};
</script>

<style  scoped>

</style>