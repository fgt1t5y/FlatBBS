import type { MessageApiInjection } from 'naive-ui/es/message/src/MessageProvider';

declare global {
  interface Window {
    $message: MessageApiInjection;
  }
}
