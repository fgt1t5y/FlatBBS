import { createI18n } from 'vue-i18n';
import zh_CN from '@/lang/zh_CN.json';
import en_US from '@/lang/en_US.json';

export default createI18n({
  locale: window.navigator.language.replace('-', '_') ?? 'zh_CN',
  fallbackLocale: 'zh_CN',
  messages: {
    zh_CN,
    en_US,
  },
});
