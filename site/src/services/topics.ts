import { genForm } from '@/utils';
import { requester } from './instance';
import type { RequestResult, Topic, TopicListForm } from '@/types';

export const getTopicList = (last: number, limit: number, board_id: number) => {
  const form = genForm<TopicListForm>({
    last: last,
    limit: limit,
    board: board_id,
  });

  return requester.post<RequestResult<Topic[]>>('/topic/list', form);
};
