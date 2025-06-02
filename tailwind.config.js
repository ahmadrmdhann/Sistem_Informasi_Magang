module.exports = {
    purge: [],
    darkMode: false,
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {},
    },
    variants: {
        extend: {},
    },
    plugins: [
        require('preline/plugin'),
    ],
};
