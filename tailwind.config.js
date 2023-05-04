/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            keyframes: {
                blob: {
                    '0%': {
                        transform: 'translate(0px, 0px) scale(1)',
                    },
                    '33%': {
                        transform: 'translate(30px, -50px) scale(1.1)',
                    },
                    '66%': {
                        transform: 'translate(-20px, 20px) scale(0.9)',
                    },
                    '100%': {
                        transform: 'tranlate(0px, 0px) scale(1)',
                    },
                },
                'out': {
                    from: {
                        opacity: '0',
                    },
                    to: {
                        opacity: '0',
                    }
                },
                'fade-in-down': {
                    from: {
                        opacity: '0',
                        transform: 'translateY(-25px)'
                    },
                    tp: {
                        opacity: '1',
                        transform: 'translateY(0)'
                    },
                }
            },
            animation: {
                'fade-in-down': 'fade-in-down 0.75s ease-out',
                blob: 'blob 7s infinite',
            },
        },
    },
    plugins: [
        require('@tailwindcss/typography'),
    ],
}
