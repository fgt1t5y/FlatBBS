import type { RequestResult, Board } from '@/types';
import { requester } from './instance';

export const getBoards = () => {
  return requester.post<RequestResult<Board[]>>('/board/boards');
};
