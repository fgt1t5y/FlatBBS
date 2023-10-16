import type { RequestResult, BoardGroups, Board } from '@/types';
import { requester } from './instance';
import { genForm } from '@/utils';

export const getBoardGroups = () => {
  return requester.post<RequestResult<BoardGroups[]>>('/board/groups');
};

export const getBoardById = (groupId: number) => {
  const form = genForm({
    id: groupId,
  });

  return requester.post<RequestResult<Board[]>>('/board/boards', form);
};
