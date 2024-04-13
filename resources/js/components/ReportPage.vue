<template>
    <v-container>
      <v-select
        v-model="selectedTourId"
        :items="tours"
        item-value="id"
        item-text="package_name"
        label="选择 Tour"
      ></v-select>
      <v-btn color="primary" @click="fetchReportDataForSelectedTour">生成报告</v-btn>
      <div id="report-content">
      <h1>配套: {{ package_name }}</h1>
      <p>配套华语: {{ package_name_chinese }}</p>
      <p>国家: {{ country.name }}</p>
      <p>配套编号: {{ code }}</p>
      <p>预订总数: {{ bookings.length }}</p>
      <p>乘客总数: {{ bookings.reduce((total, booking) => total + booking.passengers.length, 0) }}</p>
      <p>总计: {{ bookings.reduce((total, booking) => total + booking.total, 0) }}</p>
      <p>平均每位乘客: {{ (bookings.reduce((total, booking) => total + booking.total, 0) / bookings.length).toFixed(2) }}</p>
      
      <h2>航班票信息</h2>
      <p>航空公司: {{ airline }}</p>
      <p>出发日期: {{ departure_date }}</p>
      <p>返回日期: {{ return_date }}</p>
      <ul>
        <li v-for="ticket in flight_tickets" :key="ticket.id">
          航班号: {{ ticket.pnr }},
          航空公司: {{ ticket.airline }},
          出发日期: {{ ticket.departure_date }},
          返回日期: {{ ticket.return_date }},
          出发地: {{ ticket.from }},
          目的地: {{ ticket.to }},
          座位号: {{ ticket.seat }}
        </li>
      </ul>
      <h2>预订信息</h2>
      <ul>
        <li v-for="booking in bookings" :key="booking.id">
          预订: {{ booking.id }}, 日期: {{ booking.date }}, 总计: {{ booking.total }}
          <h3>乘客信息:</h3>
          <ul>
            <li v-for="passenger in booking.passengers" :key="passenger.id">
              名字: {{ passenger.name }},
              护照号: {{ passenger.passport }},
              出生日期: {{ passenger.date_of_birth }},
              联系方式: {{ passenger.hp }},
              备注: {{ passenger.remark }}
            </li>
          </ul>
        </li>
      </ul>
      
    </div>
    <v-btn color="primary" @click="generatePDF">导出PDF</v-btn>
    </v-container>
  </template>
  
  <script>
  import html2canvas from 'html2canvas';
import jsPDF from 'jspdf';
  export default {
    data() {
      return {
        tours: [], // 存储所有 Tour 的列表
        selectedTourId: null, // 存储选中的 Tour ID
        package_name: '',
        departure_date: '',
        return_date: '',
        airline: '',
        bookings: [],
        country: [],
        flight_tickets: [],
        package_name_chinese: '',
        code: '',
      };
    },created() {
      this.fetchTours();
    },
    methods: {
      async generatePDF() {
        const element = document.getElementById('report-content');
        const canvas = await html2canvas(element);
        const data = canvas.toDataURL('image/png');

        const pdf = new jsPDF({
          orientation: 'portrait',
        });
        const imgProperties = pdf.getImageProperties(data);
        const pdfWidth = pdf.internal.pageSize.getWidth();
        const pdfHeight = (imgProperties.height * pdfWidth) / imgProperties.width;

        pdf.addImage(data, 'PNG', 0, 0, pdfWidth, pdfHeight);
        pdf.save('tour-report.pdf');
      },
      async fetchTours() {
        try {
          const response = await axios.get('/api/tours'); // 假设这是获取所有 Tours 的 API 路径
          this.tours = response.data;
        } catch (error) {
          console.error('Failed to fetch tours:', error);
        }
      },
      async fetchReportDataForSelectedTour() {
        if (!this.selectedTourId) {
          alert("请选择一个 Tour。");
          return; // 如果没有选中的 Tour，直接返回
        }

        try {
          const response = await axios.get(`/api/tours/${this.selectedTourId}/report`);
          // 假设response.data直接包含了Tour的详细信息
          this.package_name = response.data.package_name;
          this.departure_date = response.data.departure_date;
          this.return_date = response.data.return_date;
          this.airline = response.data.airline;
          this.bookings = response.data.bookings;
          this.country = response.data.country;
          this.package_name_chinese = response.data.package_name_chinese;
          this.code = response.data.code;
          this.flight_tickets = response.data.flight_tickets;
        } catch (error) {
          console.error('Failed to fetch report data:', error);
        }
      },
    },
  };
  </script>