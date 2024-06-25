/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./blocks/**/*.php", "./scripts/*.js"],
  theme: {
    extend: {
    },
  },
  plugins: [],
  corePlugins: {
    preflight: false, // This disables Preflight completely
  },
}
