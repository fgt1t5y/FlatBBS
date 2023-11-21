import type { RequestResult, Board } from '@/types';
import { requester } from './instance';
import { genForm } from '@/utils';

export const getBoards = () => {
  return requester.post<RequestResult<Board[]>>('/board/boards');
};

export const getBoardInfo = (board_id: number) => {
  const form = genForm<{ board: number }>({
    board: board_id,
  });

  return requester.post<RequestResult<Board>>('/board/info', form);
};
