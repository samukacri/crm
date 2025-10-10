/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./packages/Webkul/Admin/src/Resources/views/**/*.blade.php",
    "./packages/Webkul/Admin/src/Resources/assets/js/**/*.js",
    "./packages/Webkul/Admin/src/Resources/assets/js/**/*.vue",
    "./packages/Webkul/**/*.blade.php",
    "./packages/Webkul/**/*.js",
    "./packages/Webkul/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        brandColor: '#2563eb',
      },
    },
  },
  plugins: [],
}