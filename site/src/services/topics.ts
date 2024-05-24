import { alovaInstance } from './instance';
import type { Topics } from '@/types';

export const getAllTopics = (last: number, limit: number) => {
  return alovaInstance.Post<Topics>('/topic/all', { last, limit });
};

export const getTopicsByBoardSlug = (
  last: number,
  limit: number,
  board_slug: string,
) => {
  return alovaInstance.Post<Topics>(`/topic/${board_slug}/list`, {
    last,
    limit,
  });
};
