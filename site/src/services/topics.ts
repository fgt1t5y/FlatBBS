import { alovaInstance } from './instance';
import type { Topic, Topics } from '@/types';

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

export const publishTopic = (
  title: string,
  content: string,
  board_id: number,
) => {
  return alovaInstance.Post<Topic>(`/topic/publish`, {
    title,
    content,
    board_id
  });
};
