const btnAddBlog = document.querySelector(".addLink");
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
  } else {
    document.querySelector("#addPost").style.display = "none";
    document.querySelector("#addPost").style.display = "none";
  }
});

