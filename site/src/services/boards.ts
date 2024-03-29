import type { Boards, Board } from '@/types';
import { alovaInstance } from './instance';

export const getBoards = () => {
  return alovaInstance.Post<Boards>('/board/all');
};

export const getBoardInfo = (board_slug: string) => {
  return alovaInstance.Post<Board>(`/board/info/${board_slug}`);
};
