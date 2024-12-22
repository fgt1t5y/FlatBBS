import { defaultConfig } from '@formkit/vue';
import { zh, en } from '@formkit/i18n';
import { rootClasses } from './formkit.theme';
import { getOrSet } from '@/utils';

const convertFormKitLang = () => {
  const globalLang = getOrSet('flat_language', 'zh_CN')

  switch (globalLang) {
    case 'en': {
      return 'en'
    }
    case 'zh_CN': {
      return 'zh'
    }
  }
}

export default defaultConfig({
  locales: { zh, en },
  locale: convertFormKitLang(),
  config: {
    rootClasses,
  },
});
