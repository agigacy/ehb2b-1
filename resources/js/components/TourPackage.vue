<template>
    <div class="ma-4">
      <v-card v-if="currentPage === 'countries'">
        <h5 class="p-2">Destination Country</h5>
        <v-row class="mx-2">
          <v-col cols="12" sm="3" md="3" v-for="country in countries" :key="country.id">
            <v-card @click="selectCountry(country.id)" 
              :disabled="countTours.filter(ctour => ctour.country_id === country.id).length == 0">

              <v-img v-if="country.id === 1" src="https://www.worldometers.info/img/flags/ja-flag.gif" height="30vh" width="auto" style="margin-top: 10px; margin-bottom: 20px;"></v-img>
              <v-img v-if="country.id === 2" src="https://www.worldometers.info/img/flags/tw-flag.gif" height="30vh" width="auto" style="margin-top: 10px; margin-bottom: 20px;"></v-img>
              <v-img v-if="country.id === 3" src="https://www.worldometers.info/img/flags/nz-flag.gif" height="30vh" width="auto" style="margin-top: 10px; margin-bottom: 20px;"></v-img>
              <v-img v-if="country.id === 4" src="https://www.worldometers.info/img/flags/hk-flag.gif" height="30vh" width="auto" style="margin-top: 10px; margin-bottom: 20px;"></v-img>
              <v-img v-if="country.id === 5" src="https://www.worldometers.info/img/flags/th-flag.gif" height="30vh" width="auto" style="margin-top: 10px; margin-bottom: 20px;"></v-img>
              <v-img v-if="country.id === 6" src="https://www.worldometers.info/img/flags/ch-flag.gif" height="30vh" width="auto" style="margin-top: 10px; margin-bottom: 20px;"></v-img>
              <v-img v-if="country.id === 7" src="https://www.worldometers.info/img/flags/as-flag.gif" height="30vh" width="auto" style="margin-top: 10px; margin-bottom: 20px;"></v-img>
              <v-img v-if="country.id === 8" src="https://www.worldometers.info/img/flags/id-flag.gif" height="30vh" width="auto" style="margin-top: 10px; margin-bottom: 20px;"></v-img>
              <v-card-title class="pt-0" style="font-size: 1.2em">{{ country.name }} ({{ countTours.filter(ctour => ctour.country_id === country.id).length }})</v-card-title>
            </v-card>
          </v-col>
        </v-row>
      </v-card>
  
      <!-- <v-card v-if="currentPage === 'tours'">
        <h5 class="p-2">Tour Package(s)</h5>
        <v-btn class="mb-2 ml-2" @click="currentPage = 'countries'">back</v-btn>
        <v-row class="m-2">          
          <v-col cols="12" sm="4" md="4" v-for="tour in tours" :key="tour.id">
            <v-card @click="$router.push({ name: 'TourDetail', params: { id: tour.id } })">
              <v-img src="https://a.cdn-hotels.com/gdcs/production172/d1381/8efd3f69-63bb-4398-a595-095cea25fc37.jpg" height="200px"></v-img>
              <v-card-title>{{ tour.package_name }}</v-card-title>
            </v-card>
          </v-col>
        </v-row>
      </v-card> -->
      <v-card v-if="currentPage === 'tourGroups'">
        <h5 class="p-2">Select Tour Group</h5>
        <v-btn class="mb-2 ml-2" @click="currentPage = 'countries'">back</v-btn>
        <v-row>
          <v-col cols="12" sm="3" md="3" v-for="group in tourGroups" :key="group.id">
            <v-card @click="selectTourGroup(group.id)">
              <v-img :src="group.tour_img_url" height="30vh" width="auto" style="margin-top: 10px; margin-bottom: 20px;"></v-img>
              <v-card-title class="pt-0 text-center"><h5>{{ group.tour_group_name }}</h5></v-card-title>
            </v-card>
          </v-col>
        </v-row>
      </v-card>
      <v-card v-if="currentPage === 'tours'">
        <h5 class="p-2">Select Tour Date</h5>
        <v-btn class="mb-2 ml-2" @click="currentPage = 'tourGroups'">back</v-btn>
        <v-row>
          <v-col cols="12" sm="3" md="3" v-for="tour in selectedTours" :key="tour.id">
            <v-card @click="$router.push({ name: 'TourDetail', params: { id: tour.id } })" class="pt-2">
              <!-- <v-card-title class="pt-0">{{ tour.departure_date }}</v-card-title> -->
              <v-card-title class="pt-0">{{ $formatDate(tour.departure_date) }} <sup class="pl-3 text--secondary">Travel Date</sup></v-card-title>
              <v-card-text>
                <div v-if="tour">
                  Price: {{ displayedPrice(tour) }}
                </div>
                <span v-if="neededPassengers(tour) > 0">({{ neededPassengers(tour) }} TO G)</span>
                <span v-else-if="neededPassengers(tour) === 0">G</span>
                <span v-else>Fully Booked</span>
              </v-card-text>
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
        selectedTours: '',
        tours: [],
        countTours: [],
        accessibleTiers: [],
      };
    },
    computed: {
    //   displayedPrice() {
    //   // Debugging output to check the current state of `tour` and `accessibleTiers`
    //   console.log("Current tour:", this.tour);
    //   console.log("Accessible Tiers:", this.accessibleTiers);

    //   if (!this.tour) {
    //     console.log("No tour selected");
    //     return 'Price not available';
    //   }
    //   if (!Array.isArray(this.accessibleTiers) || this.accessibleTiers.length === 0) {
    //     console.log("No accessible tiers available");
    //     return 'Price not available';
    //   }

    //   const tiers = this.accessibleTiers;
    //   let price = 'Price not available';

    //   if (tiers.includes('Tier 1') && this.tour.tier1) {
    //     price = `${this.tour.tier1}`;
    //   } else if (tiers.includes('Tier 2') && this.tour.tier2) {
    //     price = `${this.tour.tier2}`;
    //   } else if (tiers.includes('Tier 3') && this.tour.tier3) {
    //     price = `${this.tour.tier3}`;
    //   }

    //   return price;
    // }
    },
    methods: {
      displayedPrice(tour) {
        if (!tour || !Array.isArray(tour.accessible_tiers) || tour.accessible_tiers.length === 0) {
          return 'Price not available';
        }

        const tiers = tour.accessible_tiers;
        let prices = [];

        if (tiers.includes('Tier 1') && tour.tier1) {
          prices.push(tour.tier1);
        }
        if (tiers.includes('Tier 2') && tour.tier2) {
          prices.push(tour.tier2);
        }
        if (tiers.includes('Tier 3') && tour.tier3) {
          prices.push(tour.tier3);
        }

        if (prices.length === 0) {
          return 'Price not available';
        } else if (prices.length === 1) {
          return `${prices[0]}`; // 只有一个价格时直接返回
        } else {
          return `${Math.min(...prices)} - ${Math.max(...prices)}`; // 显示价格范围
        }
      },
      // showAccessibleTiers(){
      //   this.accessibleTiers = tours.accessible_tiers
      // },
      neededPassengers(tour) {
        return Math.max(0, tour.min_g - tour.passengers_count);
      },
      selectTourGroup(tourGroupId) {
        // 找到选中的旅游团
        const selectedGroup = this.tourGroups.find(group => group.id === tourGroupId);
        this.selectedTours = selectedGroup.tours;
        // this.accessibleTiers = selectedGroup.tours.accessible_tiers; // Update accessible tiers based on the selected tour
        // this.accessibleTiers = selectedGroup.accessible_tiers; // Assuming each tour has its own accessible_tiers
        this.currentPage = 'tours'; // 切换到显示旅游日期的页面
      },
      countToursCountry() {
        axios.get('/api/tour-groups')
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
        axios.get(`/api/tour-groups/by-country/${countryId}`)
          .then(response => {
            this.tourGroups = response.data;
            this.accessibleTiers = response.data[0].tours[0].accessible_tiers
            this.currentPage = 'tourGroups'; // 切换到显示旅游团的页面
          })
          .catch(error => {
            console.error('Error fetching tour groups:', error);
          });
      },
      // getTours() {
      //   if (this.selectedCountry) {
      //     axios.get(`/api/tours?country_id=${this.selectedCountry}`)
      //       .then(response => {
      //         this.tours = response.data;
      //       })
      //       .catch(error => {
      //         console.log(error);
      //       });
      //   }
      // },
      // getToursByCountry(countryId) {
      //   axios.get(`/api/tours?country_id=${countryId}`)
      //     .then(response => {
      //       this.tours = response.data; // 将获取到的旅游套餐数据赋值给tours
      //       // this.accessibleTiers = response.data.data.accessible_tiers
      //       // 确保response.data是数组且至少有一个元素，且该元素包含tours数组
      //       // if (response.data.length > 0 && response.data[0].tours && response.data[0].tours.length > 0) {
      //       //   this.accessibleTiers = response.data[0].tours[0].accessible_tiers;
      //       // } else {
      //       //   this.accessibleTiers = []; // 如果没有数据，确保accessibleTiers是空数组
      //       // }
      //       this.currentPage = 'tours'; // 切换页面显示到旅游套餐
      //     })
      //     .catch(error => {
      //       console.error('Error fetching tours:', error);
      //     });
      // },
    },
    mounted() {
      this.getCountries();
      this.countToursCountry();
    },
  };
  </script>