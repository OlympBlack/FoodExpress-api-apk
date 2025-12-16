import forms from "@tailwindcss/forms";

module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        primary: '#0A1F44',
        accent: '#FFA500',
      },
    },
  },
  plugins: [forms()],
};
