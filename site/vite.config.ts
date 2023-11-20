import { fileURLToPath, URL } from 'node:url';
import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import { config } from './src/global';
import { browserslistToTargets } from 'lightningcss';
import browserslist from 'browserslist';

// https://vitejs.dev/config/
export default defineConfig({
  build: {
    cssMinify: 'lightningcss',
  },
  css: {
    transformer: 'lightningcss',
    lightningcss: {
      targets: browserslistToTargets(browserslist('>= 0.25%')),
    },
  },
  plugins: [vue()],
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url)),
    },
  },
  server: {
    port: 3901,
    proxy: {
      '/backend': {
        target: 'http://192.168.1.108:3900',
        changeOrigin: true,
        rewrite: (path: string) => path.replace(config.api_base, ''),
      },
    },
  },
});
