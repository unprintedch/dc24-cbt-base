/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./blocks/**/*.php"],
  theme: {
    extend: {
            fontSize: {
                'h4': '1.25rem', // added font size for h4
            },
    },
  },
  plugins: [],

}

module.exports = {
  theme: {
    extend: {
      fontSize: {
    'h4': '1.25rem',  // for example, 20px
},
    }
  }
};
