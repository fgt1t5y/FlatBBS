import { createApp } from 'vue';
import { createPinia } from 'pinia';
import '@/style/theme.css';
import 'dayjs/locale/zh-cn';
import App from './App.vue';
import router from './router';
import { statusCode } from '@/constants';
import i18n from './i18n';
import { hasToken } from './utils';
import { useUserStore } from './stores';

const app = createApp(App);

window.$code = statusCode;

app.use(createPinia());

if (hasToken()) {
  await useUserStore().fetch();
}

app.use(router);
app.use(i18n);
app.mount(document.body);
