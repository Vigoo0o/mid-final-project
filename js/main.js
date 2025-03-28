function openPopup(type) {
  let companyLink = document.getElementById("companyLink");
  let userLink = document.getElementById("userLink");

  if (type === "login") {
    companyLink.href = "./login.html";
    userLink.href = "./login.html";
  } else if (type === "register") {
    companyLink.href = "./companySignUp.html";
    userLink.href = "./userSignUp.html";
  }
}
