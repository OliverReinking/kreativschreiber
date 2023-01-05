const colors = require("tailwindcss/colors");
const defaultTheme = require("tailwindcss/defaultTheme");

/** @type {import('tailwindcss').Config} */
module.exports = {
    darkMode: "class",

    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./vendor/laravel/jetstream/**/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
    ],

    theme: {
        extend: {
            colors: {
                "layout-white": "#ffffff",
                "layout-50": "#fafafa",
                "layout-100": "#f5f5f5",
                "layout-200": "#e5e5e5",
                "layout-300": "#d4d4d4",
                "layout-400": "#a3a3a3",
                "layout-500": "#737373",
                "layout-600": "#525252",
                "layout-700": "#404040",
                "layout-800": "#262626",
                "layout-900": "#171717",
                "layout-black": "#000000",
                //
                sunlogo: "#a855f7",
                sunprimary: "#a855f7",
                "sunprimary-dark": "#9333ea",
                "sunprimary-darker": "#581c87",
                "sunprimary-light": "#c084fc",
                "sunprimary-lighter": "#f3e8ff",
                "on-sunprimary": "#111827",
                "on-sunprimary-light": "#111827",
                "on-sunprimary-lighter": "#111827",
                "on-sunprimary-dark": "#f9fafb",
                "on-sunprimary-darker": "#f9fafb",
                //
                nightlogo: "#ffffff",
                nightprimary: "#a855f7",
                "nightprimary-dark": "#c084fc",
                "nightprimary-darker": "#f3e8ff",
                "nightprimary-light": "#9333ea",
                "nightprimary-lighter": "#581c87",
                "on-nightprimary": "#f9fafb",
                "on-nightprimary-light": "#f9fafb",
                "on-nightprimary-lighter": "#f9fafb",
                "on-nightprimary-dark": "#111827",
                "on-nightprimary-darker": "#111827",
                //
                sunsecondary: "#a855f7",
                "sunsecondary-dark": "#9333ea",
                "sunsecondary-darker": "#581c87",
                "sunsecondary-light": "#c084fc",
                "sunsecondary-lighter": "#f3e8ff",
                "on-sunsecondary": "#111827",
                "on-sunsecondary-light": "#111827",
                "on-sunsecondary-lighter": "#111827",
                "on-sunsecondary-dark": "#f9fafb",
                "on-sunsecondary-darker": "#f9fafb",
                //
                nightsecondary: "#a855f7",
                "nightsecondary-dark": "#c084fc",
                "nightsecondary-darker": "#f3e8ff",
                "nightsecondary-light": "#9333ea",
                "nightsecondary-lighter": "#581c87",
                "on-nightsecondary": "#f9fafb",
                "on-nightsecondary-light": "#f9fafb",
                "on-nightsecondary-lighter": "#f9fafb",
                "on-nightsecondary-dark": "#111827",
                "on-nightsecondary-darker": "#111827",
            },
            fontFamily: {
                sans: ['Open Sans', 'Ubuntu', ...defaultTheme.fontFamily.sans],
                logo: ["Inconsolata", ...defaultTheme.fontFamily.sans],
                title: ["Ubuntu", "Inter", ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [
        require("@tailwindcss/forms"),
        require("@tailwindcss/typography"),
    ],
};
