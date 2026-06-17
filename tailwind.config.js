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
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                industrial: ['Playfair Display', 'serif'],
                mono: ['JetBrains Mono', 'monospace'],
            },
            colors: {
                aviary: {
                    oak: '#1a1410',
                    timber: '#2d241e',
                    blue: '#3b82f6',
                    rose: '#fb7185',
                    brass: '#b8860b',
                    slate: '#475569',
                    feather: '#94a3b8',
                }
            }
        },
    },

    plugins: [forms],
};
