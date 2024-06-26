// tailwind.config.js

module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./node_modules/flowbite/**/*.js"
  ],
  theme: {
    daisyui: {
      themes: [
        {
          mytheme: {
          
 "primary": "#307CBF",
          
 "secondary": "#0600ff",
          
 "accent": "#D77C45",
          
 "neutral": "#232630",
          
 "base-100": "#fcfcfc",
          
 "info": "#007ae8",
          
 "success": "#99C67F",
          
 "warning": "#F2CA7E",
          
 "error": "#D9414E",
          },
        },
      ],
    },
    extend: {},
  },
  plugins: [
    require("daisyui"),
    require('flowbite/plugin')({
      charts: true,
    }),
  ],
}