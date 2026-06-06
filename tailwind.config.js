import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',

    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                display: ['Playfair Display', 'Georgia', 'serif'],
            },
            colors: {
                gold: {
                    50: '#fdf8ed',
                    100: '#f9edcc',
                    200: '#f2d995',
                    300: '#ecc45e',
                    400: '#e5af2e',
                    500: '#d4a61e',
                    600: '#b38617',
                    700: '#8f6513',
                    800: '#765116',
                    900: '#634319',
                },
                rose: {
                    50: '#fdf2f4',
                    100: '#fce7ea',
                    200: '#f9d0d9',
                    300: '#f4a9b9',
                    400: '#ed7a96',
                    500: '#e05278',
                    600: '#cc335e',
                    700: '#b0254d',
                    800: '#932142',
                    900: '#7e1f3b',
                },
                night: {
                    50: '#f6f7f9',
                    100: '#eceef2',
                    200: '#d5d9e2',
                    300: '#b1b8c9',
                    400: '#8893ac',
                    500: '#6a7792',
                    600: '#556078',
                    700: '#464e62',
                    800: '#3d4353',
                    900: '#0f1119',
                },
                cream: {
                    50: '#fefcf8',
                    100: '#fdf8f0',
                    200: '#f5e9d8',
                    300: '#e8d4b8',
                    400: '#d4b890',
                    500: '#bfa07a',
                    600: '#a88862',
                    700: '#8c6e4e',
                    800: '#755a40',
                    900: '#5f4836',
                }
            },
            animation: {
                'fade-in': 'fadeIn 0.5s ease-out forwards',
                'slide-up': 'slideUp 0.5s ease-out forwards',
                'scale-in': 'scaleIn 0.3s ease-out forwards',
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0', transform: 'translateY(10px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                slideUp: {
                    '0%': { opacity: '0', transform: 'translateY(20px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                scaleIn: {
                    '0%': { opacity: '0', transform: 'scale(0.95)' },
                    '100%': { opacity: '1', transform: 'scale(1)' },
                },
            },
        },
    },

    plugins: [forms],
};
