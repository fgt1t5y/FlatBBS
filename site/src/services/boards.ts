import type { RequestResult, BoardGroups } from '@/types';
import { requester } from './instance';

export const getBoardGroups = () => {
  return requester.post<RequestResult<BoardGroups[]>>('/board/groups');
};
