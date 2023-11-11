import { config } from '@/global';
import { useBreakpoints } from '@vueuse/core';
import dayjs from 'dayjs';
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
    const value = data[item] as any;
    // 遇到文件数组 合并到一个 field
    if (Array.isArray(value)) {
      (value as File[]).map((file) => {
        form.append('avgfile[]', file);
      });
      continue;
    }
    form.append(item, value);
  }

  return form;
};

export const blobToFile = (blob: Blob, fileName: string) => {
  return new File([blob], fileName, { type: blob.type });
};

export const getAvatarPath = (avatar_file: string) => {
  return `${config.api_base}/usercontent/${avatar_file}`;
};

export const fromNow = (datetime: string) => {
  return dayjs(datetime).fromNow();
};

export const breakpoint = useBreakpoints({
  mobile: 640,
  pad: 810,
});

export const isMobile = breakpoint.smaller('mobile');
export const isPad = breakpoint.greater('mobile');
export const isDesktop = breakpoint.greater('pad');
