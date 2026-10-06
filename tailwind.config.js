import defaultTheme from 'tailwindcss/defaultTheme';

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
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    indigo: '#4F46E5',    // DTL Primary Accent[cite: 5]
                    hover: '#4338CA',
                    navy: '#0F172A',      // Enterprise Deep Navy[cite: 6]
                    surface: '#1E293B',
                    light: '#F8FAFC',     // Crisp background
                    border: '#E2E8F0',
                    slate: '#475569'
                }
            }
        },
    },
    plugins: [],
};