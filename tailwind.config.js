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
                'fade-in-down': 'fade-in-down 0.75s ease-out'
            },
        },
    },
    plugins: [
        require('@tailwindcss/typography'),
    ],
}
