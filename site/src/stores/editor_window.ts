import { getOrSet, set } from '@/utils';
import { defineStore } from 'pinia';
import { ref, nextTick, reactive } from 'vue';

const KEY_LAST_DRAFT = 'flat_last_draft';

export const useEditorWindow = defineStore('editor_window', () => {
  const show = ref<boolean>(false);
  // 编辑器窗口是否最小化状态
  const isMin = ref<boolean>(false);
  const draftString = getOrSet(KEY_LAST_DRAFT, '{"title":"","content":""}');
  const draft = reactive(JSON.parse(draftString));
  const _save = () => {
    set(KEY_LAST_DRAFT, JSON.stringify(draft));
  };

  const showWindow = () => {
    isMin.value = false;
    show.value = true;
    nextTick(() => {
      const titleInput = document.getElementById('topic-title-input');
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
    _save();
  };

  return { show, isMin, draft, minWindow, showWindow, hiddenWindow };
});
