module.exports = {
    theme: {
        extend: {
            spacing: {
                '72': '18rem',
                '80': '20rem',
                '88': '22rem',
            },
            fontSize: {
                '8xl': '6rem',
                '10xl': '8rem',
                '16xl': '14rem',
                '20xl': '18rem',
                '26xl': '24rem',
            },
            rotate: {
                '4': '4deg',
            },
            screens: {
                'xxl': '1600px',
            },
        },
    },
    variants: {
        margin: ['responsive', 'first', 'last'],
        backgroundColor: ['responsive', 'hover', 'focus', 'group-hover'],
        textColor: ['responsive', 'hover', 'focus', 'group-hover'],
    },
}
