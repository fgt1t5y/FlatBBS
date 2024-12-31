import { fileURLToPath, URL } from 'node:url';
import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import { config } from './src/global';

// https://vitejs.dev/config/
export default defineConfig({
  build: {
    cssMinify: false,
    target: 'esnext'
  },
  plugins: [vue()],
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
