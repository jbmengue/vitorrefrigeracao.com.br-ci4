import react from '@vitejs/plugin-react';
import path from 'node:path';
import { defineConfig } from 'vite';

export default defineConfig(({ command }) => ({
  plugins: [react()],
  base: command === 'serve' ? '/' : '/assets/',
  resolve: { alias: { '@': path.resolve(__dirname, 'resources/scripts') } },
  publicDir: false,
  build: {
    outDir: 'public/assets',
    assetsDir: '',
    emptyOutDir: false,
    manifest: 'manifest.json',
    sourcemap: false,
    rollupOptions: {
      input: path.resolve(__dirname, 'resources/scripts/main.tsx'),
      output: {
        entryFileNames: 'js/[name]-[hash].js',
        chunkFileNames: 'js/[name]-[hash].js',
        assetFileNames: (assetInfo) => {
          const ext = path
            .extname(assetInfo.name || '')
            .slice(1)
            .toLowerCase();
          if (ext === 'css') return 'css/[name]-[hash][extname]';
          if (/(png|jpe?g|gif|webp|avif|svg|ico)$/.test(ext))
            return 'images/[name]-[hash][extname]';
          if (/(woff2?|ttf|eot|otf)$/.test(ext)) return 'fonts/[name]-[hash][extname]';
          return 'assets/[name]-[hash][extname]';
        },
      },
    },
    minify: 'esbuild',
  },
  esbuild: {
    legalComments: 'none',
    drop: command === 'build' ? ['console', 'debugger'] : [],
    target: 'es2020',
  },
  server: { port: 5173, strictPort: true },
}));
