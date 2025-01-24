/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './frontend/**/*.{php,js}',
    './public/*.{php,js,html}',
    './index.php',
    './frontend/public/*.php'
  ],
  theme: {
    extend: {
      colors: {
        primary: {
            green: "rgb(#557A82)",
            blue: "rgb(#D2D7DE)"
        },
        neutral: {
            "off-white": "rgb(247, 247, 247)",
            "off-black": "rgb(40, 40, 40)"
        }
      }
    },
  },
  plugins: [],
}

