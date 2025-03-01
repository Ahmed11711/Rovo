import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";
import typography from "@tailwindcss/typography";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./vendor/laravel/jetstream/**/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./node_modules/flowbite/**/*.js",
        "./Modules/**/*.blade.php",
    ],

    theme: {
        extend: {
            fill: {
                skin: {
                    base: withOpacity("--color-base"),
                },
            },
            textColor: {
                skin: {
                    base: withOpacity("--color-base"),
                },
            },
            backgroundColor: {
                skin: {
                    base: withOpacity("--color-base"),
                },
            },
            borderColor: {
                skin: {
                    base: withOpacity("--color-base"),
                },
            },
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            animation: {
                blink: "blink 1s infinite", // Define the blink animation
            },
            keyframes: {
                blink: {
                    "0%, 100%": { opacity: 1 },
                    "50%": { opacity: 0.5 },
                },
            },

            variants: {
                space: ["responsive", "direction"],
            },
        },
    },

    plugins: [
        forms,
        typography,
        require("flowbite/plugin"),
        require("@tailwindcss/forms"),
    ],
};

function withOpacity(variableName) {
    return ({ opacityValue }) => {
        if (opacityValue !== undefined) {
            return `rgba(var(${variableName}), ${opacityValue})`;
        }
        return `rgb(var(${variableName}))`;
    };
}
