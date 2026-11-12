import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            // Palette: Cocoa Kiss (sama dengan resources/css/admin/admin.css)
            colors: {
                cocoa: {
                    bitter: '#362320',  // Bitter Cocoa
                    wine: '#57091d',    // Wine Cherry
                    cherry: '#890524',  // Cherry Red
                    truffle: '#6a4e4a', // Truffle Dust
                    icing: '#d0d1c9',   // Icing Mist
                    mist: '#ecede8',    // tint terang Icing Mist (permukaan kartu)
                },
            },
        },
    },

    plugins: [forms],
};