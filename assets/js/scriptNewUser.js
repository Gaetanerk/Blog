const submitNewUser = document.querySelector("#btnSubmitNewUser");

document.querySelector(".userInput").focus();

submitNewUser.onclick = function () {
  const name = document.querySelector(".userInput");
  const email = document.querySelector(".emailInput");
  const email2 = document.querySelector(".emailInput2");
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
  if (email2.value == "") {
    document.querySelector("#errorMessage").innerHTML = "Champ obligatoire !";
    email2.focus();
    return false;
  }
  if (password.value == "") {
    document.querySelector("#errorMessage").innerHTML =
      "Saississer votre mot de passe !";
    password.focus();
    return false;
  }
  if (email.value != email2.value) {
    document.querySelector("#errorMessage").innerHTML =
      "Les emails ne pas identiques !";
    email.focus();
    return false;
  }
  return true;
};
