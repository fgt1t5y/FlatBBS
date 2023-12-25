import { genForm } from '@/utils';
import { requester } from './instance';
import type {
  CommonListForm,
  CreateTopicForm,
  RequestResult,
  Topic,
} from '@/types';

export const getAllTopics = (last: number, limit: number) => {
  const form = genForm<CommonListForm>({
    last: last,
    limit: limit,
  });

  return requester.post<RequestResult<Topic[]>>('/topic/all', form);
};

export const getTopicsByBoardSlug = (
  last: number,
  limit: number,
  board_slug: number,
) => {
  const form = genForm<CommonListForm>({
    last: last,
    limit: limit,
  });

  return requester.post<RequestResult<Topic[]>>(
    `/topic/list/${board_slug}`,
    form,
  );
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
