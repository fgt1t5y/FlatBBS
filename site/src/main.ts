import { createApp } from 'vue';
import { createPinia } from 'pinia';
import ArcoVue from '@arco-design/web-vue';
import '@/style/ui.css';
import '@arco-design/web-vue/dist/arco.css';
import '@/style/bytemd.css';
import 'dayjs/locale/zh-cn';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
import App from './App.vue';
import router from './router';

dayjs.locale('zh-cn');
dayjs.extend(relativeTime);

const app = createApp(App);

app.use(createPinia());
app.use(router);
app.use(ArcoVue);

app.mount('#app');
