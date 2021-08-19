let modalOkButton = document.getElementById('modal_ok_button');
let buttonShowCGU = document.getElementById('button_show_CGU');
let popup = document.getElementById('popup');
let modalbg = document.getElementById("modal_background")
let modalpanel = document.getElementById("modal_panel")


buttonShowCGU.addEventListener('click', (e) => {
    popup.removeAttribute("hidden");

    setTimeout(() => {
        toggleAllClasses(modalbg, "ease-out duration-300 opacity-0 ease-in duration-500 opacity-100")
        toggleAllClasses(modalpanel, "ease-in duration-500 ease-out duration-300 opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95 opacity-100 translate-y-0 sm:scale-100")

    }, 50)
});


modalOkButton.addEventListener('click', (e) => {
    toggleAllClasses(modalbg, "ease-out duration-300 opacity-0 ease-in duration-500 opacity-100")
    toggleAllClasses(modalpanel, "ease-in duration-500 ease-out duration-300 opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95 opacity-100 translate-y-0 sm:scale-100")

    setTimeout(() => {
        popup.setAttribute("hidden", true);
    }, 350)

});


function toggleAllClasses(element, classList) {
    classList.split(" ").forEach(classToToggle => element.classList.toggle(classToToggle));
}