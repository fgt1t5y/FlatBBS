export const get = (key: string, if_no: any = null): string | any => {
  const data = localStorage.getItem(key);
  return data ? data : if_no;
};

export const set = (key: string, value: string): string => {
  localStorage.setItem(key, value);
  return value;
};
