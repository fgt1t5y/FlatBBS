export const genForm = <T>(data: T) => {
  const form = new FormData();

  for (var item in data) {
    form.append(item, data[item] as string);
  }

  return form;
};
