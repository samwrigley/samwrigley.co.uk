module.exports = {
    variants: {
        margin: ['responsive', 'last-child'],
        backgroundColor: ['responsive', 'hover', 'focus', 'group-hover'],
        textColor: ['responsive', 'hover', 'focus', 'group-hover'],
    },
    plugins: [
        function({ addVariant, e }) {
            addVariant('last-child', ({ modifySelectors, separator }) => {
                modifySelectors(({ className }) => {
                    return `.${e(`last-child${separator}${className}`)}:last-child`
                })
            })
        },
    ],
}
