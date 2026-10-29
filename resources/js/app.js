import rover from "@sheaf/rover";
import "./globals/theme.js";
import "./globals/navigation.js";
import "./globals/modals.js";
import "./components/select.js";
import "./components/slider.js";
import "./components/progress.js";
import "./components/combobox.js";
import "./components/autocomplete.js";
import "./components/calendar/index.js";
import "./components/date-picker/index.js";
import "./components/time-picker/index.js";

document.addEventListener("alpine:init", () => {
    Alpine.plugin(rover);
});
