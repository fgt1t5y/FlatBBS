import { ref } from 'vue';

export const siteName = 'Flat BBS';

export const pureSetTitle = (title: string) => {
  document.title = `${title} - ${siteName}`;
};

export const useTitle = (ns: string) => {
  const current = ref<string>('');

  const setTitle = (title?: string) => {
    let _title = '';

    if (title) {
      _title = `${ns} :: ${title} - ${siteName}`;
    } else {
      _title = `${ns} - ${siteName}`;
    }
    current.value = title;
    document.title = _title;
  };

  return { current, setTitle };
};
