import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],
    darkMode: 'class', // or 'media'

    theme: {
        extend: {
            backgroundImage: {
                'linear-pattern': "url('/img/body-bg.png')",
                'kone': "url('/img/kone.webp')",
            },
            colors: {
                'gray-950' : '#0A0D0F',
                'gray-900' : '#1F262E',
                'gray-800' : '#29323D',
                'gray-700' : '#3E4C5B',
                'gray-600' : '#52657A',
                'gray-500' : '#677E98',
                'gray-400' : '#8598AD',
                'gray-300' : '#A4B2C1',
                'gray-200' : '#C2CBD6',
                'gray-100' : '#E1E5EA',
                'gray-050' : '#F0F2F5',

                'blue-950' : '#000D1A',
                'blue-900' : '#011A32',
                'blue-800' : '#053461',
                'blue-700' : '#0F4D8A',
                'blue-600' : '#1A67B2',
                'blue-500' : '#0080FF',
                'blue-400' : '#339AFF',
                'blue-300' : '#79B4EC',
                'blue-200' : '#A3CDF5',
                'blue-100' : '#CFE6FC',
                'blue-050' : '#E5F3FF',
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
