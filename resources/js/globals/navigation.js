// Livewire navigation listeners — relocated from the inline <head> script.
// Behavior is unchanged; this only moves the code out of the layout file.

document.addEventListener("livewire:navigating", () => {
    document.documentElement.classList.add("is-navigating");
});

document.addEventListener("livewire:navigated", () => {
    window.applyTheme();
    setTimeout(() => {
        document.documentElement.classList.remove("is-navigating");
    }, 1);
});

document.addEventListener("click", (e) => {
    const link = e.target.closest("a");
    if (link && link.hasAttribute("wire:navigate")) {
        document.documentElement.classList.add("is-navigating");
    }
});