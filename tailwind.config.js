const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    safelist: [
        'bg-green-700',
        'bg-sky-700',
        'bg-pink-700',
    ],

    theme: {
        extend: {
            colors: {
                "baby-powder":"#fffffc",
                "khaki":"#beb7a4",
                "orange-wheel":"#ff7f11",
                "coquelicot":"#ff3f00"
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
