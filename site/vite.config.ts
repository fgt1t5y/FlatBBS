import { fileURLToPath, URL } from 'node:url';
import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import { config } from './src/global';
import tailwindcss from '@tailwindcss/vite';

// https://vitejs.dev/config/
export default defineConfig({
  build: {
    cssMinify: false,
    target: 'esnext',
    rollupOptions: {
      output: {
        chunkFileNames(chunkInfo) {
          const name =
            chunkInfo.name.endsWith('.vue_vue_type_style_index_0_lang') ||
            chunkInfo.name.endsWith('.vue_vue_type_script_setup_true_lang')
              ? chunkInfo.name.split('.')[0]
              : chunkInfo.name;
          return `assets/${name}-[hash].js`;
        },
      },
    },
  },
  plugins: [vue(), tailwindcss()],
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url)),
    },
  },
  server: {
    port: 3901,
    // 开发用反向代理
    proxy: {
      '/backend': {
        target: 'http://127.0.0.1:3900',
        changeOrigin: true,
        rewrite: (path: string) => path.replace(config.api_base, ''),
      },
    },
  },
});
