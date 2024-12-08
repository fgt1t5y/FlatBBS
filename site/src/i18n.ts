import { createI18n } from 'vue-i18n';
import zh_CN from '@/lang/zh_CN.json';
import en from '@/lang/en_US.json';

export default createI18n({
  legacy: false,
  locale: window.navigator.language.replace('-', '_'),
  fallbackLocale: 'zh_CN',
  messages: {
    zh_CN,
    en,
  },
});
