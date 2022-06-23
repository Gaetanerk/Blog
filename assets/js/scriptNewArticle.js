const btnAddBlog = document.querySelector(".addLink");
const iconMoreLess = document.querySelector("#iconAddMore");
document.querySelector("#addPost").style.display = "none";

let nbClic=0;
function compteClic() {
  nbClic++;
}

btnAddBlog.addEventListener("click", () => {
  compteClic();
  if (nbClic %2) {
    document.querySelector("#addPost").style.display = "block";
    document.querySelector(".addTitle").focus();
    btnAddBlog.textContent = "Annuler ajout d'article";
    iconMoreLess.className = "fa-solid fa-minus";
  } else {
    document.querySelector("#addPost").style.display = "none";
    btnAddBlog.textContent = "Ajouter un article";
    iconMoreLess.className = "fa-solid fa-plus";
  }
});

