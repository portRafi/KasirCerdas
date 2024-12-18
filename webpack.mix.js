const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .vue() // Menyertakan dukungan untuk Vue
   .postCss('resources/css/app.css', 'public/css', [
       require('postcss-import'),
       require('tailwindcss'),
   ])
   .version(); // Menambahkan versi file untuk cache-busting
