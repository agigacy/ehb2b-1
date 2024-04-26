<template>
    <v-container>
      Welcome {{ userId }}
      <v-select
        v-model="selectedTourId"
        :items="tours"
        item-value="id"
        item-text="package_name"
        label="选择 Tour"
      ></v-select>
      <v-btn color="primary" @click="fetchReportDataForSelectedTour">生成报告</v-btn>
      <div id="report-content">
        <br />
        <h1>配套: {{ package_name }}</h1>
        <p>配套华语: {{ package_name_chinese }}<br />
          国家: {{ country.name }}<br />
          配套编号: {{ code }}<br />
          预订总数: {{ bookings.length }}<br />
          乘客总数: {{ bookings.reduce((total, booking) => total + booking.passengers.length, 0) }}<br />
          总计: RM {{ bookings.reduce((total, booking) => total + booking.total, 0).toFixed(2) }}<br />
          平均每位乘客: RM {{ (bookings.reduce((total, booking) => total + booking.total, 0) / bookings.length).toFixed(2) }}
        </p>
        
        <h2>航班票信息</h2>
        <p>航空公司: {{ airline }}<br />
          出发日期: {{ departure_date }}<br />
          返回日期: {{ return_date }}
        </p>
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
        <ol v-if="bookings.length > 0">
          <li v-for="booking in bookings" :key="booking.id" style="padding-top:20px">
            预订: {{ booking.id }}, 日期: {{ booking.date }}, 总计: <b>RM {{ booking.total }}</b> ({{booking.passengers.length}} Pax)
            <h5>乘客信息:</h5>
            <ol type="a">
              <li v-for="passenger in booking.passengers" :key="passenger.id">
                <span class="pl-1">名字: <b>{{ passenger.name }}</b></span>
                <span class="pl-5">护照号: {{ passenger.passport }} </span>
                <span class="pl-5">出生日期: {{ passenger.date_of_birth }} </span>
                <span class="pl-5">联系方式: {{ passenger.hp }} </span>
                <span class="pl-5">备注: {{ passenger.remark }} </span>
              </li>
              <!-- <li v-for="passenger in booking.passengers" :key="passenger.id" style="padding-bottom:10px">
                <span class="pl-1">名字: [ <b>{{ passenger.name }}</b> ]</span>
                <span class="pl-5">护照号: [ {{ passenger.passport }} ] </span>
                <span class="pl-5">出生日期: [ {{ passenger.date_of_birth }} ] </span>
                <span class="pl-5">联系方式: [ {{ passenger.hp }} ] </span>
                <span class="pl-5">备注: [ {{ passenger.remark }} ] </span>
              </li> -->
              <!-- <li v-for="passenger in booking.passengers" :key="passenger.id" style="padding-bottom:10px">
                名字: <b>{{ passenger.name }}</b>,
                护照号: {{ passenger.passport }},
                出生日期: {{ passenger.date_of_birth }},
                联系方式: {{ passenger.hp }},
                备注: {{ passenger.remark }}
              </li> -->
            </ol>
          </li>
        </ol>
        <ol v-else>No Record Found.</ol>
        <br />
      
    </div>
    <v-btn class="fixed-bottom" v-if="bookings.length > 0" color="primary" @click="generatePDF">导出PDF</v-btn>
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
      async generatePDF() 
      {
        const headerImg = new Image();
        headerImg.src = '/images/esplanad-logo-small.png';  // Adjust the path as necessary
        await new Promise((resolve) => {
            headerImg.onload = resolve;
        });

        const element = document.getElementById('report-content');
        const canvas = await html2canvas(element, { scale: 1 });
        const contentData = canvas.toDataURL('image/png');

        const pdf = new jsPDF({
            orientation: 'portrait',
            compress: true,
            format : 'a4',
            putOnlyUsedFonts:true
        });

        const pageWidth = pdf.internal.pageSize.getWidth();
        const pageHeight = pdf.internal.pageSize.getHeight();
        const headerHeight = 16; // Height of the header image
        pdf.addImage(headerImg.src, 'PNG', 90, 2, pageWidth * 0.15, headerHeight * 0.70);

        const imgProperties = pdf.getImageProperties(contentData);
        const leftMargin = 4;
        const contentWidth = pageWidth - 2 * leftMargin;
        const scaledHeight = imgProperties.height * (contentWidth / imgProperties.width);

        let contentRemaining = scaledHeight;
        let position = 0;  // Track the position on the canvas from which we start drawing

        while (contentRemaining > 0) {
            const topMargin = headerHeight + 2;
            // const heightToDraw = Math.min(pageHeight - topMargin, contentRemaining); // either draw the full page or the remainder
            const heightToDraw = Math.min(pageHeight, contentRemaining); // not required topmargin for remainder
            pdf.addImage(contentData, 'PNG', leftMargin, topMargin - position, contentWidth, scaledHeight, undefined, 'FAST');

            contentRemaining -= heightToDraw;  // Reduce the remaining content height by the amount just drawn
            position += heightToDraw;  // Increase the canvas position

            if (contentRemaining > 0) {
                pdf.addPage();
                // Re-add the header image to each new page
                pdf.addImage(headerImg.src, 'PNG', 90, 2, pageWidth * 0.15, headerHeight * 0.70);
            }
        }

        pdf.save('tour-report.pdf');
      },

      async generatePDF_missing_leftMargin() 
      {
        const headerImg = new Image();
        headerImg.src = '/images/esplanad-logo-small.png';  // Adjust the path as necessary
        await new Promise((resolve) => {
            headerImg.onload = resolve;
        });

        const element = document.getElementById('report-content');
        const canvas = await html2canvas(element, { scale: 1 });
        const contentData = canvas.toDataURL('image/png');

        const pdf = new jsPDF({
            orientation: 'portrait',
            compress: true,
        });

        const pageWidth = pdf.internal.pageSize.getWidth();
        const pageHeight = pdf.internal.pageSize.getHeight();
        const headerHeight = 16; // Height of the header image
        pdf.addImage(headerImg.src, 'PNG', 90, 2, pageWidth * 0.15, headerHeight * 0.70);

        const imgProperties = pdf.getImageProperties(contentData);
        const contentWidth = pageWidth;
        const scaledHeight = imgProperties.height * (contentWidth / imgProperties.width);

        let contentRemaining = scaledHeight;
        let position = 0;  // Track the position on the canvas from which we start drawing

        while (contentRemaining > 0) {
            const topMargin = headerHeight + 2;
            const heightToDraw = Math.min(pageHeight - topMargin, contentRemaining); // either draw the full page or the remainder
            pdf.addImage(contentData, 'PNG', 0, topMargin - position, contentWidth, scaledHeight, undefined, 'FAST');

            contentRemaining -= heightToDraw;  // Reduce the remaining content height by the amount just drawn
            position += heightToDraw;  // Increase the canvas position

            if (contentRemaining > 0) {
                pdf.addPage();
                // Re-add the header image to each new page
                pdf.addImage(headerImg.src, 'PNG', 90, 2, pageWidth * 0.15, headerHeight * 0.70);
            }
        }

        pdf.save('tour-report.pdf');
      },

      async generatePDF_Working_But_1Page() {
        // Load the header image
        const headerImg = new Image();
        headerImg.src = '/images/esplanad-logo-small.png';  // Adjust the path as necessary
        await new Promise((resolve) => {
          headerImg.onload = resolve;
        });

        // Capture the content of the element as a canvas
        const element = document.getElementById('report-content');
        const canvas = await html2canvas(element, { scale: 1 });
        const contentData = canvas.toDataURL('image/png');

        // Create a new jsPDF instance
        const pdf = new jsPDF({
          orientation: 'portrait',
          compress: true,
        });

        // Add the header image to the PDF
        const pageWidth = pdf.internal.pageSize.getWidth();
        const headerHeight = 16; // Set the height of your header image; adjust as needed
        pdf.addImage(headerImg.src, 'PNG', 90, 2, pageWidth * 0.15, headerHeight * 0.70 );

        // Calculate position and scaling for the content
        const imgProperties = pdf.getImageProperties(contentData);
        const contentWidth = pdf.internal.pageSize.getWidth();
        const contentHeight = (imgProperties.height * contentWidth) / imgProperties.width;
        const leftMargin = 4;
        const topMargin = headerHeight + 2; // Adjust so content starts right below the header

        // Add main content image to PDF, adjust dimensions to fit the page
        pdf.addImage(contentData, 'PNG', leftMargin, topMargin, contentWidth - (2 * leftMargin), contentHeight);

        // Save the PDF
        pdf.save('tour-report.pdf');
      },

      async generatePDF_OLD() {
        const element = document.getElementById('report-content');
        // const canvas = await html2canvas(element);
        const canvas = await html2canvas(element, {
          scale: 1 // Adjust scale to reduce resolution; tweak as necessary
        });
        const data = canvas.toDataURL('image/png');

        // const pdf = new jsPDF('p', 'pt','a4', true);
        const pdf = new jsPDF({
          orientation: 'portrait',
          compress: true,

        });
        const imgProperties = pdf.getImageProperties(data);
        const pdfWidth = pdf.internal.pageSize.getWidth();
        const pdfHeight = (imgProperties.height * pdfWidth) / imgProperties.width;

        const leftMargin = 4; // Adjust as needed
        const topMargin = 2; // Adjust as needed

        // pdf.addImage(data, 'PNG', 0, 0, pdfWidth, pdfHeight);
        // Add image to PDF
        // pdf.addImage(data, 'JPEG', 0, 0, pdfWidth, pdfHeight); // Use JPEG here
        
        // Add image to PDF with left margin
        // pdf.addImage(data, 'JPEG', leftMargin, topMargin, pdfWidth - (2 * leftMargin), pdfHeight);
        pdf.addImage(data, 'PNG', leftMargin, topMargin, pdfWidth - (2 * leftMargin), pdfHeight);
        
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

    computed: {
      userId() {
        return localStorage.getItem('user_id');
      }
    }
  };
  </script>
  <style scoped>
    .fixed-bottom {
      position: fixed;
      bottom: 10px; /* Distance from the bottom of the viewport */
      left: 45%; /* Distance from the right of the viewport, adjust as necessary */
      z-index: 1000; /* Ensure it's above other content */
    }
  </style>