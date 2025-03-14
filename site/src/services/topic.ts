import { alovaInstance } from './instance';

import type { Topic, Result, Discussion } from '@/types';

export const getAllTopics = (last: number, limit: number) => {
  return alovaInstance.Get<Result<Topic[]>, Topic>('/topics', {
    params: {
      last,
      limit,
    },
  });
};

export const getDiscussions = (
  page: number,
  limit: number,
  topicId: number,
) => {
  return alovaInstance.Get<Result<Discussion[]>>(
    `/topic/${topicId}/discussions`,
    {
      params: {
        page,
        limit,
      },
    },
  );
};

export const getTopic = (topicId: number) => {
  return alovaInstance.Get<Topic>(`/topic/${topicId}/detail`);
};

export const publishTopic = (
  title: string,
  text: string,
  content: string,
  boardId: number,
) => {
  return alovaInstance.Post<Topic>(`/topic/publish`, {
    title,
    text,
    content,
    boardId,
  });
};

export const likeTopic = (topicId: number) => {
  return alovaInstance.Post<number>(`/topic/${topicId}/like`);
};

export const editTopic = (
  title: string,
  text: string,
  content: string,
  topicId: number,
) => {
  return alovaInstance.Post<number>(`/topic/${topicId}/edit`, {
    title,
    text,
    content,
  });
};
