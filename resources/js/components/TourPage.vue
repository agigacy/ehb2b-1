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
              <!-- <span class="material-icons pr-1">face</span> -->
              <v-list-item-content :class="{ 'active': currentPage === 'dashboard' }">Dashboard</v-list-item-content>
            </v-list-item>
            <v-list-item @click="currentPage = 'countries'">
              <v-list-item-action>
                <!-- <v-icon>mdi-account-country</v-icon> -->
                <span class="material-symbols-outlined">language </span>
              </v-list-item-action>
              <v-list-item-content :class="{ 'active': currentPage === 'countries' }">Countries</v-list-item-content>
            </v-list-item>
            <v-list-item @click="currentPage = 'flight_tickets'">
              <v-list-item-action>
                <!-- <v-icon>mdi-account-flight_ticket</v-icon> -->
                <!-- <span class="material-symbols-outlined">language </span> -->
                <span class="material-symbols-outlined">flightsmode</span>
              </v-list-item-action>
              <v-list-item-content :class="{ 'active': currentPage === 'flight_tickets' }">Flight Tickets</v-list-item-content>
            </v-list-item>
            <v-list-item @click="currentPage = 'tours'">
              <v-list-item-action>
                <!-- <v-icon>mdi-account-tour</v-icon> -->
                <span class="material-symbols-outlined">tour</span>
              </v-list-item-action>
              <v-list-item-content :class="{ 'active': currentPage === 'tours' }">Tours</v-list-item-content>
            </v-list-item>
            <!-- Add more items here -->
          </v-list>
        </v-card>
      </v-col>
      <v-col cols="12" md="10">
        <v-card v-if="currentPage === 'dashboard'">
          <!-- <v-card-title>Dashboard</v-card-title> -->
          <v-card-title class="py-2 px-4" style="background-color: bisque; width: 100%; padding-left: 28px; font-size: 14px; font-weight: bold">Dashboard</v-card-title>
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
                <v-card-title class="justify-center"><h6>Total Booking By Tour</h6></v-card-title>
                <apexchart v-if="groupDataLoaded" type="donut" :options="groupChartOptions4" :series="groupSeries4"></apexchart>
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
        <v-card v-if="currentPage === 'countries'">
          <!-- <v-card-title>Countries</v-card-title> -->
          <v-card-title class="py-2 px-4" style="background-color: bisque; width: 100%; padding-left: 28px; font-size: 14px; font-weight: bold">Countries</v-card-title>
          <v-card-text>
            <v-data-table :headers="countryHeaders" :items="countries" :footer-props="{ itemsPerPageOptions: [5, 10, 25, 50] }">
              <template v-slot:item.index="{ index }">
                {{ index + 1 }}
              </template>
              <template v-slot:item.actions="{ item }">
                <v-btn small color="blue darken-1" text @click="showEditCountryPage(item)">
                  <v-icon small>mdi-pencil</v-icon>
                  Edit
                </v-btn>
                <v-btn small color="red darken-1" text @click="startDeletingCountry(item)">
                  <v-icon small>mdi-delete</v-icon>
                  Delete
                </v-btn>
              </template>
            </v-data-table>
            <v-btn @click="currentPage = 'addCountry'">Add Country</v-btn>
          </v-card-text>
        </v-card>
        <v-card v-if="currentPage === 'addCountry'">
          <v-card-title>Add Country</v-card-title>
          <v-card-text>
            <v-form @submit.prevent="addCountry">
              <v-text-field label="Name" type="text" v-model="name" required></v-text-field>
              <v-btn @click="currentPage = 'countries'">Back</v-btn>
              <v-btn type="submit">Add Country</v-btn>
            </v-form>
          </v-card-text>
        </v-card>
        <v-card v-if="currentPage === 'editCountry'">
          <v-card-title>Edit Country</v-card-title>
          <v-card-text>
            <v-form @submit.prevent="editCountry">
              <v-text-field label="Name" type="text" v-model="editingCountry.name" required></v-text-field>
              <v-btn @click="currentPage = 'countries'">Cancel</v-btn>
              <v-btn type="submit">Save</v-btn>
            </v-form>
          </v-card-text>
        </v-card>
        <v-card v-if="currentPage === 'flight_tickets'">
          <!-- <v-card-title>Flight Tickets</v-card-title> -->
          <v-card-title class="py-2 px-4" style="background-color: bisque; width: 100%; padding-left: 28px; font-size: 14px; font-weight: bold">Flight Tickets (PNR)</v-card-title>
          <v-card-text>
            <v-text-field v-model="searchText" label="Search" single-line hide-details></v-text-field>
            <flat-pickr
              :modelValue="searchDate"
              :config="dateConfigSearch"
              @update:modelValue="value => searchDate = value"
              placeholder="Search by departure date"
            ></flat-pickr>
            <v-btn small color="blue" v-if="searchDate" @click="searchDate = null">Clear</v-btn>
            <v-data-table :headers="flight_ticketHeaders" :items="filteredFlightTickets" :footer-props="{ itemsPerPageOptions: [5, 10, 25, 50] }">
              <template v-slot:item.index="{ index }">
                {{ index + 1 }}
              </template>
              <template v-slot:item.departure_date="{ item }">
                {{ $formatDate(item.departure_date) }}
              </template>
              <template v-slot:item.return_date="{ item }">
                {{ $formatDate(item.return_date) }}
              </template>
              <template v-slot:header.icon={item} v-slot:item.icon="{ item }">
                <v-icon>flight_takeoff</v-icon>
              </template>
              <template v-slot:item.icon="{ item }">
                <span class="material-symbols-outlined" title="Round trip">swap_horiz</span>
              </template>
              <template v-slot:item.actions="{ item }">
                <v-btn small color="blue darken-1" text @click="showEditFlightTicketPage(item)">
                  <v-icon small>mdi-pencil</v-icon>
                  Edit
                </v-btn>
                <v-btn small color="red darken-1" text @click="startDeletingFlightTicket(item)">
                  <v-icon small>mdi-delete</v-icon>
                  Delete
                </v-btn>
              </template>
            </v-data-table>
            <v-btn @click="currentPage = 'addFlightTicket'">Add Flight Ticket</v-btn>
          </v-card-text>
        </v-card>
        <v-card v-if="currentPage === 'addFlightTicket'">
          <v-card-title>Add Flight Ticket</v-card-title>
          <v-card-text>
            <v-form @submit.prevent="addFlightTicket">
              <v-text-field label="PNR" type="text" v-model="pnr" required></v-text-field>
              <v-text-field label="Airline" type="text" v-model="airline" required></v-text-field>
              <v-text-field label="Departure Date" type="text" v-model="departure_date" required></v-text-field>
              <v-text-field label="Return Date" type="text" v-model="return_date" required></v-text-field>
              <label class="my-label">Departure Date</label>
              <flat-pickr
                :modelValue="departure_date"
                @update:modelValue="value => departure_date = value"
                :config="dateConfig"
              ></flat-pickr>
              <label class="my-label">Return Date</label>
              <flat-pickr
                :modelValue="return_date"
                @update:modelValue="value => return_date = value"
                :config="dateConfig"
              ></flat-pickr>
              <v-text-field label="From" type="text" v-model="from" required></v-text-field>
              <v-text-field label="To" type="text" v-model="to" required></v-text-field>
              <v-text-field label="Seat" type="text" v-model="seat" required></v-text-field>
              <v-btn @click="currentPage = 'flight_tickets'">Back</v-btn>
              <v-btn type="submit">Add FlightTicket</v-btn>
            </v-form>
          </v-card-text>
        </v-card>
        <v-card v-if="currentPage === 'editFlightTicket'">
          <v-card-title>Edit FlightTicket</v-card-title>
          <v-card-text>
            <v-form @submit.prevent="editFlightTicket">
              <v-text-field label="PNR" type="text" v-model="editingFlightTicket.pnr" required></v-text-field>
              <v-text-field label="Airline" type="text" v-model="editingFlightTicket.airline" required></v-text-field>
              <label class="my-label">Departure Date</label>
              <flat-pickr
                :modelValue="editingFlightTicket.departure_date"
                @update:modelValue="value => editingFlightTicket.departure_date = value"
                :config="dateConfig"
              ></flat-pickr>
              <label class="my-label">Return Date</label>
              <flat-pickr
                :modelValue="editingFlightTicket.return_date"
                @update:modelValue="value => editingFlightTicket.return_date = value"
                :config="dateConfig"
              ></flat-pickr>
              <v-text-field label="From" type="text" v-model="editingFlightTicket.from" required></v-text-field>
              <v-text-field label="To" type="text" v-model="editingFlightTicket.to" required></v-text-field>
              <v-text-field label="Seat" type="text" v-model="editingFlightTicket.seat" required></v-text-field>
              <v-btn @click="currentPage = 'flight_tickets'">Cancel</v-btn>
              <v-btn type="submit">Save</v-btn>
            </v-form>
          </v-card-text>
        </v-card>
        <v-card v-if="currentPage === 'tours'">
          <!-- <v-card-title>Tours</v-card-title> -->
          <v-card-title class="py-2 px-4" style="background-color: bisque; width: 100%; padding-left: 28px; font-size: 14px; font-weight: bold">Tours</v-card-title>
          <v-card-text>
            <v-text-field v-model="searchPackageName" label="Search by package name"></v-text-field>
            <flat-pickr
              :modelValue="searchDepartureDate"
              :config="dateConfigSearch"
              @update:modelValue="value => searchDepartureDate = value"
              placeholder="Search by departure date"
            ></flat-pickr>
            <v-btn small color="blue" v-if="searchDepartureDate" @click="searchDepartureDate = ''">Clear</v-btn>
            <v-text-field v-model="searchAirline" label="Search by airline"></v-text-field>
            <v-data-table :headers="tourHeaders" :items="filteredTours" :footer-props="{ itemsPerPageOptions: [5, 10, 25, 50] }">
              <template v-slot:item.index="{ index }">
                {{ index + 1 }}
              </template>
              <template v-slot:item.departure_date="{ item }">
                {{ $formatDate(item.departure_date) }}
              </template>
              <template v-slot:item.remark="{ item }">
                <div style="max-width: 360px;">
                  {{ item.remark }}
                </div>
              </template>
              <template v-slot:item.group="{ item }">
                {{ item.groups?.map(group => group.name).join(', ') }}
              </template>
              <template v-slot:item.actions="{ item }">
                <v-btn small color="green darken-1" text @click="showViewTourPage(item)">
                  <v-icon small>mdi-eye</v-icon>
                  View
                </v-btn>
                <!-- <v-btn small color="blue darken-1" text @click="showEditTourPage(item)">
                  <v-icon small>mdi-pencil</v-icon>
                  Edit
                </v-btn> -->
                <v-btn small color="red darken-1" text @click="startDeletingTour(item)">
                  <v-icon small>mdi-delete</v-icon>
                  Delete
                </v-btn>
              </template>
            </v-data-table>
            <v-btn @click="currentPage = 'addTour'">Add Tour</v-btn>
          </v-card-text>
        </v-card>
        <v-card v-if="currentPage === 'viewTour'">
          <v-card-title>{{ viewingTour.package_name }}</v-card-title>
          <v-card-text>
            <p><strong>Package Name (Chinese):</strong> {{ viewingTour.package_name_chinese }}</p>
            <p><strong>Airline:</strong> {{ viewingTour.airline }}</p>
            <p><strong>Tour Code:</strong> {{ viewingTour.code }}</p>
            <p><strong>Departure Date:</strong> {{ viewingTour.departure_date }}</p>
            <p><strong>Return Date:</strong> {{ viewingTour.return_date }}</p>
            <p><strong>Special Price:</strong> {{ viewingTour.sp }}</p>
            <p><strong>Tier 1 Price:</strong> {{ viewingTour.tier1 }}</p>
            <p><strong>Tier 2 Price:</strong> {{ viewingTour.tier2 }}</p>
            <p><strong>Tier 3 Price:</strong> {{ viewingTour.tier3 }}</p>
            <p><strong>Special Price (Commission):</strong> {{ viewingTour.sp }}</p>
            <p><strong>Tier 1 Price (Commission):</strong> {{ viewingTour.tier1_c }}</p>
            <p><strong>Tier 2 Price (Commission):</strong> {{ viewingTour.tier2_c }}</p>
            <p><strong>Tier 3 Price (Commission):</strong> {{ viewingTour.tier3_c }}</p>
            <p><strong>Country:</strong> {{ viewingTour.country ? viewingTour.country.name : '' }}</p>
            <p><strong>Minimum Group Size:</strong> {{ viewingTour.min_g }}</p>
            <p><strong>Flight Tickets:</strong> {{ viewingTour.flight_tickets.map(ticket => ticket.pnr).join(', ') }}</p>
            <p><strong>Total Seats:</strong> {{ viewingTour.flight_tickets.reduce((total, ticket) => total + Number(ticket.seat), 0) }}</p>
            <!-- <p><strong>Total Seats1:</strong> {{ Array.isArray(viewingTour.flight_tickets) ? viewingTour.flight_tickets.reduce((total, ticket) => total + Number(ticket.seat), 0) : 0 }}</p> -->
            <p><strong>Remark:</strong> {{ viewingTour.remark }}</p>
            <v-btn @click="currentPage = 'tours'">Back</v-btn>
            <v-btn @click="showEditTourPage(viewingTour)">Edit</v-btn>
            <v-btn @click="showDuplicateTourPage(viewingTour)">Duplicate</v-btn>
          </v-card-text>
        </v-card>
        <v-card v-if="currentPage === 'addTour'">
          <v-card-title>Add Tour</v-card-title>
          <v-card-text>
            <v-form @submit.prevent="addTour">
              <v-text-field label="Package Name" type="text" v-model="package_name" required></v-text-field>
              <v-text-field label="Package Name (Chinese)" type="text" v-model="package_name_chinese"></v-text-field>
              <v-text-field label="Airline" type="text" v-model="airline" required></v-text-field>
              <v-text-field label="Tour Code" type="text" v-model="code" required></v-text-field>
              <label class="my-label">Departure Date</label>
              <flat-pickr
                :modelValue="departure_date"
                @update:modelValue="value => departure_date = value"
                :config="dateConfig"
              ></flat-pickr>
              <label class="my-label">Return Date</label>
              <flat-pickr
                :modelValue="return_date"
                @update:modelValue="value => return_date = value"
                :config="dateConfig"
              ></flat-pickr>
              <v-text-field label="Special Price" type="text" v-model="sp"></v-text-field>
              <v-text-field label="Tier 1 Price" type="text" v-model="tier1"></v-text-field>
              <v-text-field label="Tier 2 Price" type="text" v-model="tier2"></v-text-field>
              <v-text-field label="Tier 3 Price" type="text" v-model="tier3" required></v-text-field>
              <v-text-field label="Special Price (Commission)" type="text" v-model="sp_c"></v-text-field>
              <v-text-field label="Tier 1 Price (Commission)" type="text" v-model="tier1_c"></v-text-field>
              <v-text-field label="Tier 2 Price (Commission)" type="text" v-model="tier2_c"></v-text-field>
              <v-text-field label="Tier 3 Price (Commission)" type="text" v-model="tier3_c" required></v-text-field>
              <v-select
                label="Country"
                :items="countries"
                item-text="name"
                item-value="id"
                v-model="country_id"
                required
              ></v-select>
              <v-text-field label="Minimum Group Size" type="text" v-model="min_g" required></v-text-field>
              <v-select
              label="Flight Tickets"
              :items="flight_tickets"
              item-text="pnr"
              item-value="id"
              v-model="selectedFlightTickets"
              multiple
              ></v-select>
              <v-text-field label="Remark" type="text" v-model="remark"></v-text-field>
              <v-btn @click="currentPage = 'tours'">Back</v-btn>
              <v-btn type="submit">Add Tour</v-btn>
            </v-form>
          </v-card-text>
        </v-card>
        <v-card v-if="currentPage === 'editTour'">
          <v-card-title>Edit Tour</v-card-title>
          <v-card-text>
            <v-form @submit.prevent="editTour">
              <v-text-field label="Package Name" type="text" v-model="editingTour.package_name" required></v-text-field>
              <v-text-field label="Package Name (Chinese)" type="text" v-model="editingTour.package_name_chinese"></v-text-field>
              <v-text-field label="Airline" type="text" v-model="editingTour.airline" required></v-text-field>
              <v-text-field label="Tour Code" type="text" v-model="editingTour.code" required></v-text-field>
              <label class="my-label">Departure Date</label>
              <flat-pickr
                :modelValue="editingTour.departure_date"
                :config="dateConfig"
                @update:modelValue="value => editingTour.departure_date = value"
              ></flat-pickr>
              <label class="my-label">Return Date</label>
              <flat-pickr
                :modelValue="editingTour.return_date"
                :config="dateConfig"
                @update:modelValue="value => editingTour.return_date = value"
              ></flat-pickr>
              <v-text-field label="Special Price" type="text" v-model="editingTour.sp"></v-text-field>
              <v-text-field label="Tier 1 Price" type="text" v-model="editingTour.tier1"></v-text-field>
              <v-text-field label="Tier 2 Price" type="text" v-model="editingTour.tier2"></v-text-field>
              <v-text-field label="Tier 3 Price" type="text" v-model="editingTour.tier3" required></v-text-field>
              <v-text-field label="Special Price (Commission)" type="text" v-model="editingTour.sp_c"></v-text-field>
              <v-text-field label="Tier 1 Price (Commission)" type="text" v-model="editingTour.tier1_c"></v-text-field>
              <v-text-field label="Tier 2 Price (Commission)" type="text" v-model="editingTour.tier2_c"></v-text-field>
              <v-text-field label="Tier 3 Price (Commission)" type="text" v-model="editingTour.tier3_c" required></v-text-field>
              <v-select
                label="Country"
                :items="countries"
                item-text="name"
                item-value="id"
                v-model="editingTour.country_id"
                required
              ></v-select>
              <v-text-field label="Minimum Group Size" type="text" v-model="editingTour.min_g" required></v-text-field>
              <v-select
              label="Flight Tickets"
              :items="flight_tickets"
              item-text="pnr"
              item-value="id"
              v-model="editingTourFlightTickets"
              multiple
              ></v-select>
              <v-text-field label="Remark" type="text" v-model="editingTour.remark"></v-text-field>
              <v-btn @click="currentPage = 'tours'">Cancel</v-btn>
              <v-btn type="submit">Save</v-btn>
            </v-form>
          </v-card-text>
        </v-card>
        <v-card v-if="currentPage === 'duplicateTour'">
          <v-card-title>Duplicate Tour</v-card-title>
          <v-card-text>
            <v-form @submit.prevent="duplicateTour">
              <v-text-field label="Package Name" type="text" v-model="duplicatingTour.package_name" required></v-text-field>
              <v-text-field label="Package Name" type="text" v-model="duplicatingTour.package_name" required></v-text-field>
              <v-text-field label="Package Name (Chinese)" type="text" v-model="duplicatingTour.package_name_chinese"></v-text-field>
              <v-text-field label="Airline" type="text" v-model="duplicatingTour.airline" required></v-text-field>
              <v-text-field label="Tour Code" type="text" v-model="duplicatingTour.code" required></v-text-field>
              <v-text-field label="Departure Date" type="text" v-model="duplicatingTour.departure_date" required></v-text-field>
              <v-text-field label="Return Date" type="text" v-model="duplicatingTour.return_date" required></v-text-field>
              <v-text-field label="Special Price" type="text" v-model="duplicatingTour.sp"></v-text-field>
              <v-text-field label="Tier 1 Price" type="text" v-model="duplicatingTour.tier1"></v-text-field>
              <v-text-field label="Tier 2 Price" type="text" v-model="duplicatingTour.tier2"></v-text-field>
              <v-text-field label="Tier 3 Price" type="text" v-model="duplicatingTour.tier3" required></v-text-field>
              <v-text-field label="Special Price (Commission)" type="text" v-model="duplicatingTour.sp_c"></v-text-field>
              <v-text-field label="Tier 1 Price (Commission)" type="text" v-model="duplicatingTour.tier1_c"></v-text-field>
              <v-text-field label="Tier 2 Price (Commission)" type="text" v-model="duplicatingTour.tier2_c"></v-text-field>
              <v-text-field label="Tier 3 Price (Commission)" type="text" v-model="duplicatingTour.tier3_c" required></v-text-field>
              <v-select
                label="Country"
                :items="countries"
                item-text="name"
                item-value="id"
                v-model="editingTour.country_id"
                required
              ></v-select>
              <v-text-field label="Minimum Group Size" type="text" v-model="duplicatingTour.min_g" required></v-text-field>
              <v-text-field label="Remark" type="text" v-model="duplicatingTour.remark"></v-text-field>
              <v-btn @click="currentPage = 'tours'">Cancel</v-btn>
              <v-btn type="submit">Duplicate</v-btn>
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
import flatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';
import moment from 'moment';
import VueApexCharts from 'vue-apexcharts';

