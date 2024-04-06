<template>
    <div>
      <bar-chart :chart-data="chartData"></bar-chart>
    </div>
  </template>
  
  <script>
  import { Bar } from 'vue-chartjs'
  
  export default {
    components: {
      BarChart: Bar
    },
    props: {
      chartData: {
        type: Object,
        default: null
      }
    }
  }
  </script>