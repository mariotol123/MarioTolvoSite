import { defineConfig } from 'vite';

export default defineConfig({
	base: './',
	build: {
		outDir: 'dist',
		emptyOutDir: true,
		rollupOptions: {
			input: 'src/main.js',
			output: {
				entryFileNames: 'assets/[name].js',
				chunkFileNames: 'assets/[name]-[hash].js',
				assetFileNames: 'assets/[name][extname]'
			}
		}
	},
	server: {
		host: '0.0.0.0',
		port: 5173
	}
});
