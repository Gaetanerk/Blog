const submitNewUser = document.querySelector("#btnSubmitNewUser");

document.querySelector(".userInput").focus();

submitNewUser.onclick = function validFormNewUser() {
  const name = document.querySelector(".userInput");
  const email = document.querySelector(".emailInput");
  const password = document.querySelector(".passwordInput");

  if (name.value == "") {
    document.querySelector("#errorMessage").innerHTML =
      "Enter un nom d'utilisateur !";
    name.focus();
    return false;
  }
  if (email.value == "") {
    document.querySelector("#errorMessage").innerHTML =
      "Entrer une adresse email valide !";
    email.focus();
    return false;
  }
  if (email.value.indexOf("@", 0) < 0) {
    document.querySelector("#errorMessage").innerHTML =
      "Entrer une adresse email valide !";
    email.focus();
    return false;
  }
  if (email.value.indexOf(".", 0) < 0) {
    document.querySelector("#errorMessage").innerHTML =
      "Entrer une adresse email valide !";
    email.focus();
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
