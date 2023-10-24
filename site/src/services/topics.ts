import { genForm } from '@/utils';
import { requester } from './instance';
import type { RequestResult, Topic, TopicListForm } from '@/types';

export const getTopicList = (last: number, limit: number) => {
  const form = genForm<TopicListForm>({
    last: last,
    limit: limit,
  });

  return requester.post<RequestResult<Topic[]>>('/topic/list', form);
};
