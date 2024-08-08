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
                poppins: ['Poppins', 'sans-serif'],
            },
            colors: {
                'indigo' : '#253B65',
                'dim-gray' : '#6C6B6E',
                'light-blue' : '#615EFC',
                'pastel-blue' : '#7895CB',
                'lavender-blue' : '#C5DFF8',
                'flash-white' : '#EEF1F5' 
            },
        },
    },

    plugins: [forms],
};
