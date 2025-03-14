import { alovaInstance } from './instance';

import type { Result, Discussion, DiscussionReply } from '@/types';

export const publishDiscussion = (content: string, topicId: number) => {
  return alovaInstance.Post<Discussion>(`/discussion/publish`, {
    content,
    topicId,
  });
};

export const getDiscussionReplies = (
  page: number,
  limit: number,
  discussionId: number,
) => {
  return alovaInstance.Get<Result<DiscussionReply[]>>(
    `/discussion/${discussionId}/replies`,
    {
      params: {
        page,
        limit,
      },
    },
  );
};
