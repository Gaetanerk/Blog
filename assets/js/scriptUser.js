const submitUser = document.querySelector("#btnSubmitUser");

document.querySelector(".userInput").focus();

submitUser.onclick = function () {
  const name = document.querySelector(".userInput");
  const password = document.querySelector(".passwordInput");

  if (name.value == "") {
    document.querySelector("#errorMessage").innerHTML =
      "Enter un nom d'utilisateur !";
    name.focus();
    return false;
  }
  if (password.value == "") {
    document.querySelector("#errorMessage").innerHTML =
      "Saississer votre mot de passe !";
    password.focus();
    return false;
  }
  return true;
};
