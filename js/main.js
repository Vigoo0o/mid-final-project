function openPopup(type) {
  let companyLink = document.getElementById("companyLink");
  let userLink = document.getElementById("userLink");

  if (type === "login") {
    companyLink.href = "./companyLogin.html";
    userLink.href = "./userLogin.html";
  } else if (type === "register") {
    companyLink.href = "companySignUp.html";
    userLink.href = "./userSignUp.html";
  }
}
