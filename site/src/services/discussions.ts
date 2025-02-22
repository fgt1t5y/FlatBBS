import { alovaInstance } from './instance';

export const publishDiscussion = (content: string, topic_id: number) => {
  return alovaInstance.Post(`/discussion/${topic_id}/publish`, {
    content,
  });
};
