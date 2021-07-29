const hamburger = document.querySelector("#hamburger");
const menu_bar = document.querySelector("#menu-bar");
const main_page = document.querySelector("#main-page");

hamburger.addEventListener("click", event => {
    menu_bar.classList.toggle("open");
    main_page.classList.toggle("open");
    event.stopPropagation();
});