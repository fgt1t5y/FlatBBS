import type { MessageApiInjection } from 'naive-ui/es/message/src/MessageProvider';

declare global {
  interface Window {
    $message: MessageApiInjection;
    $code: {
      OK: 0;
      BAD_REQUEST: 400;
      UNAUTHORIZED: 401;
      FORBIDDEN: 403;
      INTERNAL_ERROR: 500;
    };
  }
}
