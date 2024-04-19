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
            <v-list-item @click="currentPage = 'bookings'">
              <v-list-item-action>
                <v-icon>mdi-account-multiple</v-icon>
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
      <v-col cols="12" md="9">
        <v-card v-if="currentPage === 'dashboard'">
          <v-card-title>Dashboard</v-card-title>
          <v-card-text>

            <v-row>
              <v-col cols="12" sm="6" md="4">
                <!-- Grid 4 content here -->
                <v-img src="images/bar_chart.png" height="200px" style="margin-top: 60px; margin-bottom: 60px;"></v-img>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <!-- Grid 5 content here -->
                <v-img src="images/line_chart.png" height="200px" style="margin-top: 60px; margin-bottom: 60px;"></v-img>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <!-- Grid 6 content here -->
                <v-img src="images/legend.png" height="200px" style="margin-top: 60px; margin-bottom: 60px;"></v-img>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" sm="6" md="4">
                <!-- Grid 4 content here -->
                <v-img src="images/line_chart.png" height="200px" style="margin-top: 60px; margin-bottom: 60px;"></v-img>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <!-- Grid 5 content here -->
                <v-img src="images/bar_chart.png" height="200px" style="margin-top: 60px; margin-bottom: 60px;"></v-img>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <!-- Grid 6 content here -->
                <v-img src="images/pie_chart.png" height="200px" style="margin-top: 60px; margin-bottom: 60px;"></v-img>
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
              <template v-slot:item.user_id="{ item }">
                {{ item.user.name }}
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
                <v-btn small color="red darken-1" text @click="startDeletingBooking(item)">
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
            <p>Date: {{ currentBooking.date }}</p>
            <p>Total: {{ currentBooking.total }}</p>
            <h3>Passengers:</h3>
            <v-data-table :headers="passengerHeaders" :items="currentBooking.passengers" :footer-props="{ itemsPerPageOptions: [5, 10, 25, 50] }">
            <template v-slot:item.index="{ index }">
                {{ index + 1 }}
            </template>
            <template v-slot:item.actions="{ item }">
                <v-btn small color="blue darken-1" text @click="showEditPassengerPage(item)">
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

export default {
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
      bookingHeaders: [
        { text: 'No', value: 'index' },
        { text: 'Tour', value: 'tour_id' },
        { text: 'User', value: 'user_id' },
        { text: 'Date', value: 'date' },
        { text: 'Total', value: 'total' },
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
    }
  },
  mounted() {
    this.getBookings();
    this.getPassengers();
  },
  created() {
    axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('token')}`;
  },
  methods: {
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
      return axios.get('/api/bookings')
        .then(response => {
          this.bookings = response.data;
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
      this.currentPage = 'editPassenger';
    },

    getPassengers() {
      axios.get('/api/passengers')
        .then(response => {
          this.passengers = response.data;
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

  }
};
</script>