/** @type {import('tailwindcss').Config} */ 
module.exports = {
    content: [
        // Paths to your templates...
        "../**.php",
        "../**/**.php",
        "./assets/src/js/**.js"
    ],

    theme: {
        extend: {},
    },

    variants: {},

    plugins: [],
}