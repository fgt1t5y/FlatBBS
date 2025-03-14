import { alovaInstance } from './instance';

export const publishDiscussion = (content: string, topicId: number) => {
  return alovaInstance.Post(`/discussion/publish`, {
    content,
    topicId,
  });
};
