const submitContact = document.querySelector("#btnSubmitContact");

document.querySelector(".contactEmailInput").focus();

submitContact.onclick = function validFormContact() {
  const email = document.querySelector(".contactEmailInput");
  const message = document.querySelector(".messageContact");

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
  if (message.value == "") {
    document.querySelector("#errorMessage").innerHTML = "Entrer un message";
    message.focus();
    return false;
  }
  return true;
};
