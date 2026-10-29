import defineReactiveMagicProperty from "../utils";

defineReactiveMagicProperty("theme", {
    currentTheme: null,
    storedTheme: null,

    init() {
        this.storedTheme = localStorage.getItem("theme") ?? "system";
        this.currentTheme = computeTheme(this.storedTheme);
        applyTheme(this.currentTheme);

        let media = window.matchMedia("(prefers-color-scheme: dark)");
        media.addEventListener("change", (event) => {
            if (this.storedTheme === "system") {
                this.currentTheme = event.matches ? "dark" : "light";
                applyTheme(this.currentTheme);
            }
        });
    },

    setTheme(newTheme) {
        this.storedTheme = newTheme;
        localStorage.setItem("theme", newTheme);
        this.currentTheme = computeTheme(newTheme);
        applyTheme(this.currentTheme);
    },

    setLight() {
        this.setTheme("light");
    },
    setDark() {
        this.setTheme("dark");
    },
    setSystem() {
        this.setTheme("system");
    },

    toggle() {
        if (this.storedTheme === "system") {
            this.setTheme(this.currentTheme === "dark" ? "light" : "dark");
        } else {
            this.setTheme(this.storedTheme === "dark" ? "light" : "dark");
        }
    },

    get() {
        return {
            stored: this.storedTheme,
            current: this.currentTheme,
            isLight: this.isLight,
            isDark: this.isDark,
            isSystem: this.isSystem,
        };
    },

    get isLight() {
        return this.storedTheme === "light";
    },
    get isDark() {
        return this.storedTheme === "dark";
    },
    get isSystem() {
        return this.storedTheme === "system";
    },

    get isResolvedToLight() {
        return this.isSystem ? resolved() === "light" : this.isLight;
    },
    get isResolvedToDark() {
        return this.isSystem ? resolved() === "dark" : this.isDark;
    },
});

function computeTheme(themePreference) {
    return themePreference === "system" ? resolved() : themePreference;
}

function resolved() {
    return window.matchMedia("(prefers-color-scheme: dark)").matches
        ? "dark"
        : "light";
}

function applyTheme(theme) {
    if (theme === "dark") {
        document.documentElement.classList.add("dark");
    } else {
        document.documentElement.classList.remove("dark");
    }
}
