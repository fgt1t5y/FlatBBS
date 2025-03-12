import type { Board, Topic, Result } from '@/types';
import { alovaInstance } from './instance';

export const getAllBoards = () => {
  return alovaInstance.Get<Result<Board[]>>('/boards');
};

export const getBoardInfo = (board_slug: string) => {
  return alovaInstance.Get<Board>(`/board/${board_slug}/info`);
};

export const getTopicsByBoardSlug = (
  page: number,
  limit: number,
  boardSlug: string,
) => {
  return alovaInstance.Get<Result<Topic[]>>(`/board/${boardSlug}/topics`, {
    params: {
      page,
      limit,
    },
  });
};
