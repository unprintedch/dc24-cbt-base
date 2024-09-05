const fs = require('fs');
const path = require('path');

// Path to the generated JSON file
const colorsPath = path.resolve(__dirname, 'tailwind-color.json');

// Read and parse the JSON file
let customColorsArray = [];
if (fs.existsSync(colorsPath)) {
  customColorsArray = JSON.parse(fs.readFileSync(colorsPath, 'utf8'));
}

// Transform the JSON data into an object with slug as key and color as value
const customColors = customColorsArray.reduce((acc, color) => {
  acc[color.slug] = color.color;
  return acc;
}, {});


/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './template-parts/*.php',
    '*.php',
    "./blocks/**/*.php", "./css/*.css",
    "css/safelist.txt",
    "./scripts/*.js",
    "./tailwind.safelist.json",
    "./functions/*.php",
  ],
  theme: {
    fontFamily: {
      'display': ['"Krona One"', 'sans-serif'],
    },
    container: {
      center: true,
    },
    screens: {
      'sm': '100%',
      'md': '960px',
      'lg': '1140px',
      'xl': '1440px',
      '2xl': '1640px',
    },
    extend: {
      colors: customColors,
    },
  },
  plugins: [],
  corePlugins: {
    //preflight: false, // This disables Preflight completely
  },
}
