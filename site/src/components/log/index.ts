import TopicVisitLogItem from './TopicVisitLogItem.vue';
import UserVisitLogItem from './UserVisitLogItem.vue';

import type { StringComponentMap } from '@/types';

export const visitLogComponentMap: StringComponentMap = {
  topic: TopicVisitLogItem,
  user: UserVisitLogItem,
};
