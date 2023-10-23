import { genForm } from '@/utils';
import { requester } from './instance';
import type { TopicListForm } from '@/types';

export const getTopicList = (last: number, limit: number) => {
  const form = genForm<TopicListForm>({
    last: last ?? 0,
    limit: limit,
  });

  return requester.post('/topic/list', form);
};
