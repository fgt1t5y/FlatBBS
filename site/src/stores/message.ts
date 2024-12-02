import { defineStore } from 'pinia';
import { ref } from 'vue';

import type { IMessage } from '@/types';

export const useMessage = defineStore('message', () => {
  let index = 0;
  const messages = ref<IMessage[]>([]);

  const add = (option: IMessage) => {
    messages.value.push(option);
  };

  const info = (message: string) => {
    add({
      i: index,
      message: message,
      type: 'info',
      time: 3000,
    });

    index = index + 1;
  };

  const success = (message: string) => {
    add({
      i: index + 1,
      message: message,
      type: 'success',
      time: 3000,
    });

    index = index + 1;
  };

  const error = (message: string) => {
    add({
      i: index + 1,
      message: message,
      type: 'error',
      time: 3000,
    });

    index = index + 1;
  };

  const close = (id: number) => {
    const index = messages.value.findIndex((ms) => ms.i === id);

    if (index === -1) {
      return;
    }

    messages.value.splice(index, 1);
  };

  return { messages, add, info, success, error, close };
});
