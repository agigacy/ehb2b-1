<template>
    <div v-if="tour">
      <v-row>
        <v-col cols="8">
          <v-card class="pl-4 pb-2">
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
            <v-select class="pl-4" :items="[1,2,3,4,5,6,7,8,9]" label="Select Pax" v-model="selectedQuantity" @change="onQuantityChange"></v-select>
            <div v-for="(detail, index) in passengerDetails" :key="index" class="pl-4">
              <label>Passenger <span v-if="selectedQuantity > 1">{{ index + 1 }}</span></label>
              <v-text-field label="Name" v-model="detail.name"></v-text-field>
              <v-text-field label="Passport Number" v-model="detail.passport"></v-text-field>
              <v-text-field label="Designation" v-model="detail.designation"></v-text-field>
              <v-text-field label="Date of Birth" style="max-width: 300px;" v-model="detail.dateOfBirth" type="date"></v-text-field>
              <v-text-field label="HP Number" v-model="detail.hp"></v-text-field>
              <v-textarea label="Remark" v-model="detail.remark"></v-textarea>
              <v-file-input label="Passport Upload" v-model="detail.passportUpload" @change="onFileChange" accept="image/*"></v-file-input>
            </div>
          </v-card>
          <br />
        <v-btn class="ml-2" @click="bookTour">Book Now</v-btn>
        </v-col>
        <v-col cols="4">
          <!-- Summary -->
          <!-- <v-card class="pl-4 pb-5" style="background-color: blanchedalmond;">
            <v-card-title>Summary</v-card-title>
            <div>Tour: <b>{{ tour.package_name }}</b></div>
            <div>Code: <b>{{ tour.code }}</b></div>
            <div>Departure Date: {{ tour.departure_date }}</div>
            <div v-if="selectedQuantity < 0">Total Pax: {{ selectedQuantity }}</div>
            <div v-if="selectedPrice">Price Per Pax: RM {{ selectedPrice.toFixed(2) }}</div>
            <div v-if="total">Total Before Discount: RM {{ total.toFixed(2) }}</div>
            <div v-if="discountedTotal">Total After Discount: <b>RM {{ discountedTotal.toFixed(2) }}</b></div>
          </v-card> -->
          <v-card class="pl-4 pb-5" style="background-color: blanchedalmond;">
            <v-card-title>Summary</v-card-title>
            <div class="mb-2">Tour: <b>{{ tour.package_name }}</b></div>
            <div class="mb-2">Code: <b>{{ tour.code }}</b></div>
            <div class="mb-2">Departure Date: {{ tour.departure_date }}</div>
            <div class="summary-item" v-for="(value, key) in tourDetails" :key="key">
              <div class="label">{{ key }}:</div>
              <div class="value"><b>{{ value }}</b></div>
            </div>
            <!-- Conditional rendering for specific fields -->
            <div v-if="selectedQuantity >= 0" class="summary-item">
              <div class="label">Total Pax:</div>
              <div class="value">{{ selectedQuantity }}</div>
            </div>
            <div v-if="selectedPrice" class="summary-item">
              <div class="label">Price Per Pax:</div>
              <div class="value">RM {{ selectedPrice.toFixed(2) }}</div>
            </div>
            <div v-if="total" class="summary-item">
              <div class="label">Total Before Discount:</div>
              <div class="value">RM {{ total.toFixed(2) }}</div>
            </div>
            <div v-if="discountedTotal" class="summary-item">
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
          passportUpload: ''
        }

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
              passportUpload: null,
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
      bookTour_working(){
        const formData = new FormData();
        formData.append('passportUpload', this.detail.passportUpload);

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
            formData.append(`passengers[${index}][passportUpload]`, detail.passportUpload);
        });

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
        // 构建请求体
        const bookingData = {
          tour_id: this.tour.id,
          date: this.selectedDate, // 确保你有一个选择日期的输入
          total: this.total, // 这应该是计算出的总价
          user_id: 1,
          status: 1,
          date: moment(this.date).format('YYYY-MM-DD HH:mm:ss'),
          passengers: this.passengerDetails.map(detail => ({
            name: detail.name,
            passport: detail.passport,
            date_of_birth: detail.dateOfBirth,
            designation: detail.designation,
            hp: detail.hp,
            remark: detail.remark,
            passport_upload: detail.passportUpload, // 这里假设你已经处理了文件上传，并有一个URL或标识符
          }))
        };

        // 发送 POST 请求到后端 API
        axios.post('/api/bookings', bookingData)
          .then(response => {
            // 处理成功的响应
            console.log('Booking successful', response);
            alert('Booking successful!');
            this.$router.push('/agent');
          })
          .catch(error => {
            // 处理错误
            console.error('Booking failed', error);
            alert('Booking failed. Please try again.');
          });
      },
      onFileChange(event) {
       const file = event.target.files[0];
       this.detail.passportUpload = file;
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
        flex: 0 0 200px; /* Adjust based on your preference */
        font-weight: bold;
      }

      .value {
        flex: 1;
        text-align: left;
      }

  </style>