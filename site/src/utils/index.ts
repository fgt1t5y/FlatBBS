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

export const genForm = <T>(data: T) => {
  const form = new FormData();

  for (const item in data) {
    form.append(item, data[item] as string);
  }

  return form;
};
