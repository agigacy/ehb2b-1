<template>
  <v-container fluid>
    <v-row>
      <v-col cols="12">
        <v-img
          src="https://via.placeholder.com/800x200"
          gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
          height="200"
        >
          <v-layout
            fill-height
            align-center
            justify-center
            ma-0
            class="white--text"
          >
            <h1 class="display-2 font-weight-thin mb-4">Welcome to Our Website</h1>
          </v-layout>
        </v-img>
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="12">
        <v-card>
          <v-card-title>Content</v-card-title>
          <v-card-text>
            <!-- Add your content here -->
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  // Vue component options...
};
</script>