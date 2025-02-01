import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        screens: {
            sm: '340px',
            md: '540px',
            lg: '768px',
            xl: '1180px',
        },
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
                lora: ["Lora", "serif"],
            },
            keyframes: {
                "fade-in-up": {
                    "0%": { opacity: "1", transform: "translateY(0)" },
                    "50%": { opacity: "0.5", transform: "translateY(-10px)" },
                    "100%": { opacity: "0", transform: "translateY(-20px)" },
                },
            },
            animation: {
                "fade-in-up": "fade-in-up 1.2s ease-in-out infinite",
            },
            colors: {
                primary: '#F7F1F0', // Light beige
                secondary: '#FD915A', // Vibrant orange
                accent: '#E5D3F9', // Soft lavender
                neutral: {
                    100: '#F3F4F6', // Light gray
                    200: '#E5E7EB', // Medium gray
                    700: '#4A5568', // Dark gray
                },
                success: '#10B981', // Green
                error: '#EF4444', // Red
            }
        },
        container: {
            center: true,
            padding: {
                DEFAULT: "12px",
                md: "32px"
            }
        }
    },

    plugins: [forms],
};
