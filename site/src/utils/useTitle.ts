export const siteName = 'Flat BBS';

export const purnSetTitle = (title: string) => {
  document.title = `${title} - ${siteName}`;
};

export const useTitle = (ns: string) => {
  const setTitle = (title?: string) => {
    let _title = '';

    if (title) {
      _title = `${ns} :: ${title} - ${siteName}`;
    } else {
      _title = `${ns} - ${siteName}`;
    }
    document.title = _title;
  };

  return { setTitle };
};
