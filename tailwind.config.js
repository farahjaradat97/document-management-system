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

    theme: {
        extend: {
            fontFamily: {
                sans: ['DM Sans', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: '#0056D2',
                'light-primary':'#1D75E5', //for hover 
                'light-gray': '#F3F4F6', // for gray background,
                'light-gray-50':'#F9FAFB',
                'light-gray-200': '#E5E7EB',
                'light-gray-300': '#D1D5DB',
                'light-gray-500': '#6B7280', // for secondary text
                 error: '#E11C48',
                 success :'#16A34A',
                 'dark-gray-700':'#374151',
                 'dark-gray-800':'#1F2937',
                 'dark-gray-900':'#111827' //for primary text 

            },
            screens: {
                'xs': '475px',
                ...defaultTheme.screens,
              },
            boxShadow: {
                'input-shadow': '0px 1px 3px 0px #00000012',
                'btn-shadow':' 0px 1px 3px 0px #00000029',
                
            }
           
        },
    },

    plugins: [forms],
};
