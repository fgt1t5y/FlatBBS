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
import { hasToken } from './utils';
import { useUserStore } from './stores';

const app = createApp(App);

window.$code = code;

app.use(createPinia());
app.use(router);
app.use(i18n);
app.use(plugin, defaultConfig(config));

if (hasToken()) {
  await useUserStore().fetch();
}

await router.isReady();

app.mount('#flatbbs');
