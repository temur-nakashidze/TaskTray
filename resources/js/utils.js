export default function defineReactiveMagicProperty(name, rawObject) {
    document.addEventListener("alpine:init", () => {
        const instance = Alpine.reactive(rawObject);
        if (typeof instance.init === "function") instance.init();
        Alpine.magic(name, () => instance);
        window[name[0].toUpperCase() + name.slice(1)] = instance;
    });
}