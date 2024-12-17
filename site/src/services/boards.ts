import type { Board, Topic, Result } from '@/types';
import { alovaInstance } from './instance';

export const getBoards = () => {
  return alovaInstance.Get<Result<Board[]>>('/board/all');
};

export const getHotspotBoards = () => {
  return alovaInstance.Get<Board[]>('/board/hotspot');
};

export const getBoardInfo = (board_slug: string) => {
  return alovaInstance.Get<Board>(`/board/${board_slug}/info`);
};

export const getTopicsByBoardSlug = (
  last: number,
  limit: number,
  board_slug: string,
) => {
  return alovaInstance.Get<Result<Topic[]>>(`/board/${board_slug}/topics`, {
    params: {
      last,
      limit,
    },
  });
};
