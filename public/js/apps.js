const hamburger = document.querySelector("#hamburger");
const menu_bar = document.querySelector("#menu-bar");

hamburger.addEventListener("click", event => {
 menu_bar.classList.toggle("open");
 event.stopPropagation();
});