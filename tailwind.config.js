/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./*.php",           // Root PHP files (e.g., index.php)
    "./admin/*.php",     // Admin PHP files (e.g., admin/index.php)
    "./**/*.php"         // Any other PHP files in subdirectories
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}

