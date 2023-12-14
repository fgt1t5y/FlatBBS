import type { RequestResult, Board } from '@/types';
import { requester } from './instance';

export const getBoards = () => {
  return requester.post<RequestResult<Board[]>>('/board/all');
};

export const getBoardInfo = (board_id: number) => {
  return requester.post<RequestResult<Board>>(`/board/info/${board_id}`);
};
