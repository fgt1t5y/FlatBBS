import type { Discussion, RequestResult } from '@/types';
import { requester } from './instance';
import { genForm } from '@/utils';

export const getDiscussions = (topic_id: number) => {
  const form = genForm<{ topic: number }>({
    topic: topic_id,
  });

  return requester.post<RequestResult<Discussion[]>>(
    '/topic/discussions',
    form,
  );
};
