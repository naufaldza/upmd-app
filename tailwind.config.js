/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        'ub-blue': '#003d79',
        'ub-gold': '#f1c40f',
      }
    },
  },
  plugins: [],
}