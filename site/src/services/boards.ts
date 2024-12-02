import type { Board, Topic, Result } from '@/types';
import { alovaInstance } from './instance';

export const getBoards = () => {
  return alovaInstance.Post<Result<Board[]>>('/board/all');
};

export const getBoardInfo = (board_slug: string) => {
  return alovaInstance.Post<Board>(`/board/${board_slug}/info`);
};

export const getTopicsByBoardSlug = (
  last: number,
  limit: number,
  board_slug: string,
) => {
  return alovaInstance.Post<Result<Topic[]>>(`/board/${board_slug}/topics`, {
    last,
    limit,
  });
};
