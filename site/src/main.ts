import { createApp } from 'vue';
import { createPinia } from 'pinia';
import '@/style/ui.css';
import '@/style/theme.css';
import 'dayjs/locale/zh-cn';
import App from './App.vue';
import router from './router';
import { code } from '@/constants';
import { plugin, defaultConfig } from '@formkit/vue';
import config from '../formkit.config';
import i18n from './i18n';

const app = createApp(App);

window.$code = code;
app.use(createPinia());
app.use(router);
app.use(i18n)
app.use(plugin, defaultConfig(config));
app.mount('#app');
