const toggleSwitch = document.querySelector("#toggle-theme-input");
const currentTheme = localStorage.getItem("theme");

if (currentTheme) {
    document.documentElement.setAttribute("data-theme", currentTheme);

    if (currentTheme === "dark") {
        toggleSwitch.checked = true;
    }
    setTheme(currentTheme);
}

function switchTheme(event) {
    if (event.target.checked) {
        document.documentElement.setAttribute("data-theme", "dark");
        localStorage.setItem("theme", "dark");
        setTheme("dark");
    } else {
        document.documentElement.setAttribute("data-theme", "light");
        localStorage.setItem("theme", "light");
        setTheme("light");
    }
}
function setTheme(theme) {
    const buttons = document.querySelectorAll(".btn");

    buttons.forEach((button) => {
        button.classList.remove("btn-light", "btn-dark");
        button.classList.add(`btn-${theme}`);
    });
}
toggleSwitch.addEventListener("change", switchTheme, false);
