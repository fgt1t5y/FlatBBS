import { createTopic } from '@/services';
import type { Topic, TopicDraft } from '@/types';
import { reactive, ref } from 'vue';

export const useTopic = (callback?: (data: Topic) => any) => {
  const isLoading = ref<boolean>(false);
  const isFailed = ref<boolean>(false);
  const result = ref<Topic | undefined>(undefined);

  const draft = reactive<TopicDraft>({
    title: '',
    content: '',
    board_id: 0,
  });

  const submit = () => {
    isLoading.value = true;
    createTopic(draft.title, draft.content ?? '无正文', draft.board_id)
      .then((res) => {
        if (res.data.code > 0) return;
        result.value = res.data.data;
        if (result.value) {
          callback && callback(result.value);
        }
      })
      .catch(() => {
        isFailed.value = true;
      })
      .finally(() => {
        isLoading.value = false;
      });
  };

  return { isLoading, draft, submit };
};
