import 'vue-router';

declare global {
  interface Window {
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
    userOnly?: boolean;
    guestOnly?: boolean;
    adminOnly?: boolean;
    showBottomNav?: boolean;
  }
}
