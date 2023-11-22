import { genForm } from '@/utils';
import { requester } from './instance';
import type {
  CommonListForm,
  CreateTopicForm,
  RequestResult,
  Topic,
} from '@/types';

export const getTopicList = (last: number, limit: number, board_id: number) => {
  const form = genForm<CommonListForm>({
    last: last,
    limit: limit,
    id: board_id,
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
