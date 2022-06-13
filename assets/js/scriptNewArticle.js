const btnAddBlog = document.querySelector(".addLink");
const cancelAddBlog = document.querySelector(".cancelAddNewArticle");
addPost.style.display = "none";
const submitAddNewArticle = document.querySelector(".submitAddNewArticle");

function addTask() {
  const newUlBlog = document.querySelector("ul");
  const newLiBlog = document.createElement("li");
  newUlBlog.appendChild(newLiBlog);

  const newImgBlog = document.createElement("img");
  newLiBlog.appendChild(newImgBlog);
  newImgBlog.className = "newAddPict";
  const pictInput = document.querySelector(".addPict").value;
  newImgBlog.textContent = pictInput;

  const newh6Blog = document.createElement("h6");
  newLiBlog.appendChild(newh6Blog);
  newh6Blog.className = "newAddTitle";
  const titleInput = document.querySelector(".addTitle").value;
  newh6Blog.textContent = titleInput;

  const newCatBlog = document.createElement("p");
  newLiBlog.appendChild(newCatBlog);
  newCatBlog.className = "newCatBlog";
  const catInput = document.querySelector(".addCat").value;
  newCatBlog.textContent = catInput;

  const btnDetailsBlog = document.createElement("button");
  const detailBtn = document.createTextNode("Voir les détails");
  newLiBlog.appendChild(btnDetailsBlog);
  btnDetailsBlog.appendChild(detailBtn);
  btnDetailsBlog.className = "newAddBtn";

  const newPBlog = document.createElement("p");
  newLiBlog.appendChild(newPBlog);
  newPBlog.className = "newAaddDesc";
  const descInput = document.querySelector(".addDesc").value;
  newPBlog.textContent = descInput;

  newUlBlog.appendChild(newLiBlog);

  document.querySelector(".addTitle").value = "";
  document.querySelector(".addCat").value = "";
  document.querySelector(".addPict").value = "";
  document.querySelector(".addDesc").value = "";
}

submitAddNewArticle.addEventListener("click", (e) => {
  e.preventDefault();
  addTask();
  const addPost = document.querySelector("#addPost");
  addPost.style.display = "none";
});

btnAddBlog.addEventListener("click", () => {
  const addPost = document.querySelector("#addPost");
  addPost.style.display = "block";
  document.querySelector(".addTitle").focus();
});

cancelAddBlog.addEventListener("click", () => {
  const addPost = document.querySelector("#addPost");
  addPost.style.display = "none";
});
