/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],
    theme: {
        extend: {
            colors: {
                brand: {
                    DEFAULT: '#f2a900',
                    dark: '#d89400',
                },
                ink: '#1a1a1a',
                muted: '#4a4a4a',
                line: '#e0e0e0',
                'gray-bg': '#f5f5f5',
                'admin-bg': '#f6f6f6',
                'admin-orange': '#f26522',
                'admin-orange-hover': '#d95518',
                'admin-orange-soft': '#fff4ef',
                'admin-muted': '#5c5c5c',
                'admin-line': '#e8e8e8',
            },
            fontFamily: {
                sans: ['Montserrat', 'system-ui', '-apple-system', 'sans-serif'],
                admin: ['"DM Sans"', 'system-ui', '-apple-system', 'sans-serif'],
            },
            maxWidth: {
                wrap: '1180px',
            },
        },
    },
    plugins: [],
};
