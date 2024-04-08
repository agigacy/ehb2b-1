<template>
  <v-container fluid>
    <v-row>
      <v-col cols="12">
        <v-img
          src="/images/image_banner2.jpg"
          gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
          height="600"
        >
        <!-- <v-img
          src="https://via.placeholder.com/800x200"
          gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
          height="200"
        > -->
          <v-layout
            fill-height
            align-center
            justify-center
            ma-0
            class="white--text"
          >
            <h4 class="display-1 font-weight-thin mb-0 bottom">Welcome to Esplanad Holiday</h4>
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
            <v-btn @click="sendMessage">Send Message</v-btn>
            <ul>
              <li v-for="message in receivedMessages" :key="message">{{ message }}</li>
            </ul>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  name: 'Home',
  // Vue component options...
  data() {
    return {
      receivedMessages: [], // 用于存储接收到的消息
    };
  },
  mounted() {
    window.Echo.channel('test-channel')
      .listen('.MessageSent', (e) => {
        console.log('Event received:', e);
        this.receivedMessages.push(e.message);
      });
  },
  methods: {
    sendMessage() {
      // 发送请求到 Laravel 后端以触发广播事件
      // 这里假设你有一个路由和对应的控制器方法来处理这个请求
      axios.post('/api/send-message', { message: 'Hello, world!' })
        .then(response => {
          console.log('Message sent:', response.data);
        })
        .catch(error => {
          console.error('Error sending message:', error);
        });
    },

    // getImagePath(imageName) {
    //   return process.env.BASE_URL + 'images/' + imageName;
    // }
  }
}
</script>