import { alovaInstance } from './instance';

export const publishDiscussion = (content: string, topicId: number) => {
  return alovaInstance.Post(`/discussion/${topicId}/publish`, {
    content,
  });
};
