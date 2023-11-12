import { genForm } from '@/utils';
import { requester } from './instance';
import type {
  CreateTopicForm,
  RequestResult,
  Topic,
  TopicListForm,
} from '@/types';

export const getTopicList = (last: number, limit: number, board_id: number) => {
  const form = genForm<TopicListForm>({
    last: last,
    limit: limit,
    board: board_id,
  });

  return requester.post<RequestResult<Topic[]>>('/topic/list', form);
};

export const createTopic = (
  title: string,
  content: string,
  board_id: number,
) => {
  const form = genForm<CreateTopicForm>({
    title: title,
    content: content,
    board: board_id,
  });

  return requester.post<RequestResult<Topic>>('/topic/create', form);
};
