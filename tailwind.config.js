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
        'divide-y',
        'divide-slate-400',
        'col-span-1',
        'col-span-2',
        'col-span-3',
        'col-span-4',
        'col-span-5',
        'col-span-6',
        'col-span-7',
        'col-span-8',
        'col-span-9',
        'col-span-10',
        'col-span-11',
        'col-span-12',
        'even:bg-white',
        'odd:bg-slate-50'

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
