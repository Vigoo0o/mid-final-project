function openPopup(type) {
  let companyLink = document.getElementById("companyLink");
  let userLink = document.getElementById("userLink");

  if (type === "login") {
    companyLink.href = "./login.php";
    userLink.href = "./login.php";
  } else if (type === "register") {
    companyLink.href = "./companySignUp.php";
    userLink.href = "./userSignUp.php";
  }
}
