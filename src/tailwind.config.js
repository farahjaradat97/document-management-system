import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
        "./src/**/*.{html,js,jsx,ts,tsx,vue}", // include paths to your files
        "./public/**/*.html",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["DM Sans", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: "#0056D2",
                "light-primary": "#1D75E5", //for hover
                "light-gray": "#F9FAFB", // for gray background,
                "light-gray-50": "#faf9fa",
                "light-gray-200": "#E5E7EB",
                "light-gray-300": "#D1D5DB",
                "light-gray-500": "#6B7280", // for secondary text
                error: "#E11C48",
                success: "#16A34A",
                "dark-gray-700": "#374151",
                "dark-gray-800": "#1F2937",
                "dark-gray-900": "#111827", //for primary text
                "dark-gray-950": "#09090b",
            },
            screens: {
                xs: "475px",
                ...defaultTheme.screens,
            },
            boxShadow: {
                "input-shadow": "0px 1px 3px 0px #00000012",
                "btn-shadow": " 0px 1px 3px 0px #00000029",
                "modal-shadow": "0px 3px 8px 0px #00000024",
                "table-shadow": " 0px 1px 3px 0px #00000012",
            },
        },
    },

    plugins: [forms],
};
