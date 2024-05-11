/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./blocks/**/*.php"],
  theme: {
    extend: {
    },
  },
  plugins: [],
  corePlugins: {
    preflight: false, // This disables Preflight completely
  },
}
