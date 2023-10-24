import Cookies from 'js-cookie';

export const get = (key: string): string | null => {
  return localStorage.getItem(key);
};

export const set = (key: string, value: string): string => {
  localStorage.setItem(key, value);
  return value;
};

export const getOrSet = (key: string, if_no: string) => {
  return get(key) ?? set(key, if_no);
};

export const has = (key: string) => get(key) !== null;

export const hasToken = () => !!Cookies.get('flat_sess');

export const genForm = <T>(data: T) => {
  const form = new FormData();

  for (const item in data) {
    if (!item) continue;
    form.append(item, data[item] as string);
  }

  return form;
};

export const blobToFile = (blob: Blob, fileName: string) => {
  const file = new File([blob], fileName, { type: blob.type });
  return file;
};

export const getAvatarPaht = (avatar_file: string) => {
  return `/backend/public/usercontent/${avatar_file}`;
};
