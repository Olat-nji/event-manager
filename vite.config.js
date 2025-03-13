import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/js/all-events.js",
                "resources/js/calendar/actions.js",
                "resources/js/calendar/store.js",
                "resources/js/calendar/ui.js",
                "resources/js/calendar/utils.js",
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
