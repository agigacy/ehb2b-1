<template>
    <div>
      <v-card v-if="currentPage === 'countries'">
        <h1>Select a Country</h1>
        <v-row>
          <v-col cols="12" sm="4" md="4" v-for="country in countries" :key="country.id">
            <v-card @click="selectCountry(country.id)">
              <v-img :src="country.image" height="200px"></v-img>
              <v-card-title>{{ country.name }}</v-card-title>
            </v-card>
          </v-col>
        </v-row>
      </v-card>
  
      <v-card v-if="currentPage === 'tours'">
        <h1>Tour Packages</h1>
        <v-row>
          <v-col cols="12" sm="4" md="4" v-for="tour in tours" :key="tour.id">
            <v-card @click="$router.push({ name: 'TourDetail', params: { id: tour.id } })">
              <v-img :src="tour.image" height="200px"></v-img>
              <v-card-title>{{ tour.package_name }}</v-card-title>
            </v-card>
          </v-col>
        </v-row>
      </v-card>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        currentPage: 'countries',
        countries: [],
        selectedCountry: null,
        tours: [],
      };
    },
    methods: {
      getCountries() {
        axios.get('/api/countries')
          .then(response => {
            this.countries = response.data;
          })
          .catch(error => {
            console.log(error);
          });
      },
      selectCountry(countryId) {
        this.selectedCountry = countryId;
        this.currentPage = 'tours';
        this.getTours();
      },
      getTours() {
        if (this.selectedCountry) {
          axios.get(`/api/tours?country_id=${this.selectedCountry}`)
            .then(response => {
              this.tours = response.data;
            })
            .catch(error => {
              console.log(error);
            });
        }
      },
    },
    mounted() {
      this.getCountries();
    },
  };
  </script>