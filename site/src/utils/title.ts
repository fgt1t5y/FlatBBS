export const siteName = 'Flat BBS';

export const pureSetTitle = (title: string) => {
  document.title = `${title} - ${siteName}`;
};

export const useTitle = (ns: string) => {
  const setTitle = (title?: string) => {
    let _title = '';

    if (title) {
      _title = `${ns} :: ${title} - ${siteName}`;
    } else {
      return;
    }
    document.title = _title;
  };

  return { setTitle };
};
