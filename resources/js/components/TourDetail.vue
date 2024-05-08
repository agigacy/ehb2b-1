<template>
    <div v-if="tour">
      <v-row>
        <!-- Loading Modal -->
        <v-dialog v-model="loading" persistent max-width="50%">
          <v-card style="min-height: 300px; padding: 150px; text-align: center;">
            <v-card-text>
              <h3 class="loading-text">Loading...</h3>
            </v-card-text>
            <v-img class="mx-auto" src="http://localhost:8000/images/loading-loader-vertical.gif" width="120px"></v-img>
          </v-card>
        </v-dialog>
        <v-col cols="8" class="mb-4">
          <v-card class="pl-4 pb-2">
            <v-btn @click="$router.back()">back</v-btn>
            <v-card-title>{{ tour.package_name }}</v-card-title>
            <!-- Slider with tour dates and prices -->
            <!-- <v-slider v-model="selectedDate" :items="tour.dates" item-text="date" item-value="price"></v-slider> -->
            <!-- Things to know -->
            
            <v-img src="https://a.cdn-hotels.com/gdcs/production172/d1381/8efd3f69-63bb-4398-a595-095cea25fc37.jpg" height="200px"></v-img>
            <v-card-title>Things to Know</v-card-title>
            <!-- <v-row>
              <v-col cols="4" v-for="item in tour.thingsToKnow" :key="item.id">
                <v-icon>{{ item.icon }}</v-icon>
                <div>{{ item.text }}</div>
              </v-col>
            </v-row> -->
            <p class="pl-4">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Id velit ut tortor pretium viverra suspendisse potenti.
            </p>
            
            <!-- Departure information -->
            <v-card-title><b>Departure Information</b></v-card-title>
            <!-- <div>{{ tour.departure.city }} -> {{ tour.destination.city }}</div> -->
            <div class="pl-4">
              Departure Date: {{ tour.departure_date }}<br />
              Return Date: {{ tour.return_date }}<br />
              Airline: {{ tour.airline }}<br />
              Flight No.: {{ tour.flightNumber }}<br />
              Remark: {{ tour.remark }}
            </div>
            <!-- <div>{{ tour.departure.time }} -> {{ tour.arrival.time }}</div> -->
          </v-card>
          <v-card class="pl-6 pt-2" style="background-color: azure;">
            <v-select
              class="pl-4"
              :items="[1,2,3,4,5,6,7,8,9]"
              label="Select Pax"
              v-model="selectedQuantity"
              @change="onQuantityChange"
              :rules="[v => !!v || 'Please select a quantity']"
            ></v-select>
            <div v-for="(detail, index) in passengerDetails" :key="index" class="pl-4">
              <label>Passenger <span v-if="selectedQuantity > 1">{{ index + 1 }}</span></label>
              <v-text-field
                label="Name"
                v-model="detail.name"
                :rules="[v => !!v || 'Name is required']"
              ></v-text-field>
              <v-text-field
                label="Passport Number"
                v-model="detail.passport"
                :rules="[v => !!v || 'Passport number is required']"
              ></v-text-field>
              <v-text-field
                label="Designation"
                v-model="detail.designation"
                :rules="[v => !!v || 'Designation is required']"
              ></v-text-field>
              <v-text-field
                label="Date of Birth"
                style="max-width: 300px;"
                v-model="detail.dateOfBirth"
                type="date"
                :rules="[v => !!v || 'Date of birth is required']"
              ></v-text-field>
              <v-text-field
                label="HP Number"
                v-model="detail.hp"
                :rules="[v => !!v || 'HP number is required']"
              ></v-text-field>
              <v-textarea
                label="Remark"
                v-model="detail.remark"
                :rules="[v => !!v || 'Remark is required']"
              ></v-textarea>
              <v-file-input
                label="Passport Upload"
                @change="file => onFileChange(file, index)"
                accept="image/*"
                :rules="[v => !!v || 'Passport upload is required']"
              ></v-file-input>
            </div>
          </v-card>
          <br />
        <v-btn class="ml-4 mb-5 btn-lg" color="primary" @click="bookTour">Book Now</v-btn>
        </v-col>
        <v-col cols="4">
          <v-card class="pl-4 pb-5 fixed-summary" style="background-color: blanchedalmond;">
            <v-card-title>Summary</v-card-title>
            <div class="mb-2 pl-3">Tour: <b>{{ tour.package_name }}</b></div>
            <div class="mb-2 pl-3">Code: <b>{{ tour.code }}</b></div>
            <div class="mb-2 pl-3">Departure Date: {{ tour.departure_date }}</div>
            <!-- Conditional rendering for specific fields -->
            <div v-if="selectedQuantity >= 1" class="summary-item pl-3">
              <div class="label">Total Pax:</div>
              <div class="value"><b>{{ selectedQuantity }}</b></div>
            </div>
            <div v-if="!selectedQuantity" class="summary-item pl-3">
              <div class="label"><b>Please Select Total Pax</b></div>
              <!-- <div class="value"><b>{{ selectedQuantity }}</b></div> -->
            </div>
            <div v-if="selectedPrice" class="summary-item pl-3">
              <div class="label">Price Per Pax:</div>
              <div class="value">RM {{ selectedPrice.toFixed(2) }}</div>
            </div>
            <div v-if="total" class="summary-item pl-3">
              <div class="label">Total Before Discount:</div>
              <div class="value">RM {{ total.toFixed(2) }}</div>
            </div>
            <div v-if="discountedTotal" class="summary-item pl-3">
              <div class="label">Total After Discount:</div>
              <div class="value"><b>RM {{ discountedTotal.toFixed(2) }}</b></div>
            </div>
          </v-card>

        </v-col>
      </v-row>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import moment from 'moment';
  export default {
    data() {
      return {
        tour: null,
        selectedDate: null,
        selectedPrice: null,
        selectedQuantity: null, // 默认购买数量为1
        discountedTotal: null,
        total: null,
        passengerDetails: [],
        passengers: [],
        passenger: {
          dateOfBirth: '',
          name: '',
          designation: '',
          hp: '',
          passport: '',
          remark: '',
          passport_upload: ''
        },
        tourDetails: null,
        loading: false
      };
    },
    methods: {
      getTour() {
        const id = this.$route.params.id;
        axios.get(`/api/tours/${id}`)
          .then(response => {
            this.tour = response.data;
          })
          .catch(error => {
            console.log(error);
          });
      },
      onQuantityChange() {
        this.updatePassengerDetails();
        this.calculateTotal();
      },
      calculateTotal() {
        if (this.tour && this.selectedQuantity) {
          const baseTotal = this.tour.tier1 * this.selectedQuantity;
          const discount = this.tour.tier1_c * this.selectedQuantity;
          this.discountedTotal = baseTotal - discount;
          this.selectedPrice = this.tour.tier1; // 更新选中的价格为单个的价格
          this.total = baseTotal; // 更新总价为未折扣前的总价
        }
      },
      updatePassengerDetails() {
        const detailsCount = this.passengerDetails.length;
        if (this.selectedQuantity > detailsCount) {
          for (let i = detailsCount; i < this.selectedQuantity; i++) {
            this.passengerDetails.push({
              name: '',
              passport: '',
              passport_upload: '',
              designation: '',
              dateOfBirth: '',
              hp: '',
              remark: '',
            });
          }
        } else {
          this.passengerDetails = this.passengerDetails.slice(0, this.selectedQuantity);
        }
      },
      onFileChange(file, index) {
        console.log("Received file:", file);  // 打印接收到的文件
          if (file) {
              this.passengerDetails[index].passport_upload = file;
          } else {  
              this.passengerDetails[index].passport_upload = '';
          }
      },
      bookTour_working(){
        // console.log("Passenger details before submitting:", this.passengerDetails);
        const formData = new FormData();

        // Append other booking data to the FormData object
        formData.append('tour_id', this.tour.id);
        formData.append('date', this.selectedDate);
        formData.append('total', this.total);
        formData.append('user_id', 1);
        formData.append('status', 1);

        this.passengerDetails.forEach((detail, index) => {
            formData.append(`passengers[${index}][name]`, detail.name);
            formData.append(`passengers[${index}][passport]`, detail.passport);
            // Add other passenger details as needed
            formData.append(`passengers[${index}][dateOfBirth]`, detail.dateOfBirth);
            formData.append(`passengers[${index}][designation]`, detail.designation);
            formData.append(`passengers[${index}][hp]`, detail.hp);
            formData.append(`passengers[${index}][remark]`, detail.remark);
            formData.append(`passengers[${index}][passport_upload]`, detail.passport_upload);
        });
        for (let [key, value] of formData.entries()) {
            console.log(`${key}: ${value}`);
        }

        axios.post('/api/bookings', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
        .then(response => {
            console.log('Booking successful', response);
            alert('Booking successful!');
            this.$router.push('/agent');
        })
        .catch(error => {
            console.error('Booking failed', error);
            alert('Booking failed. Please try again.');
        });
      },

      bookTour() {
        this.loading = true;
        
        // setTimeout(() => {
        const formData = new FormData();
        formData.append('tour_id', this.tour.id);
        formData.append('date', moment(new Date()).format('YYYY-MM-DD HH:mm:ss'));
        formData.append('total', this.total);
        formData.append('user_id', Number(localStorage.getItem('user_id')));
        formData.append('status', 1);

        this.passengerDetails.forEach((detail, index) => {
            formData.append(`passengers[${index}][name]`, detail.name);
            formData.append(`passengers[${index}][passport]`, detail.passport);
            formData.append(`passengers[${index}][date_of_birth]`, detail.dateOfBirth);
            formData.append(`passengers[${index}][designation]`, detail.designation);
            formData.append(`passengers[${index}][hp]`, detail.hp);
            formData.append(`passengers[${index}][remark]`, detail.remark);
            if (detail.passport_upload instanceof File) {
                formData.append(`passengers[${index}][passport_upload]`, detail.passport_upload);
            }
        });

        axios.post('/api/bookings', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
        .then(response => {
            console.log('Booking successful', response);
            this.loading = false;
            alert('Booking successful!');
            this.$router.push('/agent');
        })
        .catch(error => {
            console.error('Booking failed', error);
            alert('Booking failed. Please try again.');
        });
      // }, 4500); 
    },
      
    },
    mounted() {
      this.getTour();
    },
  };
  </script>
  <style scoped>
    .summary-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
      }

      .label {
        flex: 0 0 180px; /* Adjust based on your preference */
        font-weight: normal;
      }

      .value {
        flex: 1;
        text-align: left;
      }

      .fixed-summary {
        position: fixed;
        top: 100px;           /* Aligns to the top of the viewport */
        right: 0;         /* Aligns to the right of the viewport */
        width: 30%;       /* Adjust this based on your layout's needs */
        height: 45vh;    /* Optional: Makes the card full viewport height */
        overflow-y: auto; /* Adds scroll to the card if content overflows */
      }

      .loading-dialog {
        height: 400px; /* Set the height to 50% of the viewport height */
        display: flex;
        justify-content: center;
        align-items: center;
      }

      .loading-text {
        animation: pulse 1.5s infinite alternate; /* Add animation to the loading text */
      }

      @keyframes pulse {
        0% {
          transform: scale(1);
        }
        100% {
          transform: scale(1.4);
        }
      }

  </style>