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
            <v-row>
              <!-- Replace this with your actual data -->
              <v-col cols="4" v-for="item in tour.thingsToKnow" :key="item.id">
                <v-icon>{{ item.icon }}</v-icon>
                <div>{{ item.text }}</div>
              </v-col>
            </v-row>
            <!-- Departure information -->
            <v-card-title>Departure Information</v-card-title>
            <!-- <div>{{ tour.departure.city }} -> {{ tour.destination.city }}</div> -->
            <!-- <div>{{ tour.departure.date }}</div> -->
            <div>{{ tour.airline }}</div>
            <div>{{ tour.flightNumber }}</div>
            <!-- <div>{{ tour.departure.time }} -> {{ tour.arrival.time }}</div> -->
          </v-card>
        </v-col>
        <v-col cols="4">
          <!-- Summary -->
          <v-card>
            <v-card-title>Summary</v-card-title>
            <div>Tour: {{ tour.package_name }}</div>
            <div>Code: {{ tour.code }}</div>
            <div>Departure Date: {{ selectedDate }}</div>
            <div>Price: {{ selectedPrice }}</div>
            <div>Total: {{ total }}</div>
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
        total: null,
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
    },
    mounted() {
      this.getTour();
    },
  };
  </script>