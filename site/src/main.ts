import { createApp } from 'vue';
import { createPinia } from 'pinia';
import '@/style/ui.css';
import '@/style/theme.css';
import 'dayjs/locale/zh-cn';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
import timezone from 'dayjs/plugin/timezone';
import utc from 'dayjs/plugin/utc';
import LocalizedFormat from 'dayjs/plugin/localizedFormat';
import App from './App.vue';
import router from './router';
import { code } from '@/constants';
import { plugin, defaultConfig } from '@formkit/vue';
import config from '../formkit.config';
import i18n from './i18n';

dayjs.locale('zh-cn');
dayjs.extend(utc);
dayjs.extend(timezone);
dayjs.extend(relativeTime);
dayjs.extend(LocalizedFormat);

const app = createApp(App);

window.$code = code;
app.use(createPinia());
app.use(router);
app.use(i18n)
app.use(plugin, defaultConfig(config));
app.mount('#app');
