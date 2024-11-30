/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './index.html',
    './src/**/*.{vue,js,ts,jsx,tsx}',
    './formkit.theme.ts',
  ],
  theme: {
    extend: {},
  },
  plugins: [],
  darkMode: ['selector', '[flat-theme="dark"]'],
}
