import type { CommonListForm, Discussion, RequestResult } from '@/types';
import { requester } from './instance';
import { genForm } from '@/utils';

export const getDiscussions = (
  last: number,
  limit: number,
  topic_id: number,
) => {
  const form = genForm<CommonListForm>({
    last: last,
    limit: limit,
  });

  return requester.post<RequestResult<Discussion[]>>(
    `/discussion/list/${topic_id}`,
    form,
  );
};
