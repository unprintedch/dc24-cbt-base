const fs = require('fs');
const path = require('path');

// Read theme.json to get colors and fonts
const themeJsonPath = path.resolve(__dirname, 'theme.json');
let customColors = {};
let themeFonts = {};

if (fs.existsSync(themeJsonPath)) {
  const themeJson = JSON.parse(fs.readFileSync(themeJsonPath, 'utf8'));
  
  // Extract colors from theme.json
  if (themeJson.settings?.color?.palette) {
    themeJson.settings.color.palette.forEach(color => {
      customColors[color.slug] = color.color;
    });
  }
  
  // Extract fonts from theme.json
  if (themeJson.settings?.typography?.fontFamilies) {
    themeJson.settings.typography.fontFamilies.forEach(font => {
      themeFonts[font.slug] = font.fontFamily.split(',').map(f => f.trim().replace(/"/g, ''));
    });
  }
}

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
      ...themeFonts, // Utilise les polices de theme.json
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
      colors: customColors, // Utilise les couleurs de theme.json
    },
  },
  plugins: [],
  corePlugins: {
    //preflight: false, // This disables Preflight completely
  },
}
