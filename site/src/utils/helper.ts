import { config } from '@/global';
import { useBreakpoints, breakpointsTailwind } from '@vueuse/core';
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

export const clearToken = () => Cookies.remove('flat_sess');

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

export const formatTime = (datetime: string) => {
  const localTime = dayjs.utc(datetime).tz(config.time_zone);
  return [localTime.format('LLL'), localTime.fromNow()];
};

export const breakpoint = useBreakpoints(breakpointsTailwind);

export const resolveParagraph = (value: string) => {
  return value.replace(/(.*)$/gm, '<p>$1</p>');
};

export const isMobile = breakpoint.smaller('sm');
export const isPad = breakpoint.greater('sm');
export const isDesktop = breakpoint.greater('lg');
export const isDev = import.meta.env.DEV;
