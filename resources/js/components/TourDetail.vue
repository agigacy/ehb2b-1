<template>
    <div v-if="tour">
      <v-row>
        <v-col cols="8">
          <v-card>
            <v-card-title>{{ tour.package_name }}</v-card-title>
            <!-- Slider with tour dates and prices -->
            <v-slider v-model="selectedDate" :items="tour.dates" item-text="date" item-value="price"></v-slider>
            <!-- Things to know -->
            <v-card-title>Things to Know</v-card-title>
            <!-- <v-row>
              <v-col cols="4" v-for="item in tour.thingsToKnow" :key="item.id">
                <v-icon>{{ item.icon }}</v-icon>
                <div>{{ item.text }}</div>
              </v-col>
            </v-row> -->
            <p>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Id velit ut tortor pretium viverra suspendisse potenti.
            </p>
            
            <!-- Departure information -->
            <v-card-title>Departure Information</v-card-title>
            <!-- <div>{{ tour.departure.city }} -> {{ tour.destination.city }}</div> -->
            <div>{{ tour.departure_date }}</div>
            <div>{{ tour.return_date }}</div>
            <div>{{ tour.airline }}</div>
            <div>{{ tour.flightNumber }}</div>
            <div>{{ tour.remark }}</div>
            <!-- <div>{{ tour.departure.time }} -> {{ tour.arrival.time }}</div> -->
          </v-card>
          <v-card>
            <v-select :items="[1,2,3,4,5,6,7,8,9]" label="Select Pax" v-model="selectedQuantity" @change="onQuantityChange"></v-select>
            <div v-for="(details, index) in passengerDetails" :key="index">
              <label>Passenger {{ index + 1 }}</label>
              <v-text-field label="Name" v-model="details.name"></v-text-field>
              <v-text-field label="Passport Number" v-model="details.passport"></v-text-field>
              <v-text-field label="Designation" v-model="details.designation"></v-text-field>
              <v-text-field label="Date of Birth" v-model="details.dateOfBirth" type="date"></v-text-field>
              <v-text-field label="HP Number" v-model="details.hp"></v-text-field>
              <v-textarea label="Remark" v-model="details.remark"></v-textarea>
              <v-file-input label="Passport Upload" v-model="details.passportUpload" accept="image/*"></v-file-input>
            </div>
          </v-card>
        <v-btn @click="selectedQuantity && passengerDetails.every(detail => detail.name && detail.passport && detail.designation && detail.dateOfBirth && detail.hp && detail.remark) ? bookTour : null">Book Now</v-btn>
        </v-col>
        <v-col cols="4">
          <!-- Summary -->
          <v-card>
            <v-card-title>Summary</v-card-title>
            <div>Tour: {{ tour.package_name }}</div>
            <div>Code: {{ tour.code }}</div>
            <div>Departure Date: {{ tour.departure_date }}</div>
            <div>Pax: {{ selectedQuantity }}</div>
            <div>Price Per pax: {{ selectedPrice }}</div>
            <div>Total Before Discount: {{ total }}</div>
            <div>Discounted Total: {{ discountedTotal }}</div>
          </v-card>
        </v-col>
      </v-row>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
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
    },
    mounted() {
      this.getTour();
    },
  };
  </script>