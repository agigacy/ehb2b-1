<template>
    <div class="ma-4">
      <v-card v-if="currentPage === 'countries'">
        <h3>Country</h3>
        <v-row>
          <v-col cols="12" sm="3" md="3" v-for="country in countries" :key="country.id">
            <v-card @click="selectCountry(country.id)" 
              :disabled="countTours.filter(ctour => ctour.country_id === country.id).length == 0">

              <v-img v-if="country.id === 1" src="https://www.worldometers.info/img/flags/ja-flag.gif" height="30vh" width="auto" style="margin-top: 20px; margin-bottom: 20px;"></v-img>
              <v-img v-if="country.id === 2" src="https://www.worldometers.info/img/flags/tw-flag.gif" height="30vh" width="auto" style="margin-top: 20px; margin-bottom: 20px;"></v-img>
              <v-img v-if="country.id === 3" src="https://www.worldometers.info/img/flags/nz-flag.gif" height="30vh" width="auto" style="margin-top: 20px; margin-bottom: 20px;"></v-img>
              <v-img v-if="country.id === 4" src="https://www.worldometers.info/img/flags/hk-flag.gif" height="30vh" width="auto" style="margin-top: 20px; margin-bottom: 20px;"></v-img>
              <v-img v-if="country.id === 5" src="https://www.worldometers.info/img/flags/th-flag.gif" height="30vh" width="auto" style="margin-top: 20px; margin-bottom: 20px;"></v-img>
              <v-img v-if="country.id === 6" src="https://www.worldometers.info/img/flags/ch-flag.gif" height="30vh" width="auto" style="margin-top: 20px; margin-bottom: 20px;"></v-img>
              <v-img v-if="country.id === 7" src="https://www.worldometers.info/img/flags/as-flag.gif" height="30vh" width="auto" style="margin-top: 20px; margin-bottom: 20px;"></v-img>
              <v-img v-if="country.id === 8" src="https://www.worldometers.info/img/flags/id-flag.gif" height="30vh" width="auto" style="margin-top: 20px; margin-bottom: 20px;"></v-img>
              <v-card-title class="pt-0">{{ country.name }} ({{ countTours.filter(ctour => ctour.country_id === country.id).length }})</v-card-title>
            </v-card>
          </v-col>
        </v-row>
      </v-card>
  
      <v-card v-if="currentPage === 'tours'">
        <h3>Tour Packages</h3>
        <br />
        <v-btn @click="currentPage = 'countries'">back</v-btn>
        <v-row>
          
          <v-col cols="12" sm="4" md="4" v-for="tour in tours" :key="tour.id">
            <v-card @click="$router.push({ name: 'TourDetail', params: { id: tour.id } })">
              <v-img src="https://a.cdn-hotels.com/gdcs/production172/d1381/8efd3f69-63bb-4398-a595-095cea25fc37.jpg" height="200px"></v-img>
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
        countTours: [],
      };
    },
    methods: {
      countToursCountry() {
        axios.get('/api/tours')
          .then(response => {
              this.countTours = response.data;
          })
          .catch(error => {
            console.log(error);
          });
      },
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
        // Find the selected country from the countries array
        const selectedCountry = this.countries.find(country => country.id === countryId);
        if (selectedCountry) {
          // Assign the tours of the selected country to the tours data property
          this.tours = selectedCountry.tours;
        } else {
          // If no country is found (which should theoretically never happen), clear the tours
          this.tours = [];
        }
        // Change the currentPage to 'tours' to display the tours of the selected country
        this.currentPage = 'tours';
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
      getToursByCountry(countryId) {
        // 假设你有一个API端点可以根据国家ID获取旅游套餐
        axios.get(`/api/tours?country_id=${countryId}`)
          .then(response => {
            this.tours = response.data; // 将获取到的旅游套餐数据赋值给tours
            this.currentPage = 'tours'; // 切换页面显示到旅游套餐
          })
          .catch(error => {
            console.error('Error fetching tours:', error);
          });
      },
    },
    mounted() {
      this.getCountries();
      this.countToursCountry();
    },
  };
  </script>