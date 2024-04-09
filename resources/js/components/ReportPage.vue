<template>
    <v-container>
      <v-row>
        <v-col cols="12" sm="6">
          <v-menu
            ref="menu"
            v-model="menu"
            :close-on-content-click="false"
            transition="scale-transition"
            offset-y
            min-width="auto"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-text-field
                v-model="dateRange"
                label="选择日期范围"
                prepend-icon="mdi-calendar"
                readonly
                v-bind="attrs"
                v-on="on"
              ></v-text-field>
            </template>
            <v-date-picker
              v-model="dateRange"
              range
              @input="menu = false"
            ></v-date-picker>
          </v-menu>
        </v-col>
        <v-col cols="12" sm="6">
          <v-select
            v-model="reportType"
            :items="reportTypes"
            label="报告类型"
            prepend-icon="mdi-chart-bar"
          ></v-select>
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="12">
          <!-- 数据展示区域，可以是图表或表格 -->
          <!-- 示例使用表格 -->
          <v-simple-table>
            <template v-slot:default>
              <thead>
                <tr>
                  <th class="text-left">日期</th>
                  <th class="text-left">数据</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="item in reportData" :key="item.date">
                  <td>{{ item.date }}</td>
                  <td>{{ item.value }}</td>
                </tr>
              </tbody>
            </template>
          </v-simple-table>
        </v-col>
      </v-row>
      <v-row>
        <v-col class="text-right">
          <v-btn color="primary" @click="generatePDF">导出PDF</v-btn>
        </v-col>
      </v-row>
    </v-container>
  </template>
  
  <script>
  export default {
    data() {
      return {
        menu: false,
        dateRange: [],
        reportType: '',
        reportTypes: ['每日', '每月', '每年'],
        reportData: [
          // 示例数据
          { date: '2023-01-01', value: '100' },
          // 根据实际情况添加更多数据
        ],
      };
    },
    methods: {
        async generatePDF() {
        // 实现导出PDF的逻辑
        const element = document.getElementById('report'); // 确保你的报告内容包含在此ID内
        const canvas = await html2canvas(element);
        const data = canvas.toDataURL('image/png');

        const pdf = new jsPDF({
            orientation: 'landscape',
        });
        const imgProperties = pdf.getImageProperties(data);
        const pdfWidth = pdf.internal.pageSize.getWidth();
        const pdfHeight = (imgProperties.height * pdfWidth) / imgProperties.width;

        pdf.addImage(data, 'PNG', 0, 0, pdfWidth, pdfHeight);
        pdf.save('report.pdf');
      },
      
    },
  };
  </script>