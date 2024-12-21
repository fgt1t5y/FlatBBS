import type { Discussion, Result } from '@/types';
import { alovaInstance } from './instance';

export const getDiscussions = (
  last: number,
  limit: number,
  topic_id: number,
) => {
  return alovaInstance.Get<Result<Discussion[]>>(
    `/discussion/${topic_id}/list`,
    {
      params: {
        last,
        limit,
      },
    },
  );
};

export const publishDiscussion = (content: string, topic_id: number) => {
  return alovaInstance.Post(`/discussion/${topic_id}/publish`, {
    content,
  });
};
