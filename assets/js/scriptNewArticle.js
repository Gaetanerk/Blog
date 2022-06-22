const btnAddBlog = document.querySelector(".addLink");
const cancelAddBlog = document.querySelector(".cancelAddNewArticle");
const submitAddNewArticle = document.querySelector(".submitAddNewArticle");
addPost.style.display = "none";

btnAddBlog.addEventListener("click", () => {
  const addPost = document.querySelector("#addPost");
  addPost.style.display = "block";
  document.querySelector(".addTitle").focus();
});

submitAddNewArticle.addEventListener("click", (e) => {
  e.preventDefault();
  document.querySelector(".addTitle").value = "";
  document.querySelector(".addCat").value = "";
  document.querySelector(".addPict").value = "";
  document.querySelector(".addDesc").value = "";
  const addPost = document.querySelector("#addPost");
  addPost.style.display = "none";
});

cancelAddBlog.addEventListener("click", (e) => {
  e.preventDefault();
  const addPost = document.querySelector("#addPost");
  addPost.style.display = "none";
});
