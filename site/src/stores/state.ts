import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useStateStore = defineStore('global_state', () => {
  const showSearchPanel = ref<boolean>(false);

  return { showSearchPanel };
});
