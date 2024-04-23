import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",

        // Hyco Prod
        "./vendor/akhmads/hyco/src/View/Components/**/*.php",
        "./vendor/akhmads/hyco-sample/src/resources/views/**/*.php",

        // Hyco Dev
        "./packages/akhmads/hyco/src/View/Components/**/*.php",
        "./packages/akhmads/hyco-sample/src/resources/views/**/*.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
