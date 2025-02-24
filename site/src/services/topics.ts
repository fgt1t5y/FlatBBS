import { alovaInstance } from './instance';

import type { Topic, Result, Discussion } from '@/types';

export const getAllTopics = (last: number, limit: number) => {
  return alovaInstance.Get<Result<Topic[]>, Topic>('/topics/all', {
    params: {
      last,
      limit,
    },
  });
};

export const getDiscussionsByTopicId = (
  last: number,
  limit: number,
  topic_id: number,
) => {
  return alovaInstance.Get<Result<Discussion[]>>(
    `/topic/${topic_id}/discussions`,
    {
      params: {
        last,
        limit,
      },
    },
  );
};

export const getTopic = (topic_id: number) => {
  return alovaInstance.Get<Topic>(`/topic/${topic_id}/detail`);
};

export const publishTopic = (
  title: string,
  text: string,
  content: string,
  board_id: number,
) => {
  return alovaInstance.Post<Topic>(`/topics/publish`, {
    title,
    text,
    content,
    board_id,
  });
};

export const likeTopic = (topic_id: number) => {
  return alovaInstance.Post<number>(`/topic/${topic_id}/like`);
};
