const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: [
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            spacing: {
                '80': '20rem',
                '108': '27rem',
            },
            borderWidth: {
                '14': '14px',
            },
            container: {
                padding: '1rem'
            },
            colors: {
                background: {
                    primary: 'var(--bg-background-primary)',
                    secondary: 'var(--bg-background-secondary)',
                    tertiary: 'var(--bg-background-tertiary)',
                    form: 'var(--bg-background-form)',
                },

                copy: {
                    primary: 'var(--text-copy-primary)',
                    secondary: 'var(--text-copy-secondary)',
                    tertiary: 'var(--text-copy-tertiary)',
                },

                'border-color': {
                    primary: 'var(--border-border-color-primary)',
                    secondary: 'var(--border-border-color-secondary)',
                    tertiary: 'var(--border-border-color-tertiary)',
                },

                transparent: 'transparent',

                black: '#000',
                white: '#fff',

                green: {
                    100: '#f0fff4',
                    200: '#c6f6d5',
                    300: '#9ae6b4',
                    400: '#68d391',
                    500: '#48bb78',
                    600: '#38a169',
                    700: '#2f855a',
                    800: '#276749',
                    900: '#22543d',
                },

                gray: {
                    100: '#f7fafc',
                    200: '#edf2f7',
                    300: '#e2e8f0',
                    400: '#cbd5e0',
                    500: '#a0aec0',
                    600: '#718096',
                    700: '#4a5568',
                    800: '#2d3748',
                    900: '#1a202c',
                },
            },
            minWidth: {
                '0': '0',
                '1/4': '25%',
                '1/2': '50%',
                '3/4': '75%',
                'full': '100%',
                '768': '768px',
                '1280': '1280px'
            }
        },
    },

    variants: {
        opacity: ['responsive', 'hover', 'focus', 'disabled'],
    },

    plugins: [require('@tailwindcss/ui')],
};
