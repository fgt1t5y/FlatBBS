import { defineStore } from 'pinia';
import { ref, nextTick } from 'vue';

export const useEditorWindow = defineStore('editor_window', () => {
  const show = ref<boolean>(false);
  // 编辑器窗口是否最小化状态
  const isMin = ref<boolean>(false);

  const showWindow = () => {
    isMin.value = false;
    show.value = true;
    const titleInput = document.getElementById('topic-title-input');
    nextTick(() => {
      titleInput!.focus();
    });
  };

  const minWindow = () => {
    show.value = false;
    isMin.value = true;
  };

  const hiddenWindow = () => {
    show.value = false;
    isMin.value = false;
  };

  return { show, isMin, minWindow, showWindow, hiddenWindow };
});
