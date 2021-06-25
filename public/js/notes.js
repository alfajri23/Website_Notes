const plus = document.querySelector("#add-notes-logo");
const add_notes = document.querySelector("#add-notes");
// const edit = document.querySelector(".edit");

plus.addEventListener("click", event => {
 add_notes.classList.toggle("open");
 // event.stopPropagation();
});

// edit.addEventListener("click", event => {
//  add_notes.classList.toggle("open");
// });