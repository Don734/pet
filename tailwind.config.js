/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "node_modules/preline/dist/*.js",
  ],
  theme: {
    extend: {
      backgroundImage: {
        'hero-gradient': "url('/images/assets/backgrounds/hero-gradient.svg')",
        'map-image': "url('/images/assets/backgrounds/map-image.svg')",
        'wiggle': "url('/images/assets/paterns/wiggle.svg')",
        'charlie-brown': "url('/images/assets/paterns/charlie-brown.svg')",
        'bubbles': "url('/images/assets/paterns/bubbles.svg')",
        'squares-in-squares': "url('/images/assets/paterns/squares-in-squares.svg')",
        'diagonal-stripes': "url('/images/assets/paterns/diagonal-stripes.svg')",
        'zig-zag': "url('/images/assets/paterns/zig-zag.svg')",
      },
      fontFamily: {
        inter: ['Inter', 'sans-serif'],
      },
    },
  },
  plugins: [
    require('preline/plugin'),
  ],
}

