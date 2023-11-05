import type { BytemdPlugin } from 'bytemd';

const svg = `<svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor" class="arco-icon arco-icon-at" style="font-size: 32px;" stroke-width="4" stroke-linecap="butt" stroke-linejoin="miter" filter="at" data-v-2bc6460e=""><path d="M31 23a7 7 0 1 1-14 0 7 7 0 0 1 14 0Zm0 0c0 3.038 2.462 6.5 5.5 6.5A5.5 5.5 0 0 0 42 24c0-9.941-8.059-18-18-18S6 14.059 6 24s8.059 18 18 18c4.244 0 8.145-1.469 11.222-3.925"></path></svg>`;

export const mentionPlugin = (): BytemdPlugin => {
  return {
    actions: [
      {
        title: '提及用户',
        icon: svg,
        cheatsheet: '@用户名',
        handler: {
          type: 'action',
          shortcut: 'Ctrl-M',
          click(ctx) {
            ctx.wrapText(' @', '');
            ctx.editor.focus();
          },
        },
      },
    ],
  };
};
