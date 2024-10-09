import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],
    darkMode: false,
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: '#333fff', // Màu chủ đạo
                grayTitle: '#c5c5c5',
                grayContent: '#767676',
                bgfooter: '#252525',
                bgfooterBot: '#1c1c1c',
                colorContent: '#404040',
                codeProducts: '#fe9c00',
            },
            fontFamily: {
                oswald: ['Oswald', 'sans-serif'], // Thêm font Oswald
            },
        },
    },

    plugins: [forms, typography],
};
