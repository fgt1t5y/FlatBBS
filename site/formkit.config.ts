import { defaultConfig } from '@formkit/vue';
import { zh } from '@formkit/i18n';
import { rootClasses } from './formkit.theme';

export default defaultConfig({
  locales: { zh },
  locale: 'zh',
  config: {
    rootClasses,
  },
});
