import { defineStore } from 'pinia';
import type { Board } from '@/types';
import { ref } from 'vue';
import { getBoards } from '@/services';

export const useBoardStore = defineStore('boars', () => {
  const boards = ref<Board[] | null>(null);
  const boardMap = new Map<number, string>();
  const isLoaded = ref<boolean>(false);

  const makeMap = () => {
    boards.value!.map((board) => {
      boardMap.set(board.id, board.name);
    });
  };

  const fetch = () => {
    getBoards().then((res) => {
      if (res.data.code === 0) {
        boards.value = res.data.data!;
        if (boards.value.length) {
          makeMap();
          isLoaded.value = true;
        }
      }
    });
  };

  return { fetch, isLoaded };
});
