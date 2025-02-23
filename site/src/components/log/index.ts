import TopicVisitLog from './TopicVisitLog.vue';
import UserVisitLog from './UserVisitLog.vue';

import type { StringComponentMap } from '@/types';

export const visitLogComponentMap: StringComponentMap = {
  'topic': TopicVisitLog,
  'user': UserVisitLog,
};
