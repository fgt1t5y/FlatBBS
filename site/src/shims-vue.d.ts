import type { MessageApiInjection } from 'naive-ui/es/message/src/MessageProvider';
import 'vue-router';

declare global {
  interface Window {
    $message: MessageApiInjection;
    $code: {
      OK: 200;
      BAD_REQUEST: 400;
      UNAUTHORIZED: 401;
      FORBIDDEN: 403;
      NOT_FOUND: 404;
      INTERNAL_ERROR: 500;
    };
  }
}

declare module 'vue-router' {
  interface RouteMeta {
    title?: string;
    memberOnly?: boolean;
    guestOnly?: boolean;
    showBottomNav?: boolean;
  }
}
