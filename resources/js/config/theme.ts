export const THEME = {
    colors: {
        primary: '#1a3a5c',
        primaryLight: '#2a5a8c',
        primaryDark: '#0f2440',
        secondary: '#d4a843',
        secondaryLight: '#e0c06a',
        secondaryDark: '#b8922e',
        gray: {
            50: '#f8f9fa',
            100: '#f1f3f5',
            200: '#e9ecef',
            300: '#dee2e6',
            400: '#ced4da',
            500: '#adb5bd',
            600: '#6c757d',
            700: '#495057',
            800: '#343a40',
            900: '#212529',
        },
        anthracite: '#2c2c2c',
    },
    fonts: {
        sans: "'Figtree', ui-sans-serif, system-ui, sans-serif",
    },
    container: {
        maxWidth: '1280px',
        narrowWidth: '960px',
        wideWidth: '1440px',
        padding: {
            x: '1rem',
            sm: '1.5rem',
            lg: '2rem',
        },
    },
    breakpoints: {
        xs: 375,
        sm: 640,
        md: 768,
        lg: 1024,
        xl: 1280,
        '2xl': 1536,
    },
} as const
