/// <reference types="vite/client" />

declare module '*.vue' {
  const component: ComponentOptions | ComponentOptions['setup'];
  export default component;
}
