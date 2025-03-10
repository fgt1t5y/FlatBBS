import type { Board, Topic, Result } from '@/types';
import { alovaInstance } from './instance';

export const getBoards = () => {
  return alovaInstance.Get<Result<Board[]>>('/boards/all');
};

export const getBoardInfo = (board_slug: string) => {
  return alovaInstance.Get<Board>(`/board/${board_slug}/info`);
};

export const getTopicsByBoardSlug = (
  page: number,
  limit: number,
  board_slug: string,
) => {
  return alovaInstance.Get<Result<Topic[]>>(`/board/${board_slug}/topics`, {
    params: {
      page,
      limit,
    },
  });
};