export default {
  components: {
    flatPickr, apexchart: VueApexCharts,
  },
  data() {
    return {
      name: '',
      email: '',
      password: '',
      currentPage: 'dashboard', // 'countries', 'addCountry', 'editCountry', 'flight_tickets', 'addFlightTicket', 'editFlightTicket'
      editingCountry: null,
      editingFlightTicket: null,
      countryToDelete: null,
      confirmDelete: false,
      itemToDelete: null,
      departure_date: '',
      return_date: '', 
      editingTourFlightTickets: [],
      selectedFlightTickets: [],
      // editingCountryRoles: '',
      searchPackageName: '',
      searchDepartureDate: '',
      searchAirline: '',
      searchText: '',
      searchDate: '',
      duplicatingTour: {},
      editingTour: {},
      countries: [],
      flight_tickets: [],
      roles: [],
      tours: [],
      countryHeaders: [
        { text: 'No', value: 'index' },
        { text: 'Name', value: 'name' },
        { text: 'Actions', value: 'actions' },
      ],
      flight_ticketHeaders: [
        { text: 'No', value: 'index' },
        { text: 'PNR', value: 'pnr' },
        { text: 'Airline', value: 'airline' },
        { text: 'Seat', value: 'seat' },
        { text: 'Departure Date', value: 'departure_date' },
        { text: 'From', value: 'from' },
        { text: 'Icon', value: 'icon' },
        { text: 'To', value: 'to' },
        { text: 'Return Date', value: 'return_date' },
        { text: 'Actions', value: 'actions' },
      ],
      tourHeaders: [
        { text: 'No', value: 'index' },
        { text: 'Name', value: 'package_name' },
        { text: 'Airline', value: 'airline' },
        { text: 'Code', value: 'code' },
        { text: 'Departure Date', value: 'departure_date' },
        { text: 'Remark', value: 'remark' },
        { text: 'Actions', value: 'actions' },
      ],
      labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
      value: [10, 15, 7, 20, 10],
      // editingTour: {
      //   departure_date: '',
      //   return_date: '',
      //   // ...
      // },
      dateConfig: {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        // defaultDate: this.editingTour.departure_date, // Add this line
      },
      dateConfigSearch: {
        enableTime: false,
        dateFormat: 'Y-m-d',
        allowInput: true,
        showClearDate: true,
      },
      groupSeries: [],
      // groupChartOptions: {
      //   chart: {
      //     type: 'donut',
      //   },
      //   labels: [], // 这里将用于显示组名
      // },
      groupChartOptions: {
        chart: {
          type: 'donut',
          height: 350
        },
        series: [{
          name: 'Sales',
          data: this.groupSeries // This assumes you're keeping the numerical data for charting
        }],
        tooltip: {
          y: {
            formatter: (val) => {
              // Now 'this' refers to the Vue instance, where $formatCurrency is defined
              const formattedValue = this.$formatCurrency(val); // Assuming 'RM' is default
              return formattedValue;
            }
          }
          // y: {
          //   formatter: function (val) {
          //     // return `RM: ${val.toFixed(2)}`;
          //     const formattedValue = this.$formatCurrency(val); // Assuming 'RM' is default
          //     return formattedValue;
          //   }
          // }
        },
        // dataLabels: {
        //   enabled: true,
        //   formatter: function (val) {
        //     // return `Total: $${val.toFixed(2)}`;
        //   }
        // }
      },
      groupSeries4: [],
      groupChartOptions4: {
        chart: {
          type: 'donut',
        },
        labels: [], // 这里将用于显示组名

        tooltip: {
          y: {
            formatter: (val) => {
              // Now 'this' refers to the Vue instance, where $formatCurrency is defined
              const formattedValue = this.$formatCurrency(val); // Assuming 'RM' is default
              return formattedValue;
            }
          }
        },
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
      bookings: []
    }
  },
  mounted() {
    this.getCountries();
    this.getFlightTickets();
    this.getTours();
    this.getUsers();
    this.getBookings();
    this.getGroups().then(() => {      

      this.groupSeries = Object.values(this.bookings.reduce((acc, booking) => {
        if (!acc[booking.user_id]) {
          acc[booking.user_id] = 0;
        }
        acc[booking.user_id] += booking.total;
        return acc;
      }, {}));

      // New method to sort user id accordingly
      const userIds = [...new Set(this.bookings.map(booking => booking.user_id))];
      userIds.sort((a, b) => a - b);
      // Map sorted user IDs to corresponding user names
      this.groupChartOptions.labels = userIds.map(userId => {
          const user = this.users.find(user => user.id === userId);
          // return user ? user.name : '';
          return user ? user.name.charAt(0).toUpperCase() + user.name.slice(1) : '';
      });

      // // OLD method user id not sorting so matching wrong data
      // this.groupChartOptions.labels = [...new Set(this.bookings.map(booking => {
      //   const user = this.users.find(user => user.id === booking.user_id);
      //   return user? user.name : '';
      // }))];
      
      // this.groupSeries4 = [40, 50, 90];
      
      this.groupSeries4 = Object.values(this.bookings.reduce((acc, booking) => {
        if (!acc[booking.tour_id]) {
          acc[booking.tour_id] = 0;
        }
        acc[booking.tour_id] += booking.total;
        return acc;
      }, {}));
      
      this.groupChartOptions4.labels = [...new Set(this.bookings.map(booking => {
        // const user = this.users.find(user => user.id === booking.tour_id);
        // return user? user.name : '';
        const tour = this.tours.find(tour => tour.id === booking.tour_id);
        // return tour? tour.package_name : '';
        return tour ? tour.package_name.slice(0, 14) + '..' : 'unknown';
        // return tour ? tour.package_name.slice(0, tour.package_name.indexOf(',')) + '..' : ''; // Slice text after comma 

      }))];

      this.groupDataLoaded = true;
    });
  },
  computed: {
  //   totalSeats() {
  //     if (Array.isArray(this.viewingTour.flight_tickets)) {
  //       return this.viewingTour.flight_tickets.reduce((total, ticket) => total + Number(ticket.seat), 0);
  //     } else {
  //       return 0;
  //     }
  //   },
  //   // other computed properties...
      filteredTours() {
      return this.tours.filter(tour => {
        return (!this.searchPackageName || tour.package_name.toLowerCase().includes(this.searchPackageName.toLowerCase())) &&
        (!this.searchDepartureDate || moment(tour.departure_date).format('YYYY-MM-DD') === moment(this.searchDepartureDate).format('YYYY-MM-DD')) &&
        (!this.searchAirline || tour.airline.toLowerCase().includes(this.searchAirline.toLowerCase()));
      });
    },
    filteredFlightTickets() {
      return this.flight_tickets.filter(ticket => {
        let matchesText = true;
        let matchesDate = true;

        if (this.searchText) {
          // 这里假设你想在 'pnr', 'airline', 'to' 这些字段中搜索
          matchesText = ['pnr', 'airline', 'to'].some(field => 
            String(ticket[field]).toLowerCase().includes(this.searchText.toLowerCase())
          );
        }

        if (this.searchDate) {
          matchesDate = moment(ticket.departure_date).format('YYYY-MM-DD') === moment(this.searchDate).format('YYYY-MM-DD');
        }

        return matchesText && matchesDate;
      });
    },
  },
  methods: {
    showCountriesPage() {
      this.currentPage = 'countries';
    },
    showAddCountryPage() {
      this.currentPage = 'addCountry';
    },
    showEditCountryPage(country) {
      this.editingCountry = Object.assign({}, country);
      this.editingCountryFlightTickets = country.flight_tickets && country.flight_tickets.length > 0 ? country.flight_tickets[0].id : null;
      this.editingCountryRoles = country.roles && country.roles.length > 0 ? country.roles[0].id : null;
      this.currentPage = 'editCountry';
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
    addCountry() {
      axios.post('/api/countries', {
        name: this.name,
      })
      .then(response => {
        console.log(response.data);
        // Redirect to countries page after successful addition
        this.currentPage = 'countries';
        this.getCountries();
        // Reset the form fields
        this.name = '';
      })
      .catch(error => {
        console.log(error);
      });
    },
    editCountry() {
      axios.put(`/api/countries/${this.editingCountry.id}`, this.editingCountry)
      .then(response => {
        console.log(response.data);
        this.currentPage = 'countries';
        this.getCountries();
      })
      .catch(error => {
        console.log(error);
      });
    },
    startDeletingCountry(country) {
    this.itemToDelete = country;
    this.confirmDelete = true;
    },
    

    showFlightTicketsPage() {
      this.currentPage = 'flight_tickets';
    },
    showAddFlightTicketPage() {
      this.currentPage = 'addFlightTicket';
    },
    showEditFlightTicketPage(flight_ticket) {
      this.editingFlightTicket = Object.assign({}, flight_ticket);
      this.currentPage = 'editFlightTicket';
    },

    getFlightTickets() {
      axios.get('/api/flight_tickets')
      .then(response => {
        this.flight_tickets = response.data;
      })
      .catch(error => {
        console.log(error);
      });
    },
    addFlightTicket() {
      axios.post('/api/flight_tickets', {
        pnr: this.pnr,
        airline: this.airline,
        departure_date: this.departure_date,
        return_date: this.return_date,
        from: this.from,
        to: this.to,
        seat: this.seat,
      })
      .then(response => {
        console.log(response.data);
        // Redirect to flight_tickets page after successful addition
        this.currentPage = 'flight_tickets';
        this.getFlightTickets();
        // Reset the form fields
        this.name = '';
      })
      .catch(error => {
        console.log(error);
      });
    },
    editFlightTicket() {
      axios.put(`/api/flight_tickets/${this.editingFlightTicket.id}`, this.editingFlightTicket)
        .then(response => {
          console.log(response.data);
          // Redirect to flight_tickets page after successful update
          this.editingflight_ticket = null;
          this.currentPage = 'flight_tickets';
          this.getFlightTickets();
        })
        .catch(error => {
          console.log(error);
        });
    },
    startDeletingFlightTicket(flight_ticket) {
      this.itemToDelete = flight_ticket;
      this.confirmDelete = true;
    },
  
    showToursPage() {
      this.currentPage = 'tours';
    },
    showViewTourPage(tour) {
      this.viewingTour = { ...tour, flight_tickets: tour.flight_tickets || [] };
      this.currentPage = 'viewTour';
    },
    showAddTourPage() {
      this.currentPage = 'addTour';
    },
    // showEditTourPage(tour) {
    //   this.editingTour = Object.assign({}, tour);
    //   this.editingTourFlightTickets = tour.flight_tickets.map(ticket => ticket.id);
    //   this.currentPage = 'editTour';
    // },
    showEditTourPage(tour) {
      this.editingTour = {
        ...tour,
        departure_date: moment(tour.departure_date).toISOString(),
        return_date: moment(tour.return_date).toISOString(),
      };
      this.editingTourFlightTickets = tour.flight_tickets.map(ticket => ticket.id);
      this.currentPage = 'editTour';
    },
    updateDepartureDate(date) {
      this.editingTour.departure_date = date;
    },
    updateReturnDate(date) {
      this.editingTour.return_date = date;
    },
    showDuplicateTourPage(tour) {
      this.duplicatingTour = Object.assign({}, tour);
      this.currentPage = 'duplicateTour';
    },
    getTours() {
      axios.get('/api/tours')
      .then(response => {
        this.tours = response.data;
      })
      .catch(error => {
        console.log(error);
      });
    },
    addTour() {
      axios.post('/api/tours', {
        package_name: this.package_name,
        package_name_chinese: this.package_name_chinese,
        airline: this.airline,
        code: this.code,
        departure_date: this.departure_date,
        return_date: this.return_date,
        sp: this.sp,
        tier1: this.tier1,
        tier2: this.tier2,
        tier3: this.tier3,
        sp_c: this.sp_c,
        tier1_c: this.tier1_c,
        tier2_c: this.tier2_c,
        tier3_c: this.tier3_c,
        country_id: this.country_id,
        min_g: this.min_g,
        flight_tickets: this.selectedFlightTickets,
        remark: this.remark,
        groups: this.newTourGroups,
        roles: this.newTourRoles
      })
      .then(response => {
        console.log(response.data);
        // Redirect to tours page after successful addition
        this.currentPage = 'tours';
        this.getTours();
        // Reset the form fields
        this.name = '';
        this.email = '';
        this.password = '';
        this.newTourGroups = [];
        this.newTourRoles = [];
      })
      .catch(error => {
        console.log(error);
      });
    },
    editTour() {
      const tourData = {
        ...this.editingTour,
        departure_date: moment(this.editingTour.departure_date).format('YYYY-MM-DD HH:mm:ss'),
        return_date: moment(this.editingTour.return_date).format('YYYY-MM-DD HH:mm:ss'),
        flight_tickets: this.editingTourFlightTickets,
      };
      if (this.editingTour.password) {
        tourData.password = this.editingTour.password;
      }
      axios.put(`/api/tours/${this.editingTour.id}`, tourData)
      .then(response => {
        console.log(response.data);
        this.currentPage = 'tours';
        this.getTours(); // re-fetch all tours
        this.editingTourFlightTickets = [];
        // this.showViewTourPage(this.editingTour);
        
      })
      .catch(error => {
        console.log(error);
      });
    },
    duplicateTour() {
      axios.post(`/api/tours/${this.duplicatingTour.id}/duplicate`, this.duplicatingTour)
        .then(response => {
          // Handle success
          this.currentPage = 'tours';
          this.getTours();
        })
        .catch(error => {
          // Handle error
        });
    },
    startDeletingTour(tour) {
    this.itemToDelete = tour;
    this.confirmDelete = true;
    },

    confirmDeleteItem() {
      if (this.currentPage === 'countries') {
        axios.delete(`/api/countries/${this.itemToDelete.id}`)
          .then(() => {
            // Remove the country from the countries array
            this.countries = this.countries.filter(u => u.id !== this.itemToDelete.id);
            this.confirmDelete = false;
          })
          .catch(error => {
            console.log(error);
          });
      } else if (this.currentPage === 'flight_tickets') {
        axios.delete(`/api/flight_tickets/${this.itemToDelete.id}`)
          .then(() => {
            // Remove the flight_ticket from the flight_tickets array
            this.flight_tickets = this.flight_tickets.filter(g => g.id !== this.itemToDelete.id);
            this.confirmDelete = false;
          })
          .catch(error => {
            console.log(error);
          });
      }
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
    
  }
};
</script>
<style  scoped>
  
</style>