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

export const fromNow = (datetime: string) => {
  return dayjs(datetime).fromNow();
};

export const breakpoint = useBreakpoints({
  mobile: 640,
  pad: 810,
});

export const resolveParagraph = (value: string) => {
  return value.replace(/(.*)$/gm, '<p>$1</p>');
};

export const resolveRichContent = async (value: string) => {
  if (!value) return '';
  return value
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/@(.+?)(?=\s)/gm, '<span class="mention">@$1</span>')
    .replace(
      /(https?:\/\/([-\w.]+)+(:\d+)?(\/[^\s^\n]*)?)(?=\s)/gm,
      '<a class="ilink" href="$1">$1</a>',
    )
    .replace(/^(.+)$/gm, '<p>$1</p>')
    .replace(/^$/gm, '<p></br></p>');
};

export const isMobile = breakpoint.smaller('mobile');
export const isPad = breakpoint.greater('mobile');
export const isDesktop = breakpoint.greater('pad');
export const isDev = import.meta.env.DEV;
