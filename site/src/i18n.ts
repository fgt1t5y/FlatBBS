import { createI18n } from 'vue-i18n';
import zh_CN from '@/lang/zh_CN.json';
import en_US from '@/lang/en_US.json';

export default createI18n({
  legacy: false,
  locale: window.navigator.language,
  fallbackLocale: 'zh-CN',
  messages: {
    'zh-CN': zh_CN,
    en: en_US,
  },
});
