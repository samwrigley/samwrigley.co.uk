module.exports = {
    theme: {
        extend: {
            spacing: {
                '72': '18rem',
                '80': '20rem',
                '88': '22rem',
            },
            fontSize: {
                '9xl': '7rem',
                '26xl': '24rem',
            },
            rotate: {
                '4': '4deg',
            },
        },
    },
    variants: {
        margin: ['responsive', 'first', 'last'],
        backgroundColor: ['responsive', 'hover', 'focus', 'group-hover'],
        textColor: ['responsive', 'hover', 'focus', 'group-hover'],
    },
}
