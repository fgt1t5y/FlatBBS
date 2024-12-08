import { createI18n } from 'vue-i18n';
import zh_CN from '@/lang/zh_CN.json';

export default createI18n({
  legacy: false,
  locale: window.navigator.language.replace('-', '_') ?? 'zh_CN',
  fallbackLocale: 'zh_CN',
  messages: {
    zh_CN,
  },
});
